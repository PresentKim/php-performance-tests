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

require __DIR__ . "/../TestGroup.php";
$tests = new TestGroup(10000);

const ARRAY_SIZE = 100;
$tests->addDescriptions('$arr = array_fill(0, ARRAY_SIZE, 255);');
$tests->setInfo("ARRAY_SIZE", (string) ARRAY_SIZE);

$arr = array_fill(0, ARRAY_SIZE, 255);

$tests->addTest('$newMap = array_map("chr", $arr)', function() use ($arr){
    $newMap = array_map("chr", $arr);
});

$tests->addTest('foreach($arr as $k => $v){$newMap[$k] = chr($v); }', function() use ($arr){
    $newMap = [];
    foreach($arr as $k => $v){
        $newMap[$k] = chr($v);
    }
});
$tests->run("[Test 01 - Simple function mapping]");
$tests->reset();

echo PHP_EOL;
$tests->addTest('$newMap = array_map(fn(int $v): string=> chr($v), $arr)', function() use ($arr){
    $newMap = array_map(fn(int $v) : string => chr($v), $arr);
});

$tests->addTest('foreach($arr as $k => $v){$newMap[$k] = chr($v); }', function() use ($arr){
    $newMap = [];
    foreach($arr as $k => $v){
        $newMap[$k] = chr($v);
    }
});
$tests->run("[Test 02 - Complex function mapping]");
$tests->reset();
