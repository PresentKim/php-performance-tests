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
 * @noinspection PhpUnusedLocalVariableInspection
 */

declare(strict_types=1);

require_once __DIR__ . "/../../../compare/PerformanceComparator.php";

$str = "783y6th4gf98wejuy5jg29678345yh6tf7q634hjl786dhl9872t3sh;jtshl3f457689hy425dth3421sl7850hgqt0agw";
$int = mt_rand();
$float = lcg_value() * 10000000;

PerformanceComparator::compareFromBaseDir(
    name: "print values methods",
    baseDir: __DIR__,
    repeatCount: 100000,
    arguments: [$str, $int, $float]
);
