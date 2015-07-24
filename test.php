<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    name:<input type="text" name="name" /><br />
    age:<input type="text" name="age" /><br />
    <input type="submit" value="提交" />

    gender:<input type="radio" name="gender"
        <?php if (isset($gender) && $gender=="female") echo "checked";?>
           value="female">Female
    <input type="radio" name="gender"
        <?php if (isset($gender) && $gender=="male") echo "checked";?>
           value="male">Male
</form>
<div>
<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/7/17
 * Time: 下午4:43
 */
$age = $_GET['age'];
$name = $_GET['name'];
$gender = $_GET['gender'];
echo 'name:'.$name.',age:'.$age;
//$time = $_SERVER['REQUEST_TIME'];
echo $gender;


?>
<br />
    <?php /*echo date('y/m/d/l');*/?>
    <?php /*date_default_timezone_set("Asia/Shanghai");echo date("l");*/?>  <!-- Sunday -->
    <?php /*date_default_timezone_set("Asia/Shanghai");echo date('h:i:sa');*/?><!-- 05:50:34pm -->
    <?php /*$d = mktime(6,0,1,7,19,2015);echo '创建时间:'.date('Y-m-d h:i:sa',$d);*/?>
    <?php /*$d = strtotime('10:30am July 19 2015');echo '创建时间:'.date('Y-m-d h:i:sa',$d);*/?>
    <?php /*$d = strtotime('tomorrow');echo '创建时间:'.date('Y-m-d h:i:sa',$d);*/?>
    <?php
/*    $start = strtotime('today');
    $end = strtotime('+4 weeks',$start);
    while($start < $end){
        echo date('M d l',$start).'<br />';
        $start = strtotime('+1 day',$start);
    }
*/?>

<!-- h - 带有首位零的 12 小时小时格式
    i - 带有首位零的分钟
    s - 带有首位零的秒（00 -59）
    a - 小写的午前和午后（am 或 pm）
    -->

</div>
</body>
</html>

