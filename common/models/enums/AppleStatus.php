<?php

namespace common\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class AppleStatus extends BaseEnum
{
    const ON_TREE = 'on_tree';
    const FALLEN = 'fallen';
    const ROTTEN = 'rotten';

    public static $list = [
        self::ON_TREE => 'Висит на дереве',
        self::FALLEN => 'Упало/лежит на земле',
        self::ROTTEN => 'Гнилое яблоко',
    ];
}