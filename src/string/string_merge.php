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

const REPEAT_COUNT = 1000000;

$timings = new TestGroup(REPEAT_COUNT);

$str = "Can also use sprintf instead of variables contained in double quotes, it’s about 10x faster.";
$int = 124514;
$float = 2132142142.123214124;
$timings->addTest('"Print : $str, $int and $float"', function() use ($str, $int, $float){
    $result = "Print : $str, $int and $float";
});
$timings->addTest('"Print : " . $str . ", " . $int . " and " . $float', function() use ($str, $int, $float){
    $result = "Print : " . $str . ", " . $int . " and " . $float;
});
$timings->addTest('\'Print : \' . $str . \', \' . $int . \' and \' . $float', function() use ($str, $int, $float){
    $result = 'Print : ' . $str . ', ' . $int . ' and ' . $float;
});
$timings->addTest('sprintf("Print : %s, %s and %s", $str, $int, $float)', function() use ($str, $int, $float){
    $result = sprintf("Print : %s, %s and %s", $str, $int, $float);
});
$timings->run();
