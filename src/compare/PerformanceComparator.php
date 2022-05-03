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

require_once __DIR__ . "/./CompareResult.php";

final class PerformanceComparator{
    private const DESCRIPTION = "Description";
    private const TOTAL_TIME = "Total Time";
    private const PERCENTAGE = "Percentage";

    private const DEFAULT_REPEAT_COUNT = 1000;

    /** @var string Name of the test */
    private string $name;

    /** @var int $repeatCount Repeat count of the test */
    private int $repeatCount = self::DEFAULT_REPEAT_COUNT;

    /** @var array<string> $descriptions Descriptions of the test */
    private array $descriptions = [];

    /** @var array $arguments Arguments of the test function */
    private array $arguments = [];

    /** @var array<string, callable> $tests Tests to compare */
    private array $tests = [];

    public function __construct(
        string $name
    ){
        $this->name = $name;
    }

    public function getName() : string{
        return $this->name;
    }

    public function setRepeatCount(int $repeatCount) : self{
        $this->repeatCount = $repeatCount;

        return $this;
    }

    public function getRepeatCount() : int{
        return $this->repeatCount;
    }

    public function addDescriptions(string ...$descriptions) : self{
        $this->descriptions = array_merge($this->descriptions, $descriptions);

        return $this;
    }

    /** @return array<string> */
    public function getDescriptions() : array{
        return $this->descriptions;
    }

    public function addArguments(mixed ...$args) : self{
        $this->arguments = array_merge($this->arguments, $args);

        return $this;
    }

    /** @return array */
    public function getArguments() : array{
        return $this->arguments;
    }

    public function addTest(string $description, callable $test) : self{
        $this->tests[$description] = $test;

        return $this;
    }

    /** @return array<string, callable> */
    public function getTests() : array{
        return $this->tests;
    }

    public function run() : void{
        /** @var array<CompareResult> $results */
        $results = [];
        $min = PHP_INT_MAX;
        foreach($this->tests as $testName => $test){
            $start = hrtime(true);
            for($i = 0; $i < $this->repeatCount; ++$i){
                $test(...$this->arguments);
            }
            $result = new CompareResult($testName, (hrtime(true) - $start) / 1e+6, 100.0);
            if($result->totalTime < $min){
                $min = $result->totalTime;
            }
            $results[] = $result;
        }

        foreach($results as $result){
            $result->percentage = $result->totalTime / $min * 100;
        }

        $this->exportMarkDown($results);
    }

    /** @param array<CompareResult> $results */
    private function exportMarkDown(array $results) : void{
        echo "## $this->name\n";

        foreach($this->descriptions as $description){
            echo "> $description\n";
        }
        echo "> Call {$this->repeatCount}x times to be comparable\n";

        echo PHP_EOL;
        printf("| %s | %s | %s |\n", self::DESCRIPTION, self::TOTAL_TIME, self::PERCENTAGE);
        printf("|-%s-|-%s-|-%s-|\n", "", "", "");
        foreach($results as $result){
            printf("| %s | %2.2fµs | %3.2f%% |\n", $result->name, $result->totalTime, $result->percentage);
        }
    }

    /**
     * @param string        $name Name of the test
     * @param string        $baseDir Base directory that includes the test php files
     * @param array<string> $descriptions Descriptions of the test
     * @param int           $repeatCount Repeat count of the test
     * @param array         $arguments Arguments of the test function
     *
     * @noinspection PhpIncludeInspection
     */
    public static function compareFromBaseDir(
        string $name,
        string $baseDir,
        array $descriptions = [],
        int $repeatCount = self::DEFAULT_REPEAT_COUNT,
        array $arguments = []
    ) : void{
        $comparator = new self($name);
        for($i = 1; ; ++$i){
            $path = "$baseDir/test$i.php";
            if(!file_exists($path)){
                break;
            }

            $comparator->addTest(...require("$baseDir/test$i.php"));
        }

        $comparator->setRepeatCount($repeatCount);
        $comparator->addDescriptions(...$descriptions);
        $comparator->addArguments(...$arguments);
        $comparator->run();
    }
}