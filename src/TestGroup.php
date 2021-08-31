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

final class TestGroup{
    /** @var array<string, callable> */
    private array $tests = [];

    public function __construct(public int $repeatCount = 1){ }

    public function reset(){
        $this->tests = [];
    }

    public function addTest(string $name, callable $callable) : void{
        $this->tests[$name] = $callable;
    }

    public function run() : void{
        $testResults = array_map(fn() => 0, $this->tests);
        for($i = 0; $i < $this->repeatCount; ++$i){
            foreach($this->tests as $name => $test){
                $startTime = microtime(true);
                $test();
                $endTime = microtime(true);
                $testResults[$name] += $endTime - $startTime;
            }
        }
        asort($testResults);

        $maxLength = max(9, ...array_map("strlen", array_keys($this->tests)));
        $minTime = min(...array_values($testResults));

        printf("| %-{$maxLength}s | %-13s | %-9s |\n", "Test Code", "Result time", "Rate");
        printf("| %-'-{$maxLength}s | %'-13s | %'-9s |\n", "", "", "");
        foreach($testResults as $name => $result){
            printf("| %-{$maxLength}s | %02.010fs | %3.4f%% |\n",
                $name,
                $result,
                $result / $minTime * 100
            );
        }
    }
}