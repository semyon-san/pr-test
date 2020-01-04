<?php

namespace backend\controllers;

use backend\models\Apple;
use yii\base\InvalidArgumentException;
use yii\rest\Controller;
use Yii;
use yii\helpers\Html;
use common\models\enums\AppleStatus;

class AppleController extends Controller
{
    const MAX_NUM_APPLES = 7;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'generate-random' => ['GET'],
                    'fall' => ['POST'],
                    'eat' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
            [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionGenerateRandom()
    {
        $apples = [];

        $numApples = rand(1, self::MAX_NUM_APPLES);

        for ($i = 0; $i < $numApples; $i++) {
            $apple = new Apple($this->generateRandomColor());
            $apple->date_born = time() - rand(0, Apple::EXPIRE_HOURS)*3600;
            if (!$apple->save()) {
                throw new \yii\db\Exception(Html::errorSummary($apple, ['encode' => false]));
            }

            $apples[] = $this->renderPartial('apple', ['apple' => $apple]);
        }

        return $apples;
    }

    private function generateRandomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }


    /**
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionFall()
    {
        $appleId = Yii::$app->request->post('id');

        $apple = $this->getApple($appleId);

        $apple->fallToGround();
        if (!$apple->save()) {
            throw new \yii\db\Exception(Html::errorSummary($apple, ['encode' => false]));
        }

        return AppleStatus::getLabel($apple->status);
    }

    /**
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionEat()
    {
        $appleId = Yii::$app->request->post('id');
        $percent = intval(Yii::$app->request->post('percent'));

        if (!$percent || $percent < 0 || $percent > 100) {
            throw new \yii\web\BadRequestHttpException('Неправильный процент');
        }

        $apple = $this->getApple($appleId);

        try {
            $apple->eat($percent);
        } catch (InvalidArgumentException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }

        if ($apple->size === 0) {
            $apple->delete();

            return 0;
        }

       if (!$apple->save()) {
            throw new \yii\db\Exception(Html::errorSummary($apple, ['encode' => false]));
       }

       return $apple->size * 100;
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete()
    {
        $appleId = Yii::$app->request->post('id');

        $apple = $this->getApple($appleId);

        $apple->delete();

        return true;
    }

    private function getApple($id)
    {
        if (!$id) {
            throw new \yii\web\NotFoundHttpException('Яблоко не найдено: ' . $id);
        }

        $apple = Apple::findOne($id);
        if (!$apple) {
            throw new \yii\web\NotFoundHttpException('Яблоко не найдено: ' . $id);
        }

        return $apple;
    }
}
