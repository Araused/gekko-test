<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\Html;
use app\models\UploadForm;

class ParserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $id = $model->uploadAndParse();

            if ($id !== false) {
                Yii::$app->session->setFlash('success', 'Файл успешно загружен.');

                return $this->redirect(['chart', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('error', 'При загрузке/парсинге произошла ошибка.');
            }
        }

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => new ActiveDataProvider([
                'query' => Html::find(),
            ]),
        ]);
    }

    /**
     * @param integer $id
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function actionChart($id)
    {
        $model = $this->findModel($id);

        return $this->render('chart', [
            'model' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return Html
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Html::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('HTML-файл не найден.');
    }
}
