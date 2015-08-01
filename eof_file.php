<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/7/31
 * Time: 下午4:01
 */
$fh = fopen('drag.html','r');
while(!feof($fh)){
    echo fgets($fh);
}
fclose($fh);
?>
<?php
//fgetss($fh,1024,$tags);从所有输入中清除所有html和php标签
$time = time();
$mktime = mktime(12,05,16,8,1,2015);
echo $time.'/'.'make time:'.date("F d,Y h:i:s",$mktime);




