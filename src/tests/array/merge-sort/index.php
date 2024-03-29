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
 *
 * @noinspection OnlyWritesOnParameterInspection
 * @noinspection PhpUnusedLocalVariableInspection
 * @noinspection PhpArrayUsedOnlyForWriteInspection
 */

declare(strict_types=1);

require_once __DIR__ . "/../../../compare/PerformanceComparator.php";

$ARRAY_SIZE = 1000;
$arr = [];
for($i = 0; $i < $ARRAY_SIZE; ++$i){
    $arr[$i] = (int) (lcg_value() * 1000);
}

PerformanceComparator::compareFromBaseDir(
    name: "merge-sort",
    baseDir: __DIR__,
    descriptions: ["Given again is a Hash array with $ARRAY_SIZE elements and random number(0 <= n <= 1000) per entry."],
    arguments: [$arr]
);
