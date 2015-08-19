<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/7/18
 * Time: 下午2:54
 */
/*
$GLOBALS 全局变量
$_SERVER 报头路径 脚本位置
$_REQUEST 表单获取input值
$_POST post方式获值  无字符限制  不可见
$_GET get   2000字符  url
$_FILES
$_ENV
$_COOKIE
$_SESSION
*/
//php表单安全性很重要

$nameerr = $emailerr = $gendererr = '';
$name = $email = $gender = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(empty($_REQUEST['name'])){
        $nameerr = 'name is required';
    }else{
        $name = test_input($_REQUEST['name']);

    }
    if(empty($_REQUEST['email'])){
        $emailerr = 'email is required';
    }else{
        $email = test_input($_REQUEST['email']);

    }
    if(empty($_REQUEST['gender'])){
        $gendererr = 'gender is required';
    }else{
        $gender = test_input($_REQUEST['gender']);

    }
}
function test_input($d){
    $d = trim($d);
    $d = stripslashes($d);
    $d = htmlspecialchars($d);
    return $d;
}


//preg_match(reg,$name);匹配正则

//date(time,timestamp);函数   时间格式  时间戳    d m y 1(周里某天)

/* h - 带有首位零的 12 小时小时格式
    i - 带有首位零的分钟
    s - 带有首位零的秒（00 -59）
    a - 小写的午前和午后（am 或 pm）
*/

/*
mktime() 函数返回日期的 Unix 时间戳。Unix 时间戳包含 Unix 纪元（1970 年 1 月 1 日 00:00:00 GMT）与指定时间之间的秒数。
 strtotime() 函数用于把人类可读的字符串转换为 Unix 时间。

 通过 include 或 require 语句，可以将 PHP 文件的内容插入另一个 PHP 文件（在服务器执行它之前）。
 require 生成致命错误，e_compile_err 停止
 include 生成警告 e_warning 继续执行

*/
/*php操作文件：
 * readfile();读取文件，并写入输出缓冲
 * fopen("text.text","r");//打开文件名字，模式
 * $myfile = fopen("webdictionary.txt", "r") or die("Unable to open file!");
 * fread($myfile,filesize("webdictionary.txt"));//读至结尾
 * fclose($myfile);//关闭打开文件
 * fgets();//读取文件单行  文件指针移到指向下一行
 * feof();//查询是否到达最后一行  while(!feof($myfile)){echo fgets($myfile);}
 * fgetc();//从文件中读取单个字符
 * fwrite();//写入文件，文件名，写入的字符串 fwrite($myfile,$text);
 *
 */

/*$_FILES["file"]["name"] - 被上传文件的名称
  $_FILES["file"]["type"] - 被上传文件的类型
  $_FILES["file"]["size"] - 被上传文件的大小，以字节计
  $_FILES["file"]["tmp_name"] - 存储在服务器的文件的临时副本的名称
  $_FILES["file"]["error"] - 由文件上传导致的错误代码
 *  第一个参数：input name＝“file”  第二个：name，type size。。
 *
 * ie:pjpeg     firefox:jpeg
 *
 */
/*if((($_FILES['file']['type'] == 'image/gif') || ($_FILES['file']['type'] == 'image/jpeg') || ($_FILES['file']['type'] == 'image/pjpeg') ) && ($_FILES['file']['size'] < 20000)){
    if($_FILES['file']['error'] > 0){
        echo 'error:'.$_FILES['file']['error'].'.<br />';
    }else{
        echo 'type:'.$_FILES['file']['type'].'<br />';
        echo 'name:'.$_FILES['file']['name'].'<br />';
        if(file_exists('upload/'.$_FILES['file']['name'])){
            echo 'file:'.$_FILES['file']['name'].' already exists';
        }else{
            move_uploaded_file($_FILES['file']['tmp_name'],'upload/'.$_FILES['file']['name']);
            echo 'stored in '.'upload/'.$_FILES['file']['name'];
        }
    }
}else{
    echo 'Invalid file!';
}*/
if(isset($_FILES['picture'])){
    if($_FILES["picture"]["error"] > 0){
        echo 'Error:'.$_FILES['picture']['error'];
    }else{
        echo $_FILES['picture']['name'].'<br />'.$_FILES['picture']['size'].'<br />'.$_FILES['picture']['tmp_name'].'<br />'.$_FILES['picture']['type'];
        //move_uploaded_file($_FILES['picture']['tmp_name'],$_FILES['picture']['name']);
    }
}


