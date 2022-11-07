<?php

/**
 *  ____                           _   _  ___
 * |  _ \ _ __ ___  ___  ___ _ __ | |_| |/ (_)_ __ ___
 * | |_) | '__/ _ \/ __|/ _ \ '_ \| __| ' /| | '_ ` _ \
 * |  __/| | |  __/\__ \  __/ | | | |_| . \| | | | | | |
 * |_|   |_|  \___||___/\___|_| |_|\__|_|\_\_|_| |_| |_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  PresentKim (debe3721@gmail.com)
 * @link    https://github.com/PresentKim
 * @license https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

function mergeSort1(array $nums, int $start, int $end) : array{
    if($start >= $end){
        return $nums;
    }

    $mid = intdiv($start + $end, 2);
    $nums = mergeSort1($nums, $start, $mid);
    $nums = mergeSort1($nums, $mid + 1, $end);

    $length = $end - $start + 1; $temp = [];
    $left = $start; $right = $mid + 1;

    for($i = 0; $i < $length; ++$i){
        if($left > $mid){
            $temp[$i] = $nums[$right++];
        }else if($right > $end){
            $temp[$i]= $nums[$left++];
        }else if($nums[$left] < $nums[$right]){
            $temp[$i]= $nums[$left++];
        }else{
            $temp[$i] = $nums[$right++];
        }
    }
    for($i = 0; $i < $length; ++$i){
        $nums[$start + $i] = $temp[$i];
    }
    return $nums;
}

return [
    'merge-sort with call by value',
    static function(array $arr) : array{
        return mergeSort1($arr, 0, 999);
    }
];