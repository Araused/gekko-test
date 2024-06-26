<?php

/** @var yii\web\View $this */
/** @var string $count */

use yii\bootstrap5\Html;

$example = file_get_contents(Yii::getAlias('@app/views/parser') . '/example.html');
$this->title = 'Главная';
?>
<div class="site-index">
    <h1>Добро пожаловать!</h1>

    <p class="lead my-4">
        Перед вами результат выполнения тестового задания для <b>«Gekko»</b>
        <br>
        Исходный код приложения можно посмотреть <a href="https://github.com/Araused/parser-test" target="_blank">тут</a>
        <br>
        Загружено html-файлов: <b class="text-success"><?= $count ?></b>
    </p>

    <div class="body-content">
        <p>
            Данное web-приложение, по сути, это простой парсер HTML-таблиц для построения графика изменений баланса.
            <br>
            Парсинг данных производится по следующему алгоритму:
        </p>
        <ul>
            <li>
                В полученном из загруженного файла HTML-коде ищем элемент <code>&lt;table&gt;</code>
            </li>
            <li>
                Каждую строку <code>&lt;tr&gt;</code> найденной таблицы проверяем на наличие дочерних элементов:
                <code>&lt;td class="msdate"&gt;</code> и <code>&lt;td class="mspt"&gt;</code>
            </li>
            <li>
                Если строка <code>&lt;tr&gt;</code> содержит несколько элементов <code>&lt;td class="mspt"&gt;</code>,
                для построения графика используем значение из последнего, т.к. график строим по столбику Profit
            </li>
            <li>
                Данные из <code>&lt;td class="msdate"&gt;</code> и <code>&lt;td class="mspt"&gt;</code> собираем в массив
                вида: <span class="font-monospace text-primary">[дата-время] => [насколько изменился баланс]</span>
            </li>
            <li>
                Остальные строки <code>&lt;tr&gt;</code> просто игнорируем.
            </li>
        </ul>
        <p>
            Таким образом, для построения графика загружаемый HTML-файл должен соответствовать примерно такому формату:
            <pre><code><?= htmlentities($example) ?></code></pre>
            Опробовать работу парсера можно <?= Html::a('тут', ['/parser']) ?>
            <br>
            <small class="text-danger">*</small>
            <small class="text-body-tertiary">Раздел "Парсер" доступен только авторизованным пользователям</small>
        </p>
    </div>
</div>
