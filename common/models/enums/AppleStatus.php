<?php

namespace common\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class AppleStatus extends BaseEnum
{
    const ON_TREE = 0;
    const FALLEN = 1;

    public static $list = [
        self::ON_TREE => 'on_tree',
        self::FALLEN => 'fallen',
    ];
}