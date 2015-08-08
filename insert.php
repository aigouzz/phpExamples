<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/8
 * Time: 上午11:15
 */
$servername = 'localhost';
$username = 'root';
$password = '123456';
$dbname = 'my_db';

$con = new mysqli($servername,$username,$password);
if($con->connect_error){
    die('mysql error:'.$con->connect_errno);
}
$sql = 'create ';



