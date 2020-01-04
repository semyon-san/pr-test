<?php

namespace common\models\records;

use common\models\enums\AppleStatus;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property int $date_born
 * @property int|null $date_fall
 * @property string $status
 * @property int $eaten
 * @property string $date_created
 * @property string|null $date_updated
 */
class Apple extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'date_born'], 'required'],
            [['date_born', 'date_fall'], 'integer'],

            ['date_born', 'default', 'value' => time()],

            ['eaten', 'integer', 'min' => 0, 'max' => 100],

            [['status'], 'string'],
            ['status', 'default', 'value' => AppleStatus::ON_TREE],
            ['status', 'in', 'range' => AppleStatus::getConstantsByName()],

            [['color'], 'string', 'max' => 255],

            [['date_created', 'date_updated'], 'datetime', 'format' => 'php:Y-m-d H:i:s']
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => 'date_updated',
                'value' => gmdate('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'date_born' => 'Дата появления',
            'date_fall' => 'Дата падения',
            'status' => 'Статус',
            'eaten' => 'Сколько съели',

            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    public function isFallen()
    {
        return $this->status === AppleStatus::FALLEN;
    }

    public function isOnTree()
    {
        return $this->status === AppleStatus::ON_TREE;
    }

    public function isRotten()
    {
        return $this->status === AppleStatus::ROTTEN;
    }

    public function fallToGround()
    {
        if ($this->isOnTree()) {
            $this->status = AppleStatus::FALLEN;
        }
    }
}
