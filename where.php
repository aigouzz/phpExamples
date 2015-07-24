<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/7/21
 * Time: 上午8:58
 */
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'my_db';

$con = new mysqli($servername,$username,$password,$dbname);
if($con->connect_error){
    die('error is:'.$con->connect_error);
}

$sql = 'select * from Persons where Firstname = "na"';
$result = $con->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){//mysqli_fetch_array($result) = $row
        echo 'id:'.$row['id'].',Firstname:'.$row['Firstname'].',Lastname:'.$row['Lastname'].',Age:'.$row['Age'].',date:'.$row['Date'].'.<br />';
    }
}
$con->close();


?>
<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/7/21
 * Time: 上午8:58
 */
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'my_db';

$con = new mysqli($servername,$username,$password,$dbname);
if($con->connect_error){
    die('error is:'.$con->connect_error);
}

$sql = 'select * from Persons ORDER BY Age,Firstname ';//前一个相同，根据后一个顺序来排， 默认降序
$result = $con->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){//mysqli_fetch_array($result) = $row
        echo 'id:'.$row['id'].',Firstname:'.$row['Firstname'].',Lastname:'.$row['Lastname'].',Age:'.$row['Age'].',date:'.$row['Date'].'.<br />';
    }
}
$con->close();


?>


<?php
/**
 * update：更新数据库中数据
 * 省略where更新所有
 * User: tuyoo
 * Date: 15/7/21
 * time：09:27am
 */
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'my_db';

$con = new mysqli($servername,$username,$password,$dbname);
if($con->connect_error){
    die('error is:'.$con->connect_error);
}

/*$sql = 'update Persons set Age="36" where Firstname="a" and Lastname="a1"';
$result = $con->query($sql);*/

/*echo $result;*/
$con->close();


?>

<?php
/**
 * delete：删除数据库中数据
 * 省略where会删除所有
 * User: tuyoo
 * Date: 15/7/21
 * time：09:35am
 */
echo '<table style="border-collapse:collapse;border:1px solid #000;"><tr><th>ID</th><th>Firstname</th><th>Lastname</th><th>Age</th><th>date</th></tr>';

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'my_db';

$con = new mysqli($servername,$username,$password,$dbname);
if($con->connect_error){
    die('error is:'.$con->connect_error);
}

/*$sql = 'delete from Persons where id=1';
$con->query($sql);*/
$sql = 'select * from Persons';
$result = $con->query($sql);
if($result->num_rows >0){
    while($row = $result->fetch_assoc()){
        echo '<tr><td>'.$row['id'].'</td><td>'.$row['Firstname'].'</td><td>'.$row['Lastname'].'</td><td>'.$row['Age'].'</td><td>'.$row['Date'].'</td><td>';
    }
}


$con->close();


?>

