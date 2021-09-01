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
$tests = new TestGroup(100000);

$str = "783y6th4gf98wejuy5jg29678345yh6tf7q634hjl786dhl9872t3sh;jtshl3f457689hy425dth3421sl7850hgqt0agw";
$int = mt_rand();
$float = lcg_value() * 10000000;
$tests->setInfo('$int', (string) $int);
$tests->setInfo('$float', (string) $float);

$tests->addTest('"Print : $str, $int and $float"', function() use ($str, $int, $float){
    $result = "Print : $str, $int and $float";
});
$tests->addTest('"Print : " . $str . ", " . $int . " and " . $float', function() use ($str, $int, $float){
    $result = "Print : " . $str . ", " . $int . " and " . $float;
});
$tests->addTest('\'Print : \' . $str . \', \' . $int . \' and \' . $float', function() use ($str, $int, $float){
    $result = 'Print : ' . $str . ', ' . $int . ' and ' . $float;
});
$tests->addTest('sprintf("Print : %s, %s and %s", $str, $int, $float)', function() use ($str, $int, $float){
    $result = sprintf("Print : %s, %s and %s", $str, $int, $float);
});
$tests->addTest('sprintf("Print : %s, %d and %f", $str, $int, $float)', function() use ($str, $int, $float){
    $result = sprintf("Print : %s, %d and %f", $str, $int, $float);
});
$tests->run();
