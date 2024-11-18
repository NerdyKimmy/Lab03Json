<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\Character;
use app\components\JsonFileHandler;

class CharacterController extends Controller
{
    private $jsonHandler;

    public function __construct($id, $module, $config = [])
    {
        $this->jsonHandler = new JsonFileHandler();
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $characters = $this->jsonHandler->getAllCharacters();
    
        if (!is_array($characters)) {
            Yii::$app->session->setFlash('error', 'Invalid JSON structure. Data was reset to empty.');
            $this->jsonHandler->saveAllCharacters([]); // Сбрасываем данные в пустой массив
            $characters = [];
        } else {
            foreach ($characters as $character) {
                if (!isset($character['id'], $character['name'], $character['city'], $character['class'])) {
                    Yii::$app->session->setFlash('error', 'Invalid character data detected. Data was reset to empty.');
                    $this->jsonHandler->saveAllCharacters([]);
                    $characters = [];
                    break;
                }
            }
        }
    
        return $this->render('index', ['characters' => $characters]);
    }
    

    public function actionView($id)
    {
        $character = $this->jsonHandler->getCharacterById($id);
        if ($character === null) {
            throw new NotFoundHttpException('Character not found.');
        }
        return $this->render('view', ['character' => $character]);
    }

    public function actionCreate()
    {
        $model = new Character();

        if ($model->load(Yii::$app->request->post())) {
            $characters = $this->jsonHandler->getAllCharacters();
            $model->setId(time()); // Генерация уникального ID
            $characters[] = $model->toArray();
            $this->jsonHandler->saveAllCharacters($characters);

            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $characterData = $this->jsonHandler->getCharacterById($id);
        if ($characterData === null) {
            throw new NotFoundHttpException('Character not found.');
        }
    
        $model = new Character();
    
        $model->setId($characterData['id']);
        $model->setName($characterData['name']);
        $model->setCity($characterData['city']);
        $model->setClass($characterData['class']);
        $model->setSpecialization($characterData['specialization']);
        $model->setAttack($characterData['attack']);
        $model->setDefense($characterData['defense']);
        $model->setKnowledge($characterData['knowledge']);
        $model->setSpellPower($characterData['spellPower']);
    
        if ($model->load(Yii::$app->request->post())) {
            $characters = $this->jsonHandler->getAllCharacters();
    
            foreach ($characters as &$character) {
                if ($character['id'] == $id) {
                    $character = $model->toArray(); 
                    break;
                }
            }
    
            $this->jsonHandler->saveAllCharacters($characters);
    
            return $this->redirect(['index']);
        }
    
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->jsonHandler->deleteCharacter($id);
        return $this->redirect(['index']);
    }

    public function actionUploadJson()
    {
        $model = new \app\models\Character();
    
        if (Yii::$app->request->isPost) {
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile'); // Загружаем файл
    
            if ($model->jsonFile) {
                $filePath = Yii::getAlias('@webroot/uploads/') . $model->jsonFile->name;
    
                if ($model->jsonFile->saveAs($filePath)) {
                    $jsonData = file_get_contents($filePath);
    
                    try {
                        $this->jsonHandler->deserializeJson($jsonData);
                        Yii::$app->session->setFlash('success', 'JSON successfully uploaded.');
                    } catch (\RuntimeException $e) {
                        Yii::$app->session->setFlash('error', 'Invalid JSON format. Loaded as empty.');
                        $this->jsonHandler->saveAllCharacters([]); // Сохраняем пустой массив
                    }
    
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to upload the JSON file.');
                }
            }
        }
    
        return $this->render('upload', [
            'model' => $model,
        ]);
    }
    

    public function actionDownloadJson()
    {
        $characters = $this->jsonHandler->getAllCharacters();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->headers->add('Content-Disposition', 'attachment; filename="characters.json"');
        return $characters;
    }
}
