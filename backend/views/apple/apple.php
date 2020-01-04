<?php

namespace backend\views\apple;

use common\models\enums\AppleStatus;

/**
 * @var $apple \backend\models\Apple
 */
?>

<div id="apple-<?= $apple->id ?>" class="col-lg-4">
    <h2>Яблоко <?= $apple->id ?></h2>
    <div class="row">
        <div class="col-lg-2">
            <i class="apple-icon fab fa-apple" style="color:<?= $apple->color ?>"></i>
        </div>
        <div class="col-lg-10">
            <ul class="apple-info">
                <li>Родилась: <span class="apple-born"><?= date('H:i:s d/m/Y', $apple->date_born) ?></span></li>
                <li>Статус: <span class="apple-status"><?= AppleStatus::getLabel($apple->status) ?></span></li>
                <li>Осталось: <span class="apple-size"><?= $apple->size * 100 ?>%</span></li>
            </ul>
        </div>
    </div>
    <p>
        <a class="apple-drop-btn btn btn-success <?= !$apple->isOnTree() ? 'disabled' : '' ?>" href="#" data-id="<?= $apple->id ?>">Упасть</a>
        <a class="apple-eat-btn btn btn-warning" href="#" data-id="<?= $apple->id ?>">Съесть</a>
        <a class="apple-delete-btn btn btn-danger" href="#" data-id="<?= $apple->id ?>">Удалить</a>
    </p>
</div>
