<?php
use yii\helpers\Html;

$this->title = 'Characters';
?>
<div class="character-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Character', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload JSON', ['upload-json'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Download JSON', ['download-json'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="form-group">
        <input type="text" id="search-box" class="form-control" placeholder="Search by any field...">
    </div>

    <table class="table table-bordered" id="characters-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>Class</th>
                <th>Specialization</th>
                <th data-sort="number">Attack <span class="sort-indicator"></span></th>
                <th data-sort="number">Defense <span class="sort-indicator"></span></th>
                <th data-sort="number">Knowledge <span class="sort-indicator"></span></th>
                <th data-sort="number">Spell Power <span class="sort-indicator"></span></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($characters as $characterData): ?>
        <?php 
            if (!isset($characterData['id'], $characterData['name'], $characterData['city'], $characterData['class'])) {
                continue; 
            }

            $character = new \app\models\Character();
            $character->setId($characterData['id']);
            $character->setName($characterData['name']);
            $character->setCity($characterData['city']);
            $character->setClass($characterData['class']);
            $character->setSpecialization($characterData['specialization'] ?? 'Unknown');
            $character->setAttack($characterData['attack'] ?? 0);
            $character->setDefense($characterData['defense'] ?? 0);
            $character->setKnowledge($characterData['knowledge'] ?? 0);
            $character->setSpellPower($characterData['spellPower'] ?? 0);
        ?>
        <tr>
            <td><?= Html::encode($character->getName()) ?></td>
            <td><?= Html::encode($character->getCity()) ?></td>
            <td><?= Html::encode($character->getClass()) ?></td>
            <td><?= Html::encode($character->getSpecialization()) ?></td>
            <td data-value="<?= Html::encode($character->getAttack()) ?>"><?= Html::encode($character->getAttack()) ?></td>
            <td data-value="<?= Html::encode($character->getDefense()) ?>"><?= Html::encode($character->getDefense()) ?></td>
            <td data-value="<?= Html::encode($character->getKnowledge()) ?>"><?= Html::encode($character->getKnowledge()) ?></td>
            <td data-value="<?= Html::encode($character->getSpellPower()) ?>"><?= Html::encode($character->getSpellPower()) ?></td>
            <td>
                <?= Html::a('View', ['view', 'id' => $character->getId()], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Update', ['update', 'id' => $character->getId()], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $character->getId()], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
    </table>
</div>

<?php
$this->registerJs(<<<JS
    // Сохраняем исходный порядок строк таблицы
    var originalRows = $('#characters-table tbody tr').toArray();

    // Поиск в таблице
    $('#search-box').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('#characters-table tbody tr').each(function() {
            var rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.includes(searchTerm));
        });
    });

    $('#characters-table thead th[data-sort="number"]').on('click', function() {
        var columnIndex = $(this).index();
        var rows = $('#characters-table tbody tr').toArray();
        var currentSortState = $(this).data('sort-state') || 'unsorted'; // Текущее состояние сортировки

        $('#characters-table thead th').data('sort-state', 'unsorted');
        $('#characters-table thead th .sort-indicator').text('');

        var newSortState;
        if (currentSortState === 'unsorted') {
            newSortState = 'asc';
        } else if (currentSortState === 'asc') {
            newSortState = 'desc';
        } else {
            newSortState = 'unsorted';
        }

        if (newSortState === 'asc') {
            rows.sort(function(a, b) {
                var aValue = parseFloat($(a).children().eq(columnIndex).data('value')) || 0;
                var bValue = parseFloat($(b).children().eq(columnIndex).data('value')) || 0;
                return aValue - bValue;
            });
            $(this).data('sort-state', 'asc');
            $(this).find('.sort-indicator').text('▲');
        } else if (newSortState === 'desc') {
            rows.sort(function(a, b) {
                var aValue = parseFloat($(a).children().eq(columnIndex).data('value')) || 0;
                var bValue = parseFloat($(b).children().eq(columnIndex).data('value')) || 0;
                return bValue - aValue;
            });
            $(this).data('sort-state', 'desc');
            $(this).find('.sort-indicator').text('▼');
        } else {
            rows = originalRows; 
            $(this).data('sort-state', 'unsorted');
        }

 
        $('#characters-table tbody').empty().append(rows);
    });
JS);
?>
