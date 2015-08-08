<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/3
 * Time: 下午4:38
 */
$q = $_GET['q'];
if($q != ''){
    $servername = 'localhost';
    $username = 'root';
    $password = '123456';
    $dbname = 'mysql';
    $con = new mysqli($servername,$username,$password,$dbname);
    if($con->connect_error){
        die('mysql error:'.$con->connect_errno);
    }
    $sql = 'select * from Persons where id="'.$q.'"';
    $result = $con->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo 'id:'.$row['id'].'<br />firstname:'.$row['Firstname'].'<br />lastname:'.$row['Lastname'].'<br />Age:'.$row['Age'].'<br/>'.$row['Date'];
        }
    }
    $con->close();
}

?>





