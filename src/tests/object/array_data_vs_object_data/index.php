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

const ITEM_COUNT = 1000;

class PlayerData implements JsonSerializable{

    public function __construct(
        public string $name,
        public string $uuid,
        public int $level,
        public int $money,
        public int $x,
        public int $y,
        public int $z
    ){
    }

    public function jsonSerialize() : array{
        return [
            "name" => $this->name,
            "uuid" => $this->uuid,
            "level" => $this->level,
            "money" => $this->money,
            "x" => $this->x,
            "y" => $this->y,
            "z" => $this->z
        ];
    }

}

function generateUUIDv4() : string{
    /** @noinspection PhpUnhandledExceptionInspection */
    $data = random_bytes(16);
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
    return vsprintf("%08s-%04s-%04s-%04s-%12s", str_split(bin2hex($data), 4));
}

// 랜덤 문자열 생성 함수
function generateRandomString(int $length) : string{
    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $charactersLength = strlen($characters);
    $randomString = "";
    for($i = 0; $i < $length; $i++){
        /** @noinspection PhpUnhandledExceptionInspection */
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

// 더미 데이터 생성
function createDummyPlayerData() : PlayerData{
    /** @noinspection PhpUnhandledExceptionInspection */
    return new PlayerData(
        name: generateRandomString(random_int(5, 15)), // 랜덤 문자열 5~15자
        uuid: generateUUIDv4(),                        // 랜덤 UUIDv4
        level: random_int(1, 100),                     // 랜덤 정수 1~100
        money: random_int(10000, 1000000000000),       // 랜덤 정수 1만~1조
        x: random_int(-999, 999),                      // 랜덤 정수 -999~999
        y: random_int(-999, 999),                      // 랜덤 정수 -999~999
        z: random_int(-999, 999)                       // 랜덤 정수 -999~999
    );
}

/**
 * 더미 배열의 첫번째 배열은 array 형식의 데이터가 들어간 배열, 두번째 배열은 PlayerData 형식의 데이터가 들어간 배열입니다.
 */
$arguments = [[], []];
for($i = 0; $i < ITEM_COUNT; ++$i){
    $dummyPlayerData = createDummyPlayerData();
    $arguments[0][] = $dummyPlayerData->jsonSerialize();
    $arguments[1][] = $dummyPlayerData;
}

PerformanceComparator::compareFromBaseDir(
    name: "Array data vs Object data",
    baseDir: __DIR__,
    descriptions: [
        "Given an array containing " . ITEM_COUNT . " items of dummy game player data. " .
        "Measure the amount of time it takes to set levels to 1 and increase money by 3x"
    ],
    repeatCount: 3000,
    arguments: $arguments
);