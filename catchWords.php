<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/25
 * Time: 下午4:38
 */
$address = "http://doudizhu.tuyoo.com";
$content = file_get_contents($address);
preg_match("/<ul\sid=\"lfUl\">[\s\S]{100,2000}<\/ul>/i",$content,$game);
preg_match("/(<ul[\s\S]*>)/i",$content,$ul);
//var_dump($ul[0]);
//var_dump($content);

/*preg_match("/http:\/\/www\.[\s\S]*\.com\//i",$content,$a1);
preg_match("/get\bsome\brest/i",$content,$a2);

var_dump($a1);
var_dump($a2);

preg_match("//i",$content,$a2);*/

/*正则表达式之挖掘文本内容
 * 聚类
 * svm:support vector machine
 * k-means:algorithm
 *
 *
 * */
/*五大算法：
 * 分治算法
 * 动态规划算法
 * 贪心算法
 * 回溯法
 * 分支限界法
 *
 * 递推回溯
 * 递归
 *
 * */


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>3g.tuyoo.com</title>
    <link href="http://www.tuyoo.com/statics/css/tuyoo/main.css" rel="stylesheet" />
    <style>
        #wrap{width:639px;margin:0 auto;}
        #lfUl{background: #137b2d;}
    </style>
</head>
<body>
<div id="wrap">
    <?php echo $game[0];?>
</div>
</body>
</html>






