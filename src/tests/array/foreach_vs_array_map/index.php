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

const ARRAY_SIZE = 100;
$arr = array_fill(0, ARRAY_SIZE, str_repeat('_', 10000));

return PerformanceComparator::compareFromBaseDir(
    name: "foreach vs array_map()",
    baseDir: __DIR__,
    descriptions: ['Given again is a Hash array with ' . ARRAY_SIZE . ' elements and 10k data per entry.'],
    arguments: [$arr]
);