/*enctype:type="file" 一般使用multipart/form-data;  二进制传输数据
 *
 * setcookie() 函数必须位于 <html> 标签之前
 * setcookie(name, value, expire, path, domain);
 * setcookie('user','alex',time()+3600);//设置cookie一个小时后失效
 * setcookie('user','',time()-3600);//删除cookie
 * $_COOKIE['user'];//取回cookie值  print_r($_COOKIE);
 *
 *
 * session:纪录单一用户信息，所有页面通用，浏览器关闭消失
 * session_start() 函数必须位于 <html> 标签之前：
 * $_SESSION['name'] = 'leo';//存取值
 *
 * unset($_SESSION('name'));
 * session_destroy();//重置session 去掉所有session
 *
 */

/* mail(to,subject,message,headers,parameters);//to，主题，信息，可选，可选
 * FILTER_SANITIZE_EMAIL 从字符串中删除电子邮件的非法字符
   FILTER_VALIDATE_EMAIL 验证电子邮件地址
 * */

function spamCheck($field){
    $field = filter_var($field,FILTER_SANITIZE_EMAIL);
    if(filter_var($field, FILTER_VALIDATE_EMAIL))
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

/* error处理
 *
 *
 * */
if(!file_exists('e.txt')){
    die('file not found');
}else{
    $file = fopen('e.txt','r');
}

function customError($errno,$errstr){
    echo '<b>error:</b>[$errno] $errstr<br />';
    error_log('error:$errno,$errstr',1,'1@163.com','from:ghc@163.com');
}
set_error_handler('customError',E_USER_WARNING);
trigger_error('value must be 1 or below',E_USER_WARNING);



/* 异常：exception
 * 每个throw对应一个catch
 * try throw catch   try里放的是可能发生异常的代码
 * catch(Exception $e){$e.getMessage();}
 *
   如果抛出了异常，就必须捕获
 *
 * */

class customException extends Exception{
    public function errorMessage(){
        $errorMsg = 'Error on line '.$this->getLine().'in '.$this->getFile().':'.$this->getMessage().' is not a valid email.';
        return $errorMsg;
    }
}
try{
try{
    if(strpos($mail,'example') !== FALSE){
        throw new Exception($mail);
    }
}catch(Exception $e){
    throw new customException($mail);
}
}catch(customException $e){
    echo $e->errorMessage();
}

/*filter:过滤威胁
 *  filter_var() - 通过一个指定的过滤器来过滤单一的变量
    filter_var_array() - 通过相同的或不同的过滤器来过滤多个变量
    filter_input - 获取一个输入变量，并对它进行过滤
    filter_input_array - 获取多个输入变量，并通过相同的或不同的过滤器对它们进行过滤

 * Validating 过滤器：
    用于验证用户输入
    严格的格式规则（比如 URL 或 E-Mail 验证）
    如果成功则返回预期的类型，如果失败则返回 FALSE
    Sanitizing 过滤器：
    用于允许或禁止字符串中指定的字符
    无数据格式规则
    始终返回字符串
 *
 *
 * */
if(!filter_var($age,FILTER_VALIDATE_INT)){
    echo $age.' is not a integer;';
}else{
    echo 'integer is valid;';
}

if(!filter_has_var(INPUT_GET,'email')){//get方式传入email  INPUT_POST
    echo 'email input does not exist;';
}else{
    if(!filter_input(INPUT_GET,'email',FILTER_VALIDATE_EMAIL)){
        echo 'email is nbot valid;';
    }else{
        echo 'email is valid';
    }
}
$email = filter_input(INPUT_GET,'email',FILTER_SANITIZE_EMAIL);//净化email
//filter_input_array();//多个数据输入的过滤
$filters = array
(
    "name" => array
    (
        "filter"=>FILTER_SANITIZE_STRING
    ),
    "age" => array
    (
        "filter"=>FILTER_VALIDATE_INT,
        "options"=>array
        (
            "min_range"=>1,
            "max_range"=>120
        )
    ),
    "email"=> FILTER_VALIDATE_EMAIL,
);

$result = filter_input_array(INPUT_GET, $filters);
?>
<?php
/* 自定义过滤器：FILTER_CALLBACK
 *
 * */
?>
<?php
function convertSpace($string)
{
    return str_replace("_", " ", $string);
}

$string = "Peter_is_a_great_guy!";

echo filter_var($string, FILTER_CALLBACK, array("options"=>"convertSpace"));
?>
<!--
MYSQL:简介structured query language
-->
<?php
 $con = mysql_connect('localhost','peter','123');
if(!$con){
    die('could not connect '.mysql_error());
}else{

}
mysql_close($con);
?>

<?php
$con = mysqli_connect('localhost','phpcms','phpcms','dbname');
if(!$con){
    die('could not connect '.mysql_error());
}
if(mysql_query('CREATE DATABASE my_db',$con)){
    echo 'database my_db created!';
}else{
    echo 'db error '.mysql_error();
}

$sql = 'CREATE TABLE Persons(personID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(personID),Firstname varchar(15),Lastname varchar(15),Age int)';
mysql_query($sql,$con);

mysql_close($con);
?>
<!--
主键：primary key  不可为空，且每个表中只有一个主键 主键字段永远要被编入索引，通常auto_increment
-->
<!--
sql对于大小写不敏感

$sql = "INSERT INTO Persons(Firstname,Lastname,Age) VALUES ('ted','colanbores','18')";
$sql = "INSERT INTO Persons(Firstname,Lastname,Age) VALUES ('$_POST['FIRSTNAME']','$_POST['lastname']','$_POST['age']')";
-->
<!--
select:获取数据   SELECT column_name(s) FROM tablename
mysqli_connect($servername,$username,$passsword,$dbname);
mysqli_query($connect,$sql);

-->

<!--
xml:
dom:提供了针对html和xml的文档对象集，以及用于访问和操作这些文旦的接口

coreDOM  ：为任何结构化文档定义标准的对象集
xml dom：xml结构化文档定义的对象集
html dom：为html结构化文档定义的对象集
-->
<?php

$xmlDoc = new DOMDocument();
$xmlDoc->load('note.xml');

print $xmlDoc->saveXML();
// 输出内容字符串

?>

<?php
$xmlDom = new DOMDocument();
$xmlDom->load('note.xml');

$x = $xmlDom->documentElement;
foreach($x->childNodes as $item){
    print $item->nodeName.'='.$item->nodeValue.'<br />';
}
//#text =
//to = ted  //xml生成时会在节点间包含空白


?>

<!--
php5:SimpleXML:无需安装即可使用

simpleXML：可把xml文档（字符串）转换成对象
元素被转换为 SimpleXMLElement 对象的单一属性。当同一级别上存在多个元素时，它们会被置于数组中。
属性通过使用关联数组进行访问，其中的索引对应属性名称。
元素内部的文本被转换为字符串。如果一个元素拥有多个文本节点，则按照它们被找到的顺序进行排列。


-->
<?php
$xml = simplexml_load_file('note.xml');
print_r($xml);//SimpleXMLElement Object([to]=>Dove [from]=>Jani [heading]=>'glad you came' [body]=>'welcome here!')

$xml = simplexml_load_file('note.xml');
echo $xml->to.'<br />';
echo $xml->from.'<br />';
echo $xml->heading.'<br />';

$xml = simplexml_load_file('note.xml');
echo $xml->getName().'<br />';//Note
foreach($xml->children() as $child){
    echo $child->getName().':'.$child.'<br />';
}
?>
<!--
ajax:asynchronous javascript and xml     异步


-->
<?php
function ajax(){
    /*if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","gethint.php?q="+str,true);
    xmlhttp.send();*/
}
$q = $_GET['q'];
if(strlen($q) > 0){
    $hint = '';
    for($i=0;$i<count($a);$i++){
        if(strtolower($q) == strtolower(substr($a[$i],0,strlen($q)))){
            if($hint = ''){
                $hint = $a[$i];
            }else{
                $hint .= ','.$a[$i];
            }
        }
    }
}
if($hint == ''){
    $suggest = 'no suggestions';
}else{
    $suggest = $hint;
}
echo $suggest;
?>
<?php
/*
 * 跨域：允许多个域名访问
 * $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';

$allow_origin = array(
    'http://client1.w3cschool.cc',
    'http://client2.w3cschool.cc'
);

if(in_array($origin, $allow_origin)){
    header('Access-Control-Allow-Origin:'.$origin);
}
 *header('Access-Control-Allow-Origin:*');允许所有域名访问
 *
 * */

header('Access-Control-Allow-Origin:*');

?>
<?php
/*ajax:xml 处理
 *
 * */
$q = $_GET['q'];
$xmlDoc = new DOMDocument();
$xmlDoc->load('cd_catalog.xml');

$x = $xmlDoc->getElementsByTagName('ARTIST');
for($i=0;$i<$x->length-1;$i++){
    if($x->item($i)->nodeType == 1){
        if($x->item($i)->childNodes->item(0)->nodeValue == $q){
            $y = $x->item($i)->parentNode;
        }
    }
}
$cd = ($y->childNodes);
for($i=0;$i<$cd->length;$i++){
    if($cd->item($i)->nodeType == 1){
        echo '<b>'.$cd->item($i)->nodeName.'</b><br />';
        echo $cd->item($i)->childNodes->item(0)->nodeValue.'<br/>';

    }
}
?>
<?php
/*
stristr(string,find);//对大小写不敏感，返回从匹配点到最后的字符串，  strstr对大小写敏感  false


*/

$q = $_GET['q'];
$xmldd = new DOMDocument();
$xmldd->load('links.xml');

$x = $xmldd->getElementsByTagName('link');
if($q != ''){
    $hint ='';
    for($i=0;$i<$x->length;$i++){
        $y = $x->item($i)->getElementsByTagName('title');
        $z = $x->item($i)->getElementsByTagName('url');
        if($y->item(0)->nodeType == 1){
            if(stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)){
                if($hint == ''){
                    $hint = '<a href="'.$z->item(0)->childNodes->item(0)->nodeValue.'">'.$y->item(0)->childNodes->item(0)->nodeValue.'</a>';
                }else{
                    $hint = $hint.'<a href="'.$z->item(0)->childNodes->item(0)->nodeValue.'">'.$y->item(0)->childNodes->item(0)->nodeValue.'</a>';
                }
            }
        }
    }
}
if($hint == ''){
    $suggest = 'no suggestions';
}else{
    $suggest = $hint;
}
echo $suggest;
?>

