<?php

use yii\db\Migration;
use common\models\enums\AppleStatus;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m200103_191529_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string()->notNull(),
            'date_born' => $this->integer()->notNull(),
            'date_fall' => $this->integer(),
            'status' => "ENUM('". implode("','", AppleStatus::listData())
                ."') NOT NULL DEFAULT '" . AppleStatus::getLabel(AppleStatus::ON_TREE) . "'",
            'eaten' => $this->integer()->defaultValue(0)->notNull(),

            'date_created' => $this->datetime()->notNull()->defaultValue(new \yii\db\Expression('NOW()')),
            'date_updated' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }
}
