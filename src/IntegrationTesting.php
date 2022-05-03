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

echo "Integration Testing...\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PHP opcache.jit enabled: " . (ini_get("opcache.jit") ?? "false") . "\n";

$results = [];
$testRootDir = __DIR__ . "/tests";
foreach(scandir($testRootDir) as $testsDirFile){
    $testCategoryDir = "$testRootDir/$testsDirFile";
    if($testsDirFile !== "." && $testsDirFile !== ".." && is_dir($testCategoryDir)){
        foreach(scandir($testCategoryDir) as $categoryDirFile){
            $testFile = "$testCategoryDir/$categoryDirFile/index.php";
            if(file_exists($testFile)){
                $results[] = require $testFile;
            }
        }
    }
}

$exports = getopt("", ["exports:"])["exports"] ?? "";
if(empty($exports)){
    echo "Integration Testing Complete.\n";
    exit(0);
}

try{
    file_put_contents($exports, json_encode($results, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo "Results exported to $exports.\n";
}catch(JsonException $e){
    echo $e->getMessage() . PHP_EOL;
}