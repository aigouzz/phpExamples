<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/1
 * Time: 下午3:53
 */
/*13章：
 * 清理用户输入：escapeshellarg();单引号和转义符号界定参数
 * escapeshellcmd();//转义shell元字符
 * htmlentities();//输入转换成html实体
 * strip_tags();//去除用户输入中的标签
 *
 * */
//filter_var($email,FILTER_SANITIZE_EMAIL);//过滤email
if(isset($_POST['submit'])){
    echo 'you like the following languages:<br />';
    foreach($_POST['languages'] as $language){
        $language = htmlentities($language);
        echo "$language<br />";
    }
}

?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    what is your favorite language?<br />
    <input type="checkbox" name="languages[]" value="csharp">c#<br/>
    <input type="checkbox" name="languages[]" value="java">java<br/>
    <input type="checkbox" name="languages[]" value="c">c<br/>
    <input type="checkbox" name="languages[]" value="php">php<br/>
    <input type="submit" name="submit" value="submit!" />
</form>
<script>
    function shuffle(arr){
        var m = arr.length;
        var i = null;
        var t = null;
        while(m){
            i = Math.floor(Math.random()*m--);
            t = arr[m];
            arr[m] = arr[i];
            arr[i] = t;
        }
        return arr;
    }
    function shuffle(arr){
        return arr.sort(function () {
            return Math.random() - 0.5;
        });
    }
</script>