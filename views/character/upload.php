<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Upload JSON';
?>
<div class="character-upload">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'jsonFile')->fileInput(['accept' => 'application/json']) ?>

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
