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
 *
 *
 *
 * */




