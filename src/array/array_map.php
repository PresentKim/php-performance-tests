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

require __DIR__ . "\..\TestGroup.php";

const ARRAY_SIZE = 100000;
const REPEAT_COUNT = 100;

$arr = [];
for($i = 0; $i < ARRAY_SIZE; ++$i){
    $arr[] = mt_rand(0, 255);
}

echo '[Test 01] Simple function mapping' . PHP_EOL;
$timings = new TestGroup(REPEAT_COUNT);
$timings->addTest('$newMap = array_map("chr", $arr)', function() use ($arr){
    $newMap = array_map("chr", $arr);
});

$timings->addTest('foreach($arr as $k => $v){$newMap[$k] = chr($v); }', function() use ($arr){
    $newMap = [];
    foreach($arr as $k => $v){
        $newMap[$k] = chr($v);
    }
});
$timings->run();

echo PHP_EOL . PHP_EOL;
echo '[Test 02] Complex function mapping' . PHP_EOL;
$timings->reset();
$timings->addTest('$newMap = array_map(fn(int $v): string=> chr($v), $arr)', function() use ($arr){
    $newMap = array_map(fn(int $v) : string => chr($v), $arr);
});

$timings->addTest('foreach($arr as $k => $v){$newMap[$k] = chr($v); }', function() use ($arr){
    $newMap = [];
    foreach($arr as $k => $v){
        $newMap[$k] = chr($v);
    }
});
$timings->run();
