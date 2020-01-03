<?php

namespace common\models;

use common\models\enums\AppleStatus;
use Yii;

class Apple extends records\Apple
{
    public function init()
    {
        parent::init();

        if ($this->isNewRecord) {
            $this->status = AppleStatus::ON_TREE;
            $this->date_born = time();
            $this->eaten = 0;
        }
    }
}
