<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/7/20
 * Time: 下午6:34
 */
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'my_db';

$con = new mysqli($servername,$username,$password,$dbname);
if($con->connect_error){
    die('connection error:'.$con->connect_error);
}

//$stmt = $con->prepare('update Persons set Date="2015.7.23" VALUES (?) where id = 2');
//$stmt -> bind_param('s',$date);


/*$sql = 'delete from Persons where id=5';
$con->query($sql);*/
$stmt = $con->prepare('insert into Persons(Firstname,Lastname,Age,Date) values (?,?,?,?)');
$stmt->bind_param('ssis',$firstname,$lastname,$age,$date);


$firstname = 'eightth';
$lastname = 'one';
$age = 38;
date_default_timezone_set("Asia/Shanghai");
$date = date("Y.m.d");

$stmt->execute();

echo 'old record deleted and new records added successfully';


$stmt->close();
$con->close();
/*i - integer
d - double
s - string
b - BLOB boolean
 *
 *
 * */

?>