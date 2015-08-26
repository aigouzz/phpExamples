<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/25
 * Time: 下午4:38
 */
$address = "http://doudizhu.tuyoo.com";
$content = file_get_contents($address);
preg_match("/(<ul\sid=\"lfUl\">(\s*<li>\s*<a[\s\S]*<\/a>\s*<\/li>\s*){5}<\/ul>)/i",$content,$game);
preg_match("/(<ul[\s\S]*>)/i",$content,$ul);
var_dump($game);
//var_dump($ul[0]);
var_dump($content);

/*preg_match("/http:\/\/www\.[\s\S]*\.com\//i",$content,$a1);
preg_match("/get\bsome\brest/i",$content,$a2);

var_dump($a1);
var_dump($a2);

preg_match("//i",$content,$a2);*/

/*正则表达式之挖掘文本内容
 * 聚类
 * kvm
 * k-means
 *
 *
 * */
















