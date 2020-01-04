<?php

/* @var $this \yii\web\View */
/* @var $apples[] \backend\models\Apple */

namespace backend\views;

use kartik\dialog\Dialog;

$this->title = 'Яблоки';
?>

<?= Dialog::widget([
    'libName' => 'krajeeDialogEat',
    'options' => [
        'title' => 'Съесть',
        'type' => Dialog::TYPE_WARNING,
    ],
]) ?>

<?= Dialog::widget([
    'libName' => 'krajeeDialogError',
    'options' => [
        'title' => 'Ошибка',
        'type' => Dialog::TYPE_DANGER,
    ],
]) ?>

<div class="site-index">

    <div class="jumbotron">
        <p><a id="gen-apples-btn" class="btn btn-lg btn-primary" href="#">Сгенерировать яблоки</a></p>
    </div>

    <div class="body-content">

        <div id="apples" class="row">
            <?php foreach ($apples as $apple) : ?>
                <?= $this->render('//apple/apple', ['apple' => $apple]) ?>
            <?php endforeach; ?>
        </div>

    </div>
</div>
