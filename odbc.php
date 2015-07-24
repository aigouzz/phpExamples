<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/7/21
 * Time: 上午10:04
 */
/* ODBC:api capable to link to database
 *
 * dsn：data source name 数据源名称
 * php有自带的链接数据库的api
 * */
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'my_db';

$find = array('hello','world');
$replace = array('b','a');
$arr = array('hello','world','this');
print_r(str_replace($find,$replace,$arr));









