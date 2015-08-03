<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/3
 * Time: 下午4:28
 */
$pic = $_POST['picture'];

if(is_uploaded_file($_FILES['picture']['tmp_name'])){
    $pic1 = $_FILES['picture']['name'];

    echo 'name:'.$pic1.'<br />'.'place:'.$_FILES['picture']['tmp_name'];
}


