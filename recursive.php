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
//插入排序：
/*function switchOrder($arr,$j,$m){
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
}*/


$arr = [1,4,5,8,12,3,63,21,42,33,28,1,5,7];

/*sort($arr);*/
echo $arr;