<?php
/* vote ajax:投票ajax
 *
 * */
$vote = $_REQUEST['vote'];

$filename = 'poll_result.txt';
$content = file($filename);
$array = explode('||',$content[0]);

$yes = $array[0];
$no = $array[1];

if($vote == 0){
    $yes += 1;
}else{
    $no += 1;
}
$insert = $yes.'||'.$no;
$fp = fopen($filename,'w');
fputs($fp,$insert);
fclose($filename);
?>
<?php echo(100*round($yes/($yes+$no),2)).'%';?>

<?php

/* php常量：脚本中不能改变
 * define  变量名，值，区分大小写    默认区分大小写
 *
 * */

define('greet','hello,everyone!',true);//true,不区分大小写
echo greet;
?>
<?php
/*mysql:复制，查询缓存，全文索引和搜索，企业级sql特性，安全
 * status:查看mysql的详细信息
 * show tables：查看表
 * show variables:系统变量
 * /etc/my.cnf:全局配置文件
 *
 * //有用的mysql命令：
 * show databases
 * show tables
 * use my_db
 * describe host;//查看表结构
 * //unix区分大小写
 * 垂直显示结果： select * from db\G;
 * status//\s  查询系统信息
 * --safe-updates选项防止没有where的delete or update查询
 *
 * mysql支持四种链接协议：
 *     tcp协议：需要端口3306来正常运行，若客户端和服务器位于不同的计算机，需要使用tcp
 *     套接字文件：unix特有的特性，方便两个不同程序之间通信，通信发生在本地的话套接字文件是默认设置
 *     共享内存：只适用于windows，使用共同内存块进行通信
 *     命名管道：只适用于windows
 * 连接选项：
 * -h：目标数据库主机，若链接本地主机，可选择省略此选项、
 * -u:链接用户名
 * -p:链接密码
 * -W：指定用于链接服务器的命名管道
 * -P：指定连接mysql服务器时使用的端口
 * -s：对于本地主机连接，需要一个套接字文件
 *
 * */
