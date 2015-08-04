<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/4
 * Time: 上午11:12
 */
function binary_search($arr,$low,$high,$target){
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
}
//数组必须先排序在查找











