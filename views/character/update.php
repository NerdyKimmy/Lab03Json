<?php
use yii\helpers\Html;

$this->title = 'Update Character: ' . $model->getName();
?>
<div class="character-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 
    ]) ?>
</div>