/* mysql存储引擎：
 * no1：MyISAM：选择密集，插入密集的表
 *     三种格式：静态，动态，压缩
 *     MyISAM静态：所有表列的大小都是静态的，mysql就会自动使用MyISAM静态格式  ==性能高，牺牲空间为代价
 *     MyISAM动态：如果有表列被定义为动态的 == 性能低，容易有数据碎片产生
 *     MyISAM压缩：只读的表，靠工具来转变
 * no2：IBMDB2I：
 * no3：InnoDB：事务性存储引擎
 *     更新密集的表：处理多重并发的更新请求
 *     事务：唯一支持事务的标准MySQL存储引擎，管理敏感数据的必须特性
 *     自动灾难恢复：
 * no4：MEMORY：速度
 *     逻辑存储介质：内存
 *     特质：可以忽略，暂时，相对无关
 *
 * 数据类型：
 *     日期和时间：DATE==》存储日期信息   DATETIME:日期和时间信息的组合
 *              TIME：时间信息       TIMESTAMP：p408     YEAR:
 *     数值：
 *          BOOL(BOOLEAN):TINYINT(1)的别名
 *          BIGINT[(M)]:最大的整数范围
 *          INT[(M)]:第二大整数范围
 *          MEDIUMINT[(M)]:第三大整数范围
 *          SMALLINT[(M)]：0-65535
 *          TINYINT[(M)][UNSIGNED][ZEROFILL]:0-255
 *          DECIMAL[(M[,D])][UNSIGNED][ZEROFILL]:字符串的浮点数
 *          DOUBLE([M,D])[UNSIGNED][ZEROFILL]:双精度浮点型
 *          FLOAT([M,D])[UNSIGNED][ZEROFILL]:单精度浮点数
 *          FLOAT(precision)[UNSIGNED][ZEROFILL]:精度对于单精度可以使1-24，对于双精度为25-53
 *     字符串：
 *          CHAR(length)[BINARY | ASCII  | UNIQUE]:固定长度字符串表示形式，支持最大255个字符
 *          [NATIONAL]VARCHAR(LENGTH)[BINARY]:可变长度字符串，0-65535
 *          LONGBLOB:最大的二进制字符串表示形式
 *          LONGTEXT:最大的非二进制字符串标示形式
 *          MEDIUMBLOB:第二大二进制字符串表示形式
 *          MEDIUMTEXT:第二大非二进制字符串标示形式
 *          BLOB:第三大
 *          TEXT:第三大    都是0-65535
 *          TINYBLOB:最小二进制字符串表示形式，0-255
 *          TINYTEXT:最小非二进制字符串标示形式 0-255
 *          ENUM('member1'..):最多存储一组预定义的值中某一个成员提供了一种方法
 *          SET('member1'。。):为指定的一组预定义的值中0或多个值提供了一种方法
 *      数据类型属性：
 *          AUTO_INCREMENT:去除了许多数据库驱动的应用程序中必要的一层逻辑：它能为新插入的行附一个唯一的整数标识符    用于作为主键的列，每个表只允许一个
 *          BINARY:只属于char和varchar值，区分大小写的方式排序（根据ascii值排序）
 *          DEFAULT:确保没有任何值可用的情况下，赋予某个常亮值，无法用于blob或text，若已经制定了NULL值，没有指定默认值时默认值为null，否则默认值将依赖于字段的数据类型
 *          INDEX:索引一个列会为该列创建一个有序的键数组，每个键指向其相应的表行    针对输入条件可以搜索这个有序的键数组，性能极大提升
 *          NATIONAL:只用于char和varchar数据类型，  确保该列使用默认字符集，而mysql默认使用默认字符集    ==》保证数据库兼容性
 *          NOT NULL：不允许向该列插入null值，建议在重要情况下始终使用not null，提供一个基本验证，确保已经向查询传递了所有必要的值
 *          NULL:意味着指定列不可以存在值
 *          PRIMARY KEY:确保指定行的唯一性，指定为主键的列中，值不能重复，也不能为空，和auto_increment合作很常见
 *              UNIQUE:确保所有值都不相同，只有null值可以重复
 *              ZEROFILL:可用于任何数值类型，用0填充所有剩余字段空间    默认字段宽度为6：000001
 *      处理数据库和表：
 *          SHOW DATABASES;
 *          create database my_db;
 *          use my_db;
 *          DROP DATABASE my_db;
 *
 *          CREATE TABLE Persons(id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,firstname VARCHAR(25) NOT NULL,lastname VARCHAR(25) NOT NULL,email VARCHAR(45) NOT NULL,phone VARCHAR(10) NOT NULL);
 *          //database_name.table_name;
 *          CREATE TABLE IF NOT EXISTS my_db();//条件创建
 *          CREATE TABLE my_db1 select * from my_db;//复制表
 *          CREATE TEMPORARY TABLE my_db2 select firstname,lastname from my_db;//创建一个临时表，针对这个临时表进行查询，和当前会话生命周期一样长
 *          DESCRIBE Persons;//查看表结构
 *          SHOW columns IN Persons;
 *          DROP [TEMPORARY] TABLE [IF EXISTS] TABLE_NAME [,TABLE_NAME];//删除表，可以多个
 *          修改表结构：
 *          ALTER TABLE my_db ADD COLUMN birthday DATE;//添加列生日
 *          ALTER TABLE my_db ADD COLUMN birthday DATE AFTER firstname;//在firstname之后
 *          ALTER TABLE my_db CHANGE birthday birthday DATE NOT NULL;//改变某一列得属性
 *          ALTER TABLE my_db DROP birthday;//删除某一列
 *
 *          show：mysql内置特性，不是标准的数据库特性
 *          INFORMATION_SCHEMA;//标准sql支持，了解数据库和各种服务器设置，28个表，帮助了解安装环境几乎所有方面
 *           CHARACTER_SETS;//存储关于可用字符集的2信息
 *           COLLATIONS;//字符集校正的信息
 *           COLLATIONS_CHARACTER_SET_APPLICABILITY;//collations表的子集
 *          。。。
 *
 *      //保护mysql的安全：
 *      mysqld守护进程：ssl secure sockets layer 安全套接层
 *      保护mysqld守护程序：
 *
 *      mysql访问权限系统：依赖于一个名为mysql的特殊数据库
 *          基于两个一般概念：
 *          验证：确定用户是否被允许连接数据库
 *          授权：确定已验证用户是否有足够的权限执行查询请求
 *
 *      访问控制两阶段：链接验证和请求验证
 *          user表：唯一一个在权限请求过程两个阶段中都起作用的表；
 *               唯一一个存储与管理mysql服务器相关的权限的权限表
 *              HOST列：指定主机名，确定用户从哪个主机地址发起连接
 *              USER列：指定能够连接服务器区分大小写的用户名，不允许通配符，允许空白值
 *              Password列：存储连接用户提供的已加密密码，不允许通配符，可以使用空白密码
 *              剩余的28个_priv列都是用户权限列
 *              剩余8个列max_questions,max_updates,max_connections,max_user_connections,ssl_type,ssl_cipher,x509_issuer,x509_subject;
 *          db表：针对每个数据库为用户赋予权限，可以查看用户是否没有试图执行的任务的全局权限
 *
 *      //虚拟目录：<Directory 'd:mysql'>
 *                  All allow,deny
 *
 *                   </Directory>
 *
 *
 *
 **/

