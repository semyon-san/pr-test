<?php

namespace backend\models;

use common\models\enums\AppleStatus;
use yii\base\InvalidArgumentException;

class Apple extends \common\models\Apple
{
    const EXPIRE_HOURS = 5;
    const DEFAULT_COLOR = 'green';

    public function __construct($color=self::DEFAULT_COLOR, array $config = [])
    {
        $this->color = $color;

        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
        if ($this->isNewRecord) {
            $this->status = AppleStatus::ON_TREE;
            $this->date_born = time();
        }
    }

    public function getSize()
    {
        $percentage = (100 - $this->eaten);
        if ($percentage === 100) {
            return 1;
        }

        if ($percentage === 0) {
            return 0;
        }

        return round($percentage/100, 2);
    }

    public function isExpired()
    {
        if ($this->isRotten()) {
            return true;
        }

        if ($this->isOnTree()) {
            return false;
        }

        if (($this->date_born + 3600 * static::EXPIRE_HOURS) < time()) {
            $this->status = AppleStatus::ROTTEN;
            return true;
        }

        return false;
    }

    /**
     * @param $percentage
     * @throws InvalidArgumentException
     */
    public function eat($percentage)
    {
        if ($this->isOnTree()) {
            throw new InvalidArgumentException('Съесть нельзя, яблоко на дереве');
        }

        if ($this->isExpired()) {
            throw new InvalidArgumentException('Съесть нельзя, яблоко испорчено');
        }

        $eaten = 100 - $this->eaten;
        if ($percentage > $eaten) {
            throw new InvalidArgumentException('Попытка съесть больше чем осталось');
        }

        $this->eaten += $percentage;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isExpired()) {
            $this->status = AppleStatus::ROTTEN;
        }

        return true;
    }
}