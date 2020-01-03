<?php

namespace backend\tests\unit\models;

use backend\models\Apple;
use yii\base\InvalidArgumentException;

class AppleTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function testEatOnTree()
    {
        $model = new Apple('green');

        expect($model->size)->equals(1);

        $this->tester->expectThrowable(new InvalidArgumentException('Съесть нельзя, яблоко на дереве'),
            function() use ($model) {
                $model->eat(50);
            }
        );

        expect($model->size)->equals(1);
    }

    public function testEatFallenAmount()
    {
        $apple = new Apple('red');

        $apple->fallToGround(); // упасть на землю
        $apple->eat(25); // откусить четверть яблока
        expect($apple->size)->equals(0.75);
    }

    public function testEatExpired()
    {
        $apple = new Apple('red');

        expect_that(!$apple->isRotten());

        $apple->fallToGround(); // упасть на землю

        $apple->date_born = time() - (Apple::EXPIRE_HOURS*3600 + 10);

        expect_that($apple->isExpired());

        $this->tester->expectThrowable(new InvalidArgumentException('Съесть нельзя, яблоко испорчено'),
            function() use ($apple) {
                $apple->eat(50);
            }
        );

        expect_that($apple->isRotten());
    }
}