?>


<!-- *************************************************************************   linux    *******************************************************************************************-->
<!-- ********************************************************************************************************************************************************************************-->

<?php
/* linux：text segment代码区     全局初始化数据区：data segment      未初始化数据区：bss    栈区：stack 编译器自动分配释放
 * 堆区：heap  动态内存分配  一般有程序员分配释放  没有就os分配释放
 * 全局变量静态变量只能被初始化一次
 * 函数：存储类型仅仅标志函数作用域 默认extern   全局
 *
 * */
/* 变量：存储类型 类型修饰符 数据类型 变量名
 * char double int float *    struct enum typedef union
 * 类型修饰符：long short signed unsigned void const volatile
 * 存储类型：auto extern register static
 *
 * 函数：存储类型 返回数据类型 函数名（参数列表）
 * auto:一般标示变量，存储在进程栈中，对于局部变量，默认auto
 * extern：全局变量，全局函数
 * register：只能用于局部变量，只能整形和字符型，标志长时间被使用的变量，常驻寄存器
 *  一般用于循环操作中，但是不能太多，cpu寄存器有限  未初始化的变量将赋予随即初值
 * static：静态 可变量可函数 作用域：当前文件 或 函数内   存储于数据区  只初始化一次且没有初始化会被初始化为0
 *  函数的话只能在本文件调用，其他文件吊用不了  避免命名冲突
 * 常量数据：字符串
 * 同一文件内指向同一地址，存储于代码段
 *
 * */
