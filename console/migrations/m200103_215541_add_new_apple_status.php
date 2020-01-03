<?php

use yii\db\Migration;
use common\models\enums\AppleStatus;
/**
 * Class m200103_215541_add_new_apple_status
 */
class m200103_215541_add_new_apple_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('apple', 'status',
            "ENUM('". implode("','", AppleStatus::getConstantsByName())
            ."') NOT NULL DEFAULT '" . AppleStatus::ON_TREE . "'"
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
