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
    private const CODE = "Code";
    private const TIME = "Time";
    private const RATE = "Rate";

    /** @var array<string> */
    private array $descriptions = [];

    /** @var array<string, string> */
    private array $infos = [
        "PHP Version" => PHP_VERSION
    ];

    /** @var array<string, callable> */
    private array $tests = [];

    public function __construct(public int $repeatCount = 1){ }

    public function reset(bool $resetDescription = false, bool $resetInfo = false){
        $this->tests = [];
        if($resetDescription){
            $this->descriptions = [];
        }
        if($resetInfo){
            $this->infos = [];
        }
    }

    public function addTest(string $name, callable $callable) : void{
        $this->tests[$name] = $callable;
    }

    public function addDescriptions(string $descriptions) : void{
        foreach(explode("\n", str_replace("\r\n", "\n", $descriptions)) as $description){
            $this->descriptions[] = $description;
        }
    }

    public function setInfo(string $name, string $value) : void{
        $this->infos[$name] = $value;
    }

    public function getMaxNameLength() : int{
        return empty($this->tests) ? 0 : max(mb_strlen(self::CODE), ...array_map(fn($v) => mb_strlen($v), array_keys($this->tests)));
    }

    /** @param array<string, float> $results */
    public function getMaxTimeLength(array $results) : int{
        return empty($results) ? 0 : max(mb_strlen(self::TIME), ...array_map(fn(float $result) : int => mb_strlen(sprintf("%2.2fµs", $result)), array_values($results)));
    }

    public function getMaxDescriptionLength() : int{
        return empty($this->descriptions) ? 0 : max(0, ...array_map(fn($v) => mb_strlen($v), $this->descriptions));
    }

    public function getMaxInfoLength() : int{
        return empty($this->infos) ? 0 : max(0, ...array_map(fn($v) => mb_strlen($v), array_values($this->infos)));
    }

    public function run(string $name = "") : void{
        $results = [];
        for($i = 0; $i < $this->repeatCount; ++$i){
            foreach($this->tests as $testName => $test){
                $startTime = microtime(true);
                $test();
                $endTime = microtime(true);
                $results[$testName] ??= 0;
                $results[$testName] += ($endTime - $startTime) / $this->repeatCount * 1000000;
            }
        }
        asort($results);
        $minTime = min(...array_values($results));

        $nameLength = $this->getMaxNameLength();
        $timeLength = $this->getMaxTimeLength($results);
        $rateLength = 7; // "000.00%"
        $fullLength = mb_strlen(sprintf("%-'-{$nameLength}s | %-'-{$timeLength}s | %-'-{$rateLength}s", "", "", ""));

        $descriptionLength = $this->getMaxDescriptionLength();
        if($fullLength < $descriptionLength){
            $nameLength += $descriptionLength - $fullLength;
            $fullLength = $descriptionLength;
        }

        printf("┌--%-'-{$fullLength}s┐\n", $name);
        if(!empty($this->descriptions)){
            foreach($this->descriptions as $description){
                printf("| %-' {$fullLength}s |\n", $description);
            }
        }
        if(!empty($this->infos)){
            $infoLength = self::getMaxInfoLength();
            foreach($this->infos as $infoName => $value){
                printf("| %+' {$fullLength}s |\n", sprintf("%s : %-' {$infoLength}s", $infoName, $value));
            }
        }
        if(!empty($this->descriptions) || !empty($this->infos)){
            printf("|-%-'-{$fullLength}s-|\n", "");
        }

        printf("| %-' {$nameLength}s | %-' {$timeLength}s | %-' {$rateLength}s |\n", self::CODE, self::TIME, self::RATE);
        printf("|-%-'-{$nameLength}s-|-%-'-{$timeLength}s-|-%-'-{$rateLength}s-|\n", "", "", "");
        foreach($results as $testName => $result){
            printf("| %-{$nameLength}s | %2.2fµs | %3.2f%% |\n",
                $testName,
                $result,
                $result / $minTime * 100,
            );
        }
        printf("└-%-'-{$fullLength}s-┘\n", "");
    }
}