<?php
use yii\helpers\Html;

$this->title = 'View Character: ' . $character['name'];
?>
<div class="character-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $character['id']], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $character['id']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <table class="table table-bordered">
        <tr><th>Name</th><td><?= Html::encode($character['name']) ?></td></tr>
        <tr><th>City</th><td><?= Html::encode($character['city']) ?></td></tr>
        <tr><th>Class</th><td><?= Html::encode($character['class']) ?></td></tr>
        <tr><th>Specialization</th><td><?= Html::encode($character['specialization']) ?></td></tr>
        <tr><th>Attack</th><td><?= Html::encode($character['attack']) ?></td></tr>
        <tr><th>Defense</th><td><?= Html::encode($character['defense']) ?></td></tr>
        <tr><th>Knowledge</th><td><?= Html::encode($character['knowledge']) ?></td></tr>
        <tr><th>Spell Power</th><td><?= Html::encode($character['spellPower']) ?></td></tr>
    </table>
</div>
