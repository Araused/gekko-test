<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\UploadForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = 'Парсер HTML';
$this->params['breadcrumbs'][] = $this->title;

//@TODO вынести в отдельный хелпер?
$bsIcon = function (string $name) {
    return Html::tag('i', '', [
        'class' => 'bi bi-' . $name,
    ]);
};
?>
<div class="parser-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card my-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                        <?= $form->field($model, 'file')->fileInput() ?>
                        <button type="submit" class="btn btn-primary">Загрузить</button>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'columns' => [
            'id',
            [
                'attribute' => 'file',
                'content' => function ($model) {
                    /* @var $model \app\models\Html */
                    return Html::tag('code', $model->originalName);
                },
            ],
            [
                'attribute' => 'uploaded_at',
                'format' => ['date', 'dd.MM.YYYY HH:mm:ss']
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{chart} {view} {delete}',
                'headerOptions' => ['width' => '265'],
                'buttons' => [
                    'chart' => function ($url) use ($bsIcon) {
                        return Html::a($bsIcon('bar-chart-line-fill') . ' График', $url, [
                            'class' => 'btn btn-outline-primary btn-sm',
                            'title' => 'Построить график',
                            'aria-label' => 'Построить график',
                        ]);
                    },
                    'view' => function ($url, $model) use ($bsIcon) {
                        /* @var $model \app\models\Html */
                        return Html::a($bsIcon('file-code-fill') . ' Файл', $model->downloadLink, [
                            'class' => 'btn btn-outline-secondary btn-sm',
                            'target' => '_blank',
                            'title' => 'Исходный файл',
                            'aria-label' => 'Исходный файл',
                        ]);
                    },
                    'delete' => function ($url) use ($bsIcon) {
                        /* @var $model \app\models\Html */
                        return Html::a($bsIcon('trash3') . ' Удалить', $url, [
                            'class' => 'btn btn-outline-danger btn-sm',
                            'title' => 'Удалить файл',
                            'aria-label' => 'Удалить файл',
                            'data-method' => 'post',
                            'data-confirm' => 'Вы уверены?',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

    <!--<table class="table table-striped">
        <thead>
            <th>Дата загрузки</th>
            <th>Исходное имя файла</th>
            <th></th>
        </thead>
        <tbody>
            <?php if (empty($uploadSummary)): ?>
                <tr class="table-secondary">
                    <td colspan="3" class="text-center">
                        <i>- Файлы не найдены -</i>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($uploadSummary as $fileInfo): ?>

                    <tr>
                        <td><i><?= $fileInfo['uploadAt'] ?></i></td>
                        <td><code><?= $fileInfo['originalName'] ?></code></td>
                        <td><?= Html::a('Построить график', ['/parser/chart', 'name' => $fileInfo['fullName']]) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>-->
</div>
