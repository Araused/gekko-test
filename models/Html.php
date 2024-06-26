<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

/**
 * @package app\models
 *
 * @property int $id
 * @property string $file
 * @property string $data
 * @property int $uploaded_at
 *
 * @property string $originalName
 * @property string $downloadLink
 */
class Html extends ActiveRecord
{
    const PATH_PREFIX = 'upload/html/';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    parent::EVENT_BEFORE_INSERT => ['uploaded_at'],
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'Файл',
            'data' => 'Данные парсинга',
            'uploaded_at' => 'Дата загрузки',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete()
    {
        $dir = dirname(Yii::getAlias('@webroot') . '/' . Html::PATH_PREFIX . $this->file);
        FileHelper::removeDirectory($dir);
        parent::afterDelete();
    }

    /**
     * @return string
     */
    public function getDownloadLink()
    {
        return '/' . self::PATH_PREFIX . $this->file;
    }

    /**
     * @return string
     */
    public function getOriginalName()
    {
        $parts = explode('/', $this->file);

        return $parts[1] ?? '';
    }
}