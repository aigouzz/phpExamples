<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/25
 * Time: 下午4:38
 */
$address = "http://doudizhu.tuyoo.com";
$content = file_get_contents($address);
preg_match("/(<ul\sid=\"lfUl\">[\s\S]*<\/ul>)/i",$content,$game);
preg_match("/(ul)/i",$content,$ul);
var_dump($game[0]);
var_dump($ul);
var_dump($content);


