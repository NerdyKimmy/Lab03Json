<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="character-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'value' => $model->getName()]) ?>

    <?= $form->field($model, 'city')->dropDownList([
        'Castle' => 'Castle',
        'Rampart' => 'Rampart',
        'Tower' => 'Tower',
        'Inferno' => 'Inferno',
        'Necropolis' => 'Necropolis',
        'Dungeon' => 'Dungeon',
        'Stronghold' => 'Stronghold',
        'Fortress' => 'Fortress',
        'Conflux' => 'Conflux',
        'Cove' => 'Cove',
        'Factory' => 'Factory',
    ], ['prompt' => 'Select a city', 'id' => 'city-select']) ?>

    <?= $form->field($model, 'class')->dropDownList([
        'Warrior' => 'Warrior',
        'Mage' => 'Mage',
    ], ['prompt' => 'Select a class', 'id' => 'class-select']) ?>

    <?= $form->field($model, 'specialization')->dropDownList([], [
        'prompt' => 'Select a specialization',
        'id' => 'specialization-select',
    ]) ?>

    <?= $form->field($model, 'attack')->textInput(['value' => $model->getAttack()]) ?>
    <?= $form->field($model, 'defense')->textInput(['value' => $model->getDefense()]) ?>
    <?= $form->field($model, 'knowledge')->textInput(['value' => $model->getKnowledge()]) ?>
    <?= $form->field($model, 'spellPower')->textInput(['value' => $model->getSpellPower()]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    const unitsByCity = {
        'Castle': ['Pikeman', 'Archer', 'Griffin', 'Swordsman', 'Monk', 'Cavalier', 'Angel'],
        'Rampart': ['Centaur', 'Dwarf', 'Wood Elf', 'Pegasus', 'Unicorn', 'Green Dragon', 'Gold Dragon'],
        'Tower': ['Gremlin', 'Stone Gargoyle', 'Stone Golem', 'Mage', 'Genie', 'Naga', 'Titan'],
        'Inferno': ['Imp', 'Gog', 'Hell Hound', 'Demon', 'Pit Fiend', 'Efreet', 'Devil'],
        'Necropolis': ['Skeleton', 'Zombie', 'Wight', 'Vampire', 'Lich', 'Black Knight', 'Ghost Dragon'],
        'Dungeon': ['Troglodyte', 'Harpy', 'Beholder', 'Medusa', 'Minotaur', 'Hydra', 'Black Dragon'],
        'Stronghold': ['Goblin', 'Wolf Rider', 'Orc', 'Ogre', 'Roc', 'Cyclops', 'Behemoth'],
        'Fortress': ['Gnoll', 'Lizardman', 'Serpent Fly', 'Basilisk', 'Gorgon', 'Wyvern', 'Hydra'],
        'Conflux': ['Pixie', 'Sprite', 'Air Elemental', 'Water Elemental', 'Fire Elemental', 'Earth Elemental', 'Phoenix'],
        'Cove': ['Nymph', 'Crew Mate', 'Pirate', 'Storm Bird', 'Sea Witch', 'Nix', 'Sea Serpent'],
        'Factory': ['Halfling', 'Mechanic', 'Armadillo', 'Automaton', 'Sandworm', 'Gunslinger', 'Dreadnought '],
    };

    document.getElementById('city-select').addEventListener('change', function () {
        const city = this.value;
        const specializationSelect = document.getElementById('specialization-select');
        
        specializationSelect.innerHTML = '<option value="">Select a specialization</option>';

        if (unitsByCity[city]) {
            unitsByCity[city].forEach(function (unit) {
                const option = document.createElement('option');
                option.value = unit;
                option.textContent = unit;
                specializationSelect.appendChild(option);
            });
        }
    });

    (function () {
        const city = document.getElementById('city-select').value;
        const specialization = <?= json_encode($model->getSpecialization()) ?>;
        const specializationSelect = document.getElementById('specialization-select');

        if (unitsByCity[city]) {
            unitsByCity[city].forEach(function (unit) {
                const option = document.createElement('option');
                option.value = unit;
                option.textContent = unit;
                if (unit === specialization) {
                    option.selected = true;
                }
                specializationSelect.appendChild(option);
            });
        }
    })();
</script>
