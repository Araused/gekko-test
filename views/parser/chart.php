<?php

/** @var yii\web\View $this */
/** @var app\models\Html $model */

use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use dosamigos\chartjs\ChartJs;

$this->title = 'График из HTML-файла';
$this->params['breadcrumbs'][] = ['label' => 'Парсер HTML', 'url' => '/parser'];
$this->params['breadcrumbs'][] = $this->title;

$data = json_decode($model->data);
$dataDates = ArrayHelper::getColumn($data, 'date');
$dataValues = ArrayHelper::getColumn($data, 'balance');
?>
<div class="parser-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="mt-4">
        <label>Имя файла</label>: <code><?= $model->originalName ?></code>
        <br>
        <label>Дата загрузки</label>: <i><?= date('d.m.Y H:i:s', $model->uploaded_at) ?></i>
    </div>

    <div class="card my-4">
        <div class="card-body">
            <?php if (!empty($dataValues) && !empty($dataDates)): ?>
                <?= ChartJs::widget([
                    'type' => 'line',
                    'options' => [
                        'height' => 800,
                        'width' => 1200,
                    ],
                    'data' => [
                        'labels' => $dataDates,
                        'datasets' => [
                            [
                                'label' => "Изменения баланса",
                                'backgroundColor' => "rgba(179, 181, 198, 0.2)",
                                'borderColor' => "rgba(179, 181, 198, 1)",
                                'pointBackgroundColor' => "rgba(179, 181, 198, 1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(179, 181, 198, 1)",
                                'data' => $dataValues,
                            ],
                        ],
                    ],
                ]) ?>
            <?php else: ?>
                <div class="text-center"><code>- Нет данных -</code></div>
            <?php endif; ?>
        </div>
    </div>
</div>
