<?php
use yii\helpers\Html;

$this->title = 'Create Character';
?>
<div class="character-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
