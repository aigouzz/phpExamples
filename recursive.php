<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/4
 * Time: 上午11:12
 */
/*function binary_search($arr,$low,$high,$target){
    $mid = intval(($low+$high)/2);
    if($arr[$mid] == $target){
        return $mid;
    }elseif($arr[$mid] > $target){
        return binary_search($arr,$low,$mid-1,$target);
    }else{
        return binary_search($arr,$mid+1,$high,$target);
    }
    return -1;
}

function binarySearch($arr,$k){
    $len = count($arr);
    $low = 0;
    $high = $len - 1;
    while($low<=$high){
        $mid = intval(($low+$high)/2);
        if($arr[$mid] == $k){
            return $mid;
        }elseif($arr[$mid] > $k){
            $high = $mid - 1;
        }else{
            $low = $mid + 1;
        }
    }
    return -1;
}*/
//数组必须先排序在查找

//选择排序：从第一个元素开始找到最小的与第一个交换，在剩下的元素中寻找到最小与第二个交换，recursive
//插入排序：从第二个元素和前面已经排序的元素对比，如果小于前面元素则兑换顺序，直到大于或等于前面元素停止
//插入排序涉及比较比选择排序平均少一半！
function switchOrder($arr,$j,$m){
    $n = $arr[$j];
    $arr[$j] = $arr[$m];
    $arr[$m] = $n;
}
function  sort($arr){
    $n = count($arr);
    for($i = 0;$i<$n;$i++){
        for($j = $i;$j >0;$j--){
            if($arr[$j] < $arr[$j-1]){
                switchOrder($arr,$j,$j-1);
            }else{
                break;
            }
        }
    }
}


$arr = [1,4,5,8,12,3,63,21,42,33,28,1,5,7];

sort($arr);
echo $arr;

//希尔排序：插入排序  多走几步
function sortHill($arr){
    $n = count($arr);
    $h = 1;
    while($h<$n/3){
        $h = $h*3 +1;
    }
    while($h>=1) {
        for ($i = 0; $i < $n; $i++) {
            for ($j = $i; $j > $h; $j -= $h) {
                if ($arr[$j] < $arr[$j - $h]) {
                    switchOrder($arr, $j, $j - $h);
                } else {
                    break;
                }
            }
        }
        $h = $h/3;
    }
}

?>
<?php
//dijkstra算法：最短路径问题
//floyd算法：最短路径  多源最短路径

public class Floyd{
    private $id = 0;
    private $name = 'leo';
    function __construct($name,$id){

    }
}