/*堆和栈的区别：
 * 1：栈：程序运行时分配空间：os维护  向低地址扩展，连续内存地址，os预先定义好
 * 2：堆：malloc()  free()     new  delete=>c++   易产生内存泄露  非连续地址，向高地址扩展，链表存储空闲内存地址 由低到高
 * 堆：频繁malloc free产生大量碎片，使效率低下  栈是连续的
 * 堆：效率比栈低
 * efficiency lower
 *
 *
 * */
#include <stdio.h>
#include <malloc.h>
#include <ininstd.h>
#include <alloca.h>
#define SHW_ADR(id,i){printf('the %s address is %d ',id,&i);}
/* p,&i都是变量i的地址，*p，i都是变量i的值
 *
 *
 * */


function bare(){
    $m = array('name','age','id');
    foreach($m as $value){
        echo 'the value of arr is:'.$value;
    }
}
?>
<?php
/* error:返回局部变量地址会导致错误  临时空间过大 src和dst内存覆盖
         动态内存管理：申请和释放不一致  申请和释放量不一致  释放后仍然读写 使用完堆空间一定要释放
 * 分配空间，返回对象在内存中地址，用来初始化指针对象，   对于动态分配的内存唯一访问方式是通过指针间接访问
 *
 * 内存分配：静态和动态
 * 编译器在编译程序源代码时分配  全局和局部变量等
 * 动态：程序执行时调用malloc申请分配
 *
 * 调用free释放内存后不能在访问被释放的内存空间，可指针置为空
 * 不能两次释放相同的指针
 * malloc free配套使用，不需要的内存空间都需要释放回收
 * */

/* c程序讲解：
 * stdio.h  调用printf（）函数
 * stdlib.h 调用malloc（）函数的头文件
 * int main(int argc,char* argv[],char* envp[]){} argc参数个数  argv参数列表 envp所有环境变量
 *
 * ralloc();//用来更改已经配置的内存空间
 * realloc(void *_ptr,size);//若当前内存段后有足够的空间就直接扩展，返回原指针
 * 若当前指针后空间不够，使用堆中第一个能满足要求的内存块，将数据移入，释放原空间，返回新内存块位置
 * 若申请失败，返回null，原指针仍然有效
 *
 * */
