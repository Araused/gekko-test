<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\models\Html;
use app\models\Parser;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['file'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'html',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Загрузить файл для парсинга',
        ];
    }

    /**
     * @return string
     */
    public function buildPath()
    {
        if ($this->file) {
            $uniqid = uniqid();
            FileHelper::createDirectory(Yii::getAlias('@webroot') . '/' . Html::PATH_PREFIX . $uniqid);
            return $uniqid . '/' . $this->file->baseName . '.' . $this->file->extension;
        }

        return '';
    }

    /**
     * @return int|false
     */
    public function uploadAndParse()
    {
        if ($this->validate()) {
            $path = $this->buildPath();
            $pathWithPrefix = Html::PATH_PREFIX . $path;

            if ($this->file->saveAs($pathWithPrefix)) {
                $data = Parser::parseFile(Yii::getAlias('@webroot') . '/' . $pathWithPrefix);

                $model = new Html;
                $model->file = $path;
                $model->data = json_encode($data);

                if ($model->save()) {
                    return $model->id;
                }
            }
        }

        return false;
    }
}