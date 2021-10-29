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
$tests = new TestGroup(1000000);

$tests->addTest('switch', function(){
    switch(11){
        case 0 :
            return "Hel";
        case 1:
        case 2:
        case 3 :
            return "lo,";
        case 5:
        case 6 :
            return " wo";
        case 9:
        case  10 :
            return "rld";
        default :
            return "!";
    }
});
$tests->addTest('match', function(){
    return match (11) {
        0 => "Hel",
        1, 2, 3 => "lo,",
        5, 6 => " wo",
        9, 10 => "rld",
        default => "!"
    };
});
$tests->addTest('==', function(){
    $rand = 11;
    if($rand == 0){
        return "Hel";
    }elseif($rand == 1 || $rand == 2 || $rand == 3){
        return "lo,";
    }elseif($rand == 5 || $rand == 6){
        return " wo";
    }elseif($rand == 9 || $rand == 10){
        return "rld";
    }else{
        return "!";
    }
});
$tests->addTest('===', function(){
    $rand = mt_rand(0, 10);
    if($rand === 0){
        return "Hel";
    }elseif($rand === 1 || $rand === 2 || $rand === 3){
        return "lo,";
    }elseif($rand === 5 || $rand === 6){
        return " wo";
    }elseif($rand === 9 || $rand === 10){
        return "rld";
    }else{
        return "!";
    }
});
$tests->run();
