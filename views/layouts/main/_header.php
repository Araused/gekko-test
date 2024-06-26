<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Html;

//@TODO вынести в отдельный хелпер?
$bsIcon = function (string $name) {
    return Html::tag('i', '', [
        'class' => 'bi bi-' . $name,
    ]);
};

$homeLabel = $bsIcon('house') . ' Главная';
$loginLabel = $bsIcon('box-arrow-in-right') . ' Войти';
$logoutLabel = $bsIcon('box-arrow-right') . ' Выйти [' . (Yii::$app->user->identity->username ?? "") . ']';
$parserLabel = $bsIcon('tools') . ' Парсер';

$logoutButton = Html::submitButton($logoutLabel, ['class' => 'nav-link btn btn-link logout']);

$logoutHtml = Html::tag(
    'li',
    Html::beginForm(['/site/logout']) . $logoutButton . Html::endForm(),
    ['class' => 'nav-item']
);
?>
<header id="header">
    <?php NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'encodeLabels' => false,
        'items' => [
            ['label' => $homeLabel, 'url' => ['/site/index']],
            ['label' => $parserLabel, 'url' => ['/parser/index'], 'visible' => !Yii::$app->user->isGuest],
            Yii::$app->user->isGuest
                ? ['label' => $loginLabel, 'url' => ['/site/login']]
                : $logoutHtml,
        ],
    ]);
    NavBar::end();
    ?>
</header>