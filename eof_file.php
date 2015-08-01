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






