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

/** @property string $magicProperty */
class Test{
    public string $publicProperty = "Use by modern accessor";
    private string $_magicProperty = "Use by magic method";
    private string $methodProperty = "Use by getter setter";

    public function get() : string{ return $this->methodProperty; }

    public function set(string $value) : void{ $this->methodProperty = $value; }

    public function __get(string $name) : mixed{
        return $name === "magicProperty" ? $this->_magicProperty
            : throw new ErrorException("Undefined property: Test::\$$name");
    }

    public function __set(string $name, mixed $value) : void{
        if($name === "magicProperty"){
            $this->_magicProperty = $value;
        }else{
            throw new ErrorException("Undefined property: Test::\$$name");
        }
    }
}

$obj = new Test();
$tests->addDescriptions('$obj = new class(){
    public string $publicProperty;
    private string $_magicProperty;
    private string $methodProperty;

    public function get() : string;        //get $this->methodProperty 
    public function set(string);           //set $this->methodProperty 
    public function __get(string) : mixed; //get $this->_magicProperty 
    public function __set(string, mixed);  //set $this->_magicProperty 
}');

$tests->addTest('$obj->publicProperty = strrev($obj->publicProperty)', function() use ($obj){
    $obj->publicProperty = strrev($obj->publicProperty);
});
$tests->addTest('$obj->set(strrev($obj->get()))', function() use ($obj){
    $obj->set(strrev($obj->get()));
});
$tests->addTest('$obj->magicProperty = strrev($obj->magicProperty);', function() use ($obj){
    $obj->magicProperty = strrev($obj->magicProperty);
});
$tests->run();
