<?php
	//error_log($_SERVER[REQUEST_URI]."\n\n",3,"/tmp/wm_debug.log");

	$weixin_appId = 'sss';
	$weixin_appSecret = 'sss';
	
	list($state,$sCode) = explode('DD',$_GET['state']);
	//error_log(var_export($_GET['state'],1)."\n\n",3,"/tmp/wm_debug.log");			
	//获得授权
	if ($state == 1) {
		//error_log("step 1 \n\n",3,"/tmp/wm_debug.log");
		$jumpUrl = urlencode("http://www.tuyoo.com/weixin/weixinpoker.php");
		header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid={$weixin_appId}&redirect_uri={$jumpUrl}&response_type=code&scope=snsapi_base&state=2DD{$sCode}#wechat_redirect");
		exit();
	//通过code换取网页授权access_token
	} 
	if ($state == 2) { 
		//error_log("step 2 \n\n",3,"/tmp/wm_debug.log");
		if (empty($_GET['code'])) {
			exit("未授权");
		}
		//error_log("code:{$_GET['code']} \n\n",3,"/tmp/wm_debug.log");
		$code = $_GET['code'];
		$userBaseJson = https_request("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$weixin_appId}&secret={$weixin_appSecret}&code={$code}&grant_type=authorization_code");
		//error_log("userBaseJson:".var_export($userBaseJson,1)." \n\n",3,"/tmp/wm_debug.log");
		$userBase = json_decode($userBaseJson,true);
				
		if (!empty($userBase['errcode'])) {
			exit($userBase['errmsg']);
		}
		//error_log("userBase:".var_export($userBase,1)." \n\n",3,"/tmp/wm_debug.log");
		//检验授权凭证（access_token）是否有效
		$checkRetJson = https_request("https://api.weixin.qq.com/sns/auth?access_token={$userBase['access_token']}&openid={$userBase['openid']}");
		//error_log("checkRetJson:".var_export($checkRetJson,1)." \n\n",3,"/tmp/wm_debug.log");
		$checkRet = json_decode($checkRetJson,true);
		//error_log("checkRet:".var_export($checkRet,1)." \n\n",3,"/tmp/wm_debug.log");
		//刷新token
		if ($checkRet['errcode']  != 0) {
			$userBase = json_decode($this->https_request("https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$weixin_appId}&grant_type=refresh_token&refresh_token={$userBase['refresh_token']}"),true);
		}
				
		//拉取用户信息(需scope为 snsapi_userinfo)
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$userBase['access_token']}&openid={$userBase['openid']}&lang=zh_CN";
		$userJson = https_request($url);
		//error_log("userJson:".var_export($userJson,1)." \n\n",3,"/tmp/wm_debug.log");
		$user = json_decode($userJson,true);
		//设置js参数
		$timeSt = time();
		$randomstr = createNonceStr();
		$jsapiTicket = getJSApiTicket(getAccess($weixin_appId,$weixin_appSecret,1));
	        //error_log("jsapiTicket:".var_export($jsapiTicket,1)." \n\n",3,"/tmp/wm_debug.log");			
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$signUrl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		//error_log($signUrl."---\n",3,"/tmp/sing.txt");			
		$signature1 =sha1("jsapi_ticket={$jsapiTicket}&noncestr={$randomstr}&timestamp={$timeSt}&url={$signUrl}");
		//error_log("user:".var_export($user,1)." \n\n",3,"/tmp/wm_debug.log");
				//$this->display('weixinApi.showShareGame.html');
			//} elseif($state == 3) {
		$name = $user['nickname'];
		$headImg = $user['headimgurl'];
		$openId = $user['openid'];
		//生成三张牌
		if(rand(1,100) <= 3) {
			$card = rand(0,33);
			$pokers = '['.$card.',34,35]';
		} else {
			$baseArr = range(0,35);
			$chooseArr = array_rand($baseArr,3);
			$pokers = '['.implode(',', $chooseArr).']';
		}
                //error_log("http://gdss.touch4.me/?act=weixinApi.showShareGame&scode={$sCode}&open_id={$openId}&pokers={$pokers} \n\n",3,"/tmp/wm_debug.log");
		$data = json_decode(file_get_contents("http://gdss.touch4.me/?act=weixinApi.showShareGame&scode={$sCode}&open_id={$openId}&pokers={$pokers}&head_img=".base64_encode($headImg)."&nick_name={$name}"),true);
		//error_log("data: ".var_export($data,1)."\n\n",3,"/tmp/wm_debug.log");
		if ($data['code'] == 1) {
			$prev_pokers = $data['data']['prev_pokers'];
			$shareUrl = $data['data']['shareUrl'];
			$prev_nick_name = $data['data']['prev_nick_name'];
			$prev_head_img = base64_decode($data['data']['prev_head_img']);
			$pokers = $data['data']['now_poker'];
		}
	}			
				
				function https_request($url,$data = null){
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
					if (!empty($data)){
						curl_setopt($curl, CURLOPT_POST, 1);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					}
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					$output = curl_exec($curl);
					curl_close($curl);
					return $output;
				}
				
				function createNonceStr($length = 16) {
					$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
					$str = "";
					for ($i = 0; $i < $length; $i++) {
						$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
					}
					return $str;
				}
				
				function getJSApiTicket($token) {
			/*		$data = json_decode(file_get_contents("jsapi_ticket.json"));
					if ($data->expire_time < time()) {
						// 如果是企业号用以下 URL 获取 ticket
						// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
						$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$token}&type=jsapi";
						$retJson = https_request($url);
						error_log("retJson: {$retJson} \n\n",3,"/tmp/wm_debug1.log");
						$ret = json_decode($retJson,true);
						$ticket = $ret['ticket'];
						if ($ticket) {
						$data->expire_time = time() + 7000;
						$data->jsapi_ticket = $ticket;
						$fp = fopen("jsapi_ticket.json", "w");
						fwrite($fp, json_encode($data));
						fclose($fp);
						}
					} else {
						$ticket = $data->jsapi_ticket;
					}
					
					return $ticket;*/
					$data = json_decode(file_get_contents("http://gdss.touch4.me/?act=weixinApi.commonJSApiTicket&appid=2&token={$token}"),true);
					if ($data && $data['retcode'] == 1) {
						return $data['ticket'];
					} else {
						error_log(date("Y-m-d H:i:s").":error ticket\n",3,"/tmp/poker_err.log");
						return '';
					}
				}
				
				//获取访问权限
				function getAccess($weixin_appId,$weixin_appSecret,$must_new = 0){
					
					/*$data = json_decode(file_get_contents("access_token.json"));
					//error_log("access_token.json : ".var_export($data,1)."\n\n",3,"/tmp/wm_debug.log");
					if ($data->expire_time < time()) {
						// 如果是企业号用以下URL获取access_token
						// $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
						$output = https_request("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$weixin_appId}&secret={$weixin_appSecret}");
						//error_log("output:  ".$output."\n\n",3,"/tmp/wm_debug.log");
						$jsoninfo = json_decode($output, true);
						$access_token = $jsoninfo["access_token"];
						if ($access_token) {
						$data->expire_time = time() + 7000;
						$data->access_token = $access_token;
						$fp = fopen("access_token.json", "w");
						fwrite($fp, json_encode($data));
						fclose($fp);
						}
					} else {
					$access_token = $data->access_token;
					}
					return $access_token;*/
					$data = json_decode(file_get_contents("http://gdss.touch4.me/?act=weixinApi.commonAccess&appid=2"),true);
					if ($data && $data['retcode'] == 1) {
						return $data['token'];
					} else {
						error_log(date("Y-m-d H:i:s").":error token\n",3,"/tmp/poker_err.log");
						return '';
					}
				}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>途游抽奖</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no"/>
    <script>
        document.getElementsByTagName('html')[0].style.fontSize = document.documentElement.clientWidth/10 + 'px';
    </script>
    <style>
        body,ul{margin:0;padding:0;}
        li{list-style: none;}
        .wrap{background: url("http://gdss.touch4.me/images/weixin/share_game/bg.jpg") no-repeat;background-size:100% 100%;width:100%;height:100%;max-width:10rem;position: relative;}
        .clear{zoom:1;}
        .clear:after{content:'';display: block;height:0;clear:both;visibility: hidden;}
        header{margin: 0 0.8rem;padding-top:1rem;}
        .image{float:left;border:3px solid #f2a529;border-radius: 0.2rem;-webkit-border-radius: 0.2rem;-moz-border-radius: 0.2rem;width:1.5rem;height:1.5rem;}
        .image img{width:1.5rem;height:1.5rem;border-radius: 0.15rem;-webkit-border-radius: 0.15rem;-moz-border-radius: 0.15rem;}
        #weixinName{font-size: 0.375rem;color:#60d1ed;margin-left:0.25rem;float:left;line-height:1.65rem;height:1.65rem;}
        .life{width:7.6rem;margin:0 auto;margin-top:0.9rem;font-size: 0.78rem;color:#5cc7ff;text-align:center;}
        #pokes{width:9rem;margin:0 auto;margin-top: 0.8rem;margin-left:0.67rem;}
        #pokes li,#pokes li img{float:left;width:2.6rem;height:3.7rem;}
        #pokes li{position: relative;margin-right:0.34rem;transform: rotateY(0deg);-webkit-transform: rotateY(0deg);-moz-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);-o-transform: rotateY(0deg);transition: 1s;-moz-transition: 1s;-webkit-transition: 1s;-o-transition: 1s;}
        #pokes li img{position: absolute;left:0;top:0;}
        #pokes li img.norotate:nth-child(1){transform: rotateY(0deg);-webkit-transform: rotateY(0deg);-moz-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);-o-transform: rotateY(0deg);}
        #pokes li img:nth-child(1){transform: rotateY(180deg);-webkit-transform: rotateY(180deg);-moz-transform: rotateY(180deg);
            -ms-transform: rotateY(180deg);-o-transform: rotateY(180deg);}
        #pokes li img:nth-child(2){left:-20rem;}
        #pokes li.active{transform: rotateY(180deg);-webkit-transform: rotateY(180deg);-moz-transform: rotateY(180deg);
            -ms-transform: rotateY(180deg);-o-transform: rotateY(180deg);}
        .tuyooLogo{width:5.5rem;height:0.95rem;margin:0 auto;margin-top:0.9rem;background: url("http://gdss.touch4.me/images/weixin/share_game/tuyoLogo.png") no-repeat;background-size: 100% 100%;}
        footer{width:8rem;margin:0 auto;margin-top:1.5rem;text-align: center;line-height:1.2rem;font-size: 0.53rem;color:#f76f47;font-weight: bold;}
        .buttonLeft{float:left;margin-right:0.8rem;width:3.5rem;height:1.2rem;background: url("http://gdss.touch4.me/images/weixin/share_game/buttonBg.png") no-repeat;background-size: 100% 100%;}
        .buttonRight{float:left;width:3.5rem;height:1.2rem;background: url("http://gdss.touch4.me/images/weixin/share_game/buttonBg.png") no-repeat;background-size: 100% 100%;}
        .grey{color:grey;}
        .share{margin: 0.4rem 0.53rem 0;text-align: right;color:#ffea00;font-size:0.4rem;}
        .mask{width:100%;height:100%;background: rgba(3,24,38,0.6);position: absolute;top:0;left:0;display: none;}
        #hongbao{font-size: 0.45rem;line-height: 0.7rem;color:#fff;width:5rem;text-align: center;position: absolute;left:1.53rem;top:4.5rem;transform: rotate(-30deg);
            -webkit-transform: rotate(-30deg);-moz-transform: rotate(-30deg);-ms-transform: rotate(-30deg);-o-transform: rotate(-30deg);z-index: 1;opacity: 0; }
        .redBag{background: url("http://gdss.touch4.me/images/weixin/share_game/redBag.png") no-repeat;background-size: contain;}
        #stars{width:7.84rem;height:11rem;position: absolute;left:1.95rem;top:0;background: url("http://gdss.touch4.me/images/weixin/share_game/stars.png") no-repeat;background-size: contain;opacity: 0; }
        #hand{position: absolute;left:1.7rem;top:7.4rem;width:2.4rem;height:2.26rem;background: url("http://gdss.touch4.me/images/weixin/share_game/hands.png") no-repeat;background-size: contain;opacity:0;}
    </style>
</head>
<body>
<div class="wrap">
    <header class="clear">
        <div class="image">
            <img id="headImg" src="" />
        </div>
        <div id="weixinName"></div>
    </header>
    <div class="life">暗示你人生的三张牌</div>
    <ul id="pokes" class="clear">
        <li>
            <img src="http://gdss.touch4.me/images/weixin/share_game/trans.png" alt="途游抽奖"/>
            <img src="http://gdss.touch4.me/images/weixin/share_game/pokeBg.png" alt="途游抽奖" />
        </li>
        <li>
            <img src="http://gdss.touch4.me/images/weixin/share_game/trans.png" alt="途游抽奖"/>
            <img src="http://gdss.touch4.me/images/weixin/share_game/pokeBg.png" alt="途游抽奖" />
        </li>
        <li>
            <img src="http://gdss.touch4.me/images/weixin/share_game/trans.png" alt="途游抽奖"/>
            <img src="http://gdss.touch4.me/images/weixin/share_game/pokeBg.png" alt="途游抽奖" />
        </li>
    </ul>
    <div class="tuyooLogo"></div>
    <footer class="clear">
        <div class="buttonLeft">我也要测</div>
        <div class="buttonRight grey">分享出去</div>
    </footer>
    <div class="share">叫朋友们也来测试</div>
    <div class="mask">
        <div id="hongbao">
	  告诉你的朋友们<br /> 
	  途个开心
          <!--  有一张属于<br />
            你的红包牌<span class="redBag">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>在等你<br />
            未来已来，把握一切机会<br />
            途游棋牌，途个开心-->
        </div>
        <div id="stars"></div>
    </div>
    <div id="hand"></div>
</div>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
	if(!is_weixin()){
		alert('请通过微信分享！');
		window.close();
	}
    document.getElementsByClassName('wrap')[0].style.height = document.documentElement.clientHeight + 'px';
    var oUl = document.getElementById('pokes');
    var aLi = oUl.getElementsByTagName('li');
    var prefixPos = 'http://gdss.touch4.me/images/weixin/share_game/';
    var arr = ['1.png','2.png?1','3.png?1','4.png','5.png?1','6.png','7.png','8.png','9.png','10.png','11.png','12.png','13.png','14.png','15.png','16.png','17.png','18.png','19.png','20.png','21.png','22.png','23.png','24.png','25.png','26.png','27.png','28.png','29.png','30.png','31.png','32.png','33.png','34.png','35.png','36.png',];
    var num = <?php echo $pokers; ?>;//[1,3,5];
    var num1 = <?php echo $prev_pokers;?>;//[2,4,6];
    var hongbao = document.getElementById('hongbao');
    var star = document.getElementById('stars');
    var mask = document.getElementsByClassName('mask')[0];
    var left = document.getElementsByClassName('buttonLeft')[0];
    var right = document.getElementsByClassName('buttonRight')[0];
    var hand = document.getElementById('hand');
    var life = document.getElementsByClassName('life')[0];
    var hImg = document.getElementById('headImg');
    var weixinName = document.getElementById('weixinName');

    var fImg = '<?php echo $prev_head_img; ?>';// 朋友的头像
    var mImg = '<?php echo $headImg; ?>';// 我的头像 -->
    var fname = '<?php echo $prev_nick_name; ?>';// 朋友的名字 -->
    var mname = '<?php echo $name; ?>';// 我的名字 -->

    for(var i=0;i<arr.length;i++){
        arr[i] = prefixPos + arr[i];
    }

    /* 根据用户是否是分享进入还是直接进入的情况分别设定不同的入场动画 */
    if(num1.length){
        for(var i=0;i<aLi.length;i++){
                addClass(aLi[i].getElementsByTagName('img')[0],'norotate');
                aLi[i].getElementsByTagName('img')[0].src = arr[num1[i]];
            }
        hImg.src = fImg;
        weixinName.innerHTML = fname;
        life.innerHTML = fname + '人生的三张牌';
        left.addEventListener('touchstart',leftClick);
    }else{
        hImg.src = mImg;
        weixinName.innerHTML = mname;
        addClass(left,'grey');
        leftClick();
    }


   
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: 'wx7d3611a50fc55fab', // 必填，公众号的唯一标识
        timestamp: <?php echo $timeSt;?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo $randomstr;?>', // 必填，生成签名的随机串
        signature: '<?php echo $signature1; ?>',// 必填，签名，见附录1
        jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
    function is_weixin() { 
    	var ua = navigator.userAgent.toLowerCase(); 
    	if (ua.match(/micromessenger/i) == "micromessenger") { 
    		return true; 
    	} else { 
    		return false; 
    	} 
    } 
    
   

    function changeZ(i){
        aLi[i].className = 'active';
        aLi[i].getElementsByTagName('img')[0].src = arr[num[i]];
        setTimeout(function () {
            aLi[i].getElementsByTagName('img')[0].style.zIndex = 1;
            aLi[i].getElementsByTagName('img')[1].style.visibility = 'hidden';
        },300);
    }
    function beginAnimate(){
        startMove(aLi[0].getElementsByTagName('img')[1],{left:0});
        setTimeout(function () {
            startMove(aLi[1].getElementsByTagName('img')[1],{left:0});
        },200);
        setTimeout(function () {
            startMove(aLi[2].getElementsByTagName('img')[1],{left:0});
            setTimeout(function () {
                startMove(hand,{opacity:60}, function () {
                    startMove(hand,{left:140}, function () {
                        startMove(hand,{left:250},function(){
                            setTimeout(function () {
                                startMove(hand,{opacity:0}, function () {
                                    hand.style.visibility = 'hidden';
                                    for(var i=0;i<aLi.length;i++){
                                        aLi[i].index = i;
                                        aLi[i].act = 0;
                                        aLi[i].addEventListener('touchstart', function () {
                                            changeZ(this.index);
                                            this.act = 1;
                                            if(aLi[1].act && aLi[2].act && aLi[0].act){
                                                addClass(left,'grey');
                                                left.removeEventListener('touchstart',leftClick);
                                                removeClass(right,'grey');
                                                right.addEventListener('touchstart',rightClick);
                                            }
                                        },false);
                                    }
                                });
                            },500);
                        });
                    });
                });
            },1000);
        },400);
    }

    function leftClick(){
        for(var i=0;i<aLi.length;i++){
            aLi[i].getElementsByTagName('img')[0].src = 'http://gdss.touch4.me/images/weixin/share_game/trans.png';
            removeClass(aLi[i].getElementsByTagName('img')[0],'norotate');
        }
        life.innerHTML = '暗示你人生的三张牌';
        life.style.opacity = '0';
        hImg.src = mImg;
        weixinName.innerHTML = mname;
        startMove(life,{opacity:100});
        beginAnimate();
    }

	function setShareStatus() {
		var url = "http://gdss.tuyou.com/?act=weixinApi.setShareStatus&openid=<?php echo $openId;?>";
		$.get(url, function(data){	
			});
	}
    
    wx.ready(function () {
        wx.checkJsApi({
            jsApiList: [
                'onMenuShareTimeline',
		'onMenuShareAppMessage'
            ]
        });

        wx.onMenuShareTimeline({
            title: '我人生的三张牌居然是......，快来为我破解',
            link: 'v ',
            imgUrl: '<?php echo $headImg;?>',
            trigger: function (res) {
            //    alert('用户点击分享到朋友圈');
            },
            success: function (res) {
            	setShareStatus(); //设置分享状态             
		        window.location.href = 'http://mp.weixin.qq.com/s?__biz=MzAwNTAzMTI1Mg==&mid=206831883&idx=1&sn=26065dfb93ce12885add56108d6b6b9b#rd';
            },
            cancel: function (res) {
            //    alert('已取消');
                window.location.href = 'http://mp.weixin.qq.com/s?__biz=MzAwNTAzMTI1Mg==&mid=206831883&idx=1&sn=26065dfb93ce12885add56108d6b6b9b#rd';
            },
            fail: function (res) {
                window.location.href = 'http://mp.weixin.qq.com/s?__biz=MzAwNTAzMTI1Mg==&mid=206831883&idx=1&sn=26065dfb93ce12885add56108d6b6b9b#rd';
            }
        });

	wx.onMenuShareAppMessage({
    		title: '惊！暗示我人生的三张牌居然是......', // 分享标题
    		desc: '快来为我破解，看看你的！', // 分享描述
    		link: '<?php echo $shareUrl;?>', // 分享链接
    		imgUrl: '<?php echo $headImg;?>', // 分享图标
    type: '', // 分享类型,music、video或link，不填默认为link
    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    success: function () { 
        // 用户确认分享后执行的回调函数
    	setShareStatus(); //设置分享状态 
	window.location.href = 'http://mp.weixin.qq.com/s?__biz=MzAwNTAzMTI1Mg==&mid=206831883&idx=1&sn=26065dfb93ce12885add56108d6b6b9b#rd';
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
	window.location.href = 'http://mp.weixin.qq.com/s?__biz=MzAwNTAzMTI1Mg==&mid=206831883&idx=1&sn=26065dfb93ce12885add56108d6b6b9b#rd';
    }
});
    });
    wx.error(function (res) {
        //alert('wx.error: '+JSON.stringify(res));
    });

    function rightClick(){
        mask.style.display = 'block';
        startMove(hongbao,{opacity:100});
        startMove(star,{opacity:100});
        addClass(right,'grey');
    }

    function getStyle(obj,attr){
        if(obj.currentStyle){
            return obj.currentStyle[attr];
        }else{
            return getComputedStyle(obj)[attr];
        }
    }
    function startMove(obj, json, fn) {
        clearInterval(obj.iTimer);
        var iCur = 0;
        var iSpeed = 0;

        obj.iTimer = setInterval(function() {

            var iBtn = true;

            for ( var attr in json ) {

                var iTarget = json[attr];

                if (attr == 'opacity') {
                    iCur = Math.round(getStyle( obj, 'opacity' ) * 100);
                } else {
                    iCur = parseInt(getStyle(obj, attr));
                }

                iSpeed = ( iTarget - iCur ) / 8;
                iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);

                if (iCur != iTarget) {
                    iBtn = false;
                    if (attr == 'opacity') {
                        obj.style.opacity = (iCur + iSpeed) / 100;
                        obj.style.filter = 'alpha(opacity='+ (iCur + iSpeed) +')';
                    } else {
                        obj.style[attr] = iCur + iSpeed + 'px';
                    }
                }

            }

            if (iBtn) {
                clearInterval(obj.iTimer);
                fn && fn.call(obj);
            }

        }, 30);
    }

    function addClass(obj, sClass) {
        var aClass = obj.className.split(' ');
        if (!obj.className) {
            obj.className = sClass;
            return;
        }
        for (var i = 0; i < aClass.length; i++) {
            if (aClass[i] === sClass) return;
        }
        obj.className += ' ' + sClass;
    }

    function removeClass(obj, sClass) {
        var aClass = obj.className.split(' ');
        if (!obj.className) return;
        for (var i = 0; i < aClass.length; i++) {
            if (aClass[i] === sClass) {
                aClass.splice(i, 1);
                obj.className = aClass.join(' ');
                break;
            }
        }
    }
</script>
</body>
</html>
