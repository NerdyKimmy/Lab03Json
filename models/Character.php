<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\JsonFileHandler;


class Character extends Model
{
    private $id;
    private $name;
    private $city;
    private $class;
    private $specialization;
    private $attack;
    private $defense;
    private $knowledge;
    private $spellPower;

    public $jsonFile;

    public function rules()
    {
        return [
            [['name', 'city', 'class', 'specialization', 'attack', 'defense', 'knowledge', 'spellPower'], 'required'],
            [['attack', 'defense', 'knowledge', 'spellPower'], 'integer'],
            [['name', 'city', 'class', 'specialization'], 'string', 'max' => 255],
            [['jsonFile'], 'file', 'extensions' => 'json', 'checkExtensionByMimeType' => true],
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getSpecialization()
    {
        return $this->specialization;
    }

    public function getAttack()
    {
        return $this->attack;
    }

    public function getDefense()
    {
        return $this->defense;
    }

    public function getKnowledge()
    {
        return $this->knowledge;
    }

    public function getSpellPower()
    {
        return $this->spellPower;
    }

    // Сеттеры
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;
    }

    public function setAttack($attack)
    {
        $this->attack = $attack;
    }

    public function setDefense($defense)
    {
        $this->defense = $defense;
    }

    public function setKnowledge($knowledge)
    {
        $this->knowledge = $knowledge;
    }

    public function setSpellPower($spellPower)
    {
        $this->spellPower = $spellPower;
    }

    public function save(JsonFileHandler $jsonHandler)
    {
        $characters = $jsonHandler->getAllCharacters();

        if ($this->id === null) {
            $this->id = time(); // Генерация уникального ID
            $characters[] = $this->toArray();
        } else {
            foreach ($characters as &$character) {
                if ($character['id'] == $this->id) {
                    $character = $this->toArray();
                    break;
                }
            }
        }

        return $jsonHandler->saveAllCharacters($characters);
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'class' => $this->class,
            'specialization' => $this->specialization,
            'attack' => $this->attack,
            'defense' => $this->defense,
            'knowledge' => $this->knowledge,
            'spellPower' => $this->spellPower,
        ];
    }

    public function getJsonFile()
    {
        return $this->jsonFile;
    }

    public function setJsonFile($jsonFile)
    {
        $this->jsonFile = $jsonFile;
    }
    
}
