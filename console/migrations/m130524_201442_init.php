<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'backend_password' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->datetime()->notNull()->defaultValue(new \yii\db\Expression('NOW()')),
            'updated_at' => $this->datetime(),
        ], $tableOptions);

        $password = md5(time());

        $this->insert('user', [
            'username' => 'semyon',
            'password_hash' => \Yii::$app->security->generatePasswordHash($password),
            'backend_password' => \common\models\User::generateBackendPasswordHash($password),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'email' => 'semyon.h@prhol.ru',
            'status' => \common\models\User::STATUS_ACTIVE,
        ]);

        echo 'PASSWORD: ' . $password . PHP_EOL;
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
