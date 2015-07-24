<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        td,th{border:1px solid #ccc;height:30px;}
    </style>
</head>
<body>

<table style="border-collapse: collapse;border:1px solid #ccc;">
    <thead>
    <tr>
        <th style="width:150px;height:30px;text-align: left;">id</th>
        <th style="width:150px;text-align: left;">firstname</th>
        <th style="width:150px;text-align: left;">lastname</th>
        <th style="width:150px;text-align: left;">age</th>
        <th style="width:150px;text-align: left;">date</th>
    </tr>
    </thead>
    <tbody>
<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/7/20
 * Time: 下午6:52
 */
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'my_db';

$con = new mysqli($servername,$username,$password,$dbname);
if($con->connect_error){
    die('connection error:'.$con->connect_error);
}

$sql = 'select id,Firstname,Lastname,Age,Date from Persons';
$result = $con->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo '<tr><td>'.$row['id'].'</td><td>'.$row['Firstname'].'</td><td>'.$row['Lastname'].'</td><td>'.$row['Age'].'</td><td>'.$row['Date'].'</td></tr>';
    }
}else{
    echo '0 results';
}

$con->close();

?>
    </tbody>
</table>

<?php
echo "<table style='border:none;border-collapse: collapse;'>";
echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th><th>age</th><th>date</th></tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width: 150px;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM Persons");
    $stmt->execute();

    // 设置结果集为关联数组
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
    $dsn = null;
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>
</body>
</html>