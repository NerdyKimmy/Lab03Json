<?php

namespace app\components;

use Yii;

class JsonFileHandler
{
    private $jsonFilePath;

    public function __construct($jsonFilePath = '@webroot/json/data.json')
    {
        $this->jsonFilePath = Yii::getAlias($jsonFilePath);
    }

    public function getAllCharacters()
    {
        if (!file_exists($this->jsonFilePath)) {
            return [];
        }
        $jsonData = file_get_contents($this->jsonFilePath);
        return json_decode($jsonData, true);
    }

    public function getCharacterById($id)
    {
        $characters = $this->getAllCharacters();
        foreach ($characters as $character) {
            if ($character['id'] == $id) {
                return $character;
            }
        }
        return null;
    }

    public function saveAllCharacters(array $characters)
    {
        return file_put_contents($this->jsonFilePath, json_encode($characters, JSON_PRETTY_PRINT));
    }

    public function deleteCharacter($id)
    {
        $characters = $this->getAllCharacters();
        $characters = array_filter($characters, fn($character) => $character['id'] != $id);
        return $this->saveAllCharacters($characters);
    }

    public function deserializeJson($jsonData)
    {
        $data = json_decode($jsonData, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            throw new \RuntimeException('Invalid JSON data.');
        }
    
        foreach ($data as $item) {
            if (!isset($item['id'], $item['name'], $item['city'], $item['class'])) {
                throw new \RuntimeException('Invalid JSON structure.');
            }
        }
    
        return $this->saveAllCharacters($data);
    }
    
}