/* calloc();//优点是把动态分配的内存初始化为0
 * calloc(count,sizeof(strunt data));//
 *
 * */
/*memcpy(void* dest,void* src,size);//n个字节从src指向复制到dest指向，执行成功返回目的地址
 * 没有对可能出现的多余目的空间进行处理
 * memmove(void* dest,void* src,size);//复制前，先检查源地址和目的地址是否重合，重合先处理，没有重合就直接复制
 * memset(void* s,int c,size);//把从s开始后面n位值改为c，返回s首地址
 * memchr(void *s,int c,size);//一段内存空间中查找某个字符位置第一次出现的位置 s位置开始在size位内查找c
 * memcmp(void *s1,void *s2,size);//比较内存单元前n个字节是否相等，=返回0，s1《s2 =-1  ，s1》s2==1
 *
 * */
/* valgrind:内存管理工具
 * 命令行参数识别：getopt();//单个字符-》冒号     ‘i:’：标示其后必须接个参数，参数紧跟在选项后或者以空格格开，该参数指针赋给optarg
 *     ‘i::’：标示该选项后可以跟一个参数，参数必须紧随其后或者空个空格，该参数指针赋给optarg
 * getopt(int argc,char *argv,const *shortopts);//返回第一个选项，设置下列全局变量：optarg 指向当前选项参数的指针
 *    optind：再次调用getopt();的下一个argv指针的索引
 *    optopt：存储不可知或错误选项
 *
 * */
/*luinux系统：使用gcc编程，一般处理器都是32位字长
 * char：所占内存空间8位  -128-127  0-255
 * short int：16位 -32768-32767 0-65535
 * int：32位 -2147483648-2147483647  0-4294967295u
 * long int:随_wordsize值改变，一般为32
 *
 * 文件操作:用户态：当一个任务或进程执行用户自己的代码  核心态：当一个任务执行系统调用陷入内核代码中执行时，称为核心态
 * 文件：文本文件  ascii文件  存储量大，速度慢，便于字符操作
 * 二进制文件：按内存中存储样式存放
 *
 * 缓存文件操作和非缓存文件操作：
 *  全缓冲区，行缓冲区，无缓冲区
 * 每个进程默认可以操作：输入数据流，输出数据流，标准错误输出
 *
 * /dev/stdin  /dev/stdout  /dev/stderr
 * 文件流主要功能：实现当前程序内容和外部输出输入设备信息的转化，主要包括格式化内容和缓冲功能
 * 格式化内容：实现不同输入输出格式转换
 * 缓冲功能：将数据的读写集中。减少系统调用次数
 *
 * 文件流指针:针对文件的读写操作都通过该文件流指针完成
 * 三种类型缓冲：
 * 全缓冲区：默认大小BUFSIZ  系统定义--8192
 * 行缓冲区：遇到换行符或缓冲区满，部分系统默认128字节
 * 不带缓冲区：标准I/O库不对字符缓存
 * 标准输入和输出设备：当且仅当不涉及交互作用设备时，标准输入输出流才是全缓冲区的
 * 标准错误输出输入设备：标准出错绝不可能是全缓冲区
 *
 * */
/* 指定流缓冲区：setbuf();setvbuf();
 * setbuf(FILE *stream,char *buf);//第一：操作的流 ，第二：指向的长度为BUFSIZ的缓冲区
 * setvbuf(FILE *stream,char *buf,int modes,size);//三：缓冲区类型， 四：缓冲区大小
 *
 * ANSI C文件i/o操作：
 * 打开文件：fopen(char *filename,modes);//r：只读 文件必须存在，不存在就返回错误   w：只写 不存在就创建新的 +也一样  r+,w+:读写
 *
 *
 * */
/* linux:
解决方案1：通过端口来访问不同站点
 * 先配置https.conf，启用httpd-vhosts.conf
 * 配置httpd-vhosts.conf，virtual hosts
 * hosts文件中添加ip和域名对应关系
 * 建议注销DocumentRoot
 *
 * 添加一个新域名与该ip绑定
 * 开发新网站
 * 配置httpd-vhosts.conf，添加新的virtualhost虚拟主机
 * 在http。conf文件中，让apache监听81端口
 * Listen 81
 * 在hosts文件中添加新的域名
 * 127.0.0.1 www.shunping2.com
 * 访问要带端口
 *
 * 通过serverName端口区分不同域名
 * 1：开发新网站
 * 2：在httpd-vhosts.conf文件中添加配置（注意这时的配置和以前不一样）  添加：ServerName www.shunping2.com
 *                                                                      DirectoryIndex INDEX.HTML
 *  VirtualHost *:80  修改
 * 测试即可
 *
 * uml时序图：请求php文件的流程
 * 浏览器：解析主机名 hsots：查询主机对应ip  没找到就到外网dns
 * 向apache发送http请求，解析主机，解析站点、目录，再解析请求资源，请求文件  没找到就返回404 not found
 * 找到的话，php代码在apache服务器端执行，然后代码被结果替代，html代码原封不动返回
 * 服务器执行完返回给浏览器，浏览器在解析html文件
 * 若只是为了显示变量值
 * <?=$i?>
 *
 *
 *
 * */
    //============================================================== php学习 ==========================================================
    //============================================================== php学习 ==========================================================



