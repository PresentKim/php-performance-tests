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
 * @noinspection TypeUnsafeComparisonInspection
 * @noinspection RedundantElseClauseInspection
 */

declare(strict_types=1);

return [
    '==',
    static function(int $num) : string{
        if($num == 0){
            return "Hel";
        }elseif($num == 1 || $num == 2 || $num == 3){
            return "lo,";
        }elseif($num == 5 || $num == 6){
            return " wo";
        }elseif($num == 9 || $num == 10){
            return "rld";
        }else{
            return "!";
        }
    }
];