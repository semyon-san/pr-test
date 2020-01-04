<?php

namespace backend\controllers;

use backend\models\Apple;
use yii\rest\Controller;
use Yii;

class AppleController extends Controller
{
    const NUM_APPLES = 6;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'generate-random' => ['GET'],
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

        for ($i = 0; $i < self::NUM_APPLES; $i++) {
            $apple = new Apple($this->generateRandomColor());
            $apple->date_born = time() - rand(0, Apple::EXPIRE_HOURS)*3600;
            if (!$apple->save()) {
                throw new \yii\db\Exception($apple->getFirstError());
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
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete()
    {
        $appleId = Yii::$app->request->post('id');
        if (!$appleId) {
            throw new \yii\web\NotFoundHttpException('Яблоко не найдено: ' . $appleId);
        }

        $apple = Apple::findOne($appleId);
        if (!$apple) {
            throw new \yii\web\NotFoundHttpException('Яблоко не найдено: ' . $appleId);
        }

        $apple->delete();

        return true;
    }
}