/* php数据：基本数据：整形 浮点型，字符串，boolean
 * 复合数据：数组 对象
 * 特殊数据：null 资源类型(resource)
 * 浮点型：精度14位，左边第一个非0得值开始数
 * 字符串：双引号：输出$i值，解析特殊字符
 *          单引号：输出$i字符串
 * 理论上可以到达内存大小的字符串
 * 数据类型自动转换：由php上下文决定
 * &&：前面false后面不执行
 * ||：前面true后面不执行
 * or and：优先级比=低
 * $a = true and false;//true
 * $b = false || true;//false
 *
 * switch:case中若为bool那么会自动转换成布尔值类型，default位置对执行没有影响
 *
 * require：出错就退出    require_once:看有没有包含，有的话就不再执行
 * include：出错不会退出  include_once和上面一样
 * 基本上是用require once
 *
 * 函数名不区分大小写
 * 函数：unset($a);释放给定的变量
 *
 * 二进制：原码：用二进制表示数的码  0-》正数  1-》负数
 * 正数原码，反码和补码都一样
 * 负数反码：符号位不变，其他位取反
 * 负数补码：反码+1
 * 0的反码补码都是0
 * php没有无符号数
 * 计算机计算都是以补码方式运算
 *
 * 按位与&：两个全为1.结果为1
 * 按位或|：有一个为1，结果为1
 * 按位异或^：不同位为1
 * 按位取反：1变0，0变1
 *
 * 算术左移：<< 低位补0，符号位不变
 * 算术右移：>> 高位补符号位，符号位不变
 * 位移运算：运算规则就是上面两个运算符号
 *
 * php中没有逻辑左移和逻辑右移 >>>  <<<
 * 数组：关键字和值的集合
 * 创建：$arr[0] = '1';..
 * $arr = array(1,2,3,4);
 * $arr = array('name'->'value');
 * $arr['logo']= '北京';
 * foreach($arr as $key=>$value){}
 *  如果对给定的值没有指定键名，则取当前最大的索引值，新值是该索引值加一，如果指定键名已经有了值，则该值会被覆盖
 * print_r();//var_dump();更全
 * 访问数组时，不要越界
 * 引用陷阱：不能使用未定义的常量来当做
 * count
 * is_array();//判断是否数组
 * $arr = explode(‘ ’,$string);//拆分字符串成数组  以空格为界限来拆分$string
 * unset();允许删除数组中某个键，不会自动恢复  可以销毁某个元素也可以销毁某个变量
 * 销毁该元素后不会自动恢复
 * ==：相同键值对
 * ===：相同键值对，顺序类型相同
 * +运算符：相同键的不会改变，其他就会添加到前面数组后面   $arr + $arr1;//返回$arr和$arr 与$arr1不同键的键值对
 *
 * 排序：
 * 冒泡法：比较相邻的元素，逆序即交换，一趟把最大得数拍到前面
 * 选择排序：每次找到最小排到前面
 * 插入排序：
 * 快速排序：
 * 冒泡 快速都是交换式排序法 也是内部排序
 * 数组默认传递值，不是地址
 *
 *
 *
 *
 * */

//封装函数

function bubble(&$arr){//封装 加地址符会使得$arr指向传进来的数组地址
    $temp=0;
    for($i=0;$i<count($arr)-1;$i++){
        for($j=0;$j<count($arr)-1-$i;$j++){
            if($arr[$j]>$arr[$j+1]){
                $temp = $arr[$j];
                $arr[$j] = $arr[$j+1];
                $arr[$j+1] = $temp;
            }
        }
    }
}
function selectSort(&$arr){
    $temp = 0;
    for($i=0;$i<count($arr)-1;$i++){
        $minVal = $arr[$i];
        $minIndex = $i;
        for($j=$i+1;$j<count($arr)-1;$j++){
            if($minVal>$arr[$j]){
                $minVal = $arr[$j];
                $minIndex = $j;
            }
        }
        $temp = $arr[$i];
        $arr[$i] = $arr[$minIndex];
        $arr[$minIndex] = $temp;
    }
}//比冒泡排序更有效率

function Sort(&$arr){

}
