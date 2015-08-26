<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/21
 * Time: 上午9:33
 */
/*多维数组：二维数组
 * 类和对象：属于同一类实物管理起来  类是抽象的，概念的    对象是具体实际的，代表具体事物
 * 存在形式:
 * 成员属性和成员方法
 * 成员属性：从类中抽取出来，可以使基本数据类型，也可以是复合数据类型
 * 访问成员属性：成员属性是公开 public    $a->name;
 * php中：对象引用    $a = new Person();   $a 表示地址指向堆区内容   $b = $a; $b->name也是$a->name
 * 栈区：基本数据类型
 * 堆区：对象  具体数据存储位置
 * 函数接收对象时候，传入地址
 *
 * 函数接收基本数据类型，传递值
 * php中给一个函数传递数组，默认情况下传值（拷贝新数组），若希望传值，则&$arr;这样传即可
 * 成员方法：功能，行为  函数写到类中
 * 调用成员方法和pt函数一样
 * 类名：大写 使用驼峰法
 * 区分不同请求：通常使用hidden
 * 构造方法：完成对新对象的初始化
 *     没有返回值   创建一个类的新对象，会自动调用该类的构造方法完成对对象的初始化
 * function __constructor(){}
 * 两个
 * 建议使用__constructor构造方法形式，优先调用__constructor
 *
 *
 */
class Cat{
    public $name;
    public $age;
    public $color;

}

class Person{
    public $name;
    public $age;
    public $weight;
    public $height;
}
$p1 = new Person();
$p1->height = 180;
$p1->weight = 180;
$p1->age = 26;


$p2 = $p1;
$p2->age = 15;

echo $p1->name;//也是15
class Ninga{
    public $age = 'dave';
    private static $name='apple';
    public function getName(){
        return $this->age;
    }
    public function setName($a){
        $this->name = $a;
    }
}
class Person1{
    public $name;
    public function speak(){
        echo '说话';
    }
    public function get(){
        echo $this->name;
    }
}
$p1 = new Person1();
$p1->speak();
/*c语言：指向指针的指针
 * *a = &b;//指针，地址
 *
 *
 * */