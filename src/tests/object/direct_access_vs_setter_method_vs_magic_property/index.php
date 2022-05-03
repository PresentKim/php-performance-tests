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

require_once __DIR__ . "/../../../compare/PerformanceComparator.php";

/** @property string $magic */
class Data{
    public int $public = 0;
    private int $private = 0;

    public function getPrivate() : int{ return $this->private; }

    public function setPrivate(int $value) : void{ $this->private = $value; }

    public function __isset(string $name) : bool{
        return $name === "magic";
    }

    public function __get(string $name) : int{
        return $name === "magic" ? $this->private : -1;
    }

    public function __set(string $name, mixed $value) : void{
        if($name === "magic" && is_int($value)){
            $this->private = $value;
        }
    }
}

return PerformanceComparator::compareFromBaseDir(
    name: "Direct access vs Setter method vs Magic property",
    baseDir: __DIR__,
    descriptions: ["Given object has public property(\$public), private property(\$private), magic property(\$magic)"],
    repeatCount: 50000,
    arguments: [new Data()]
);