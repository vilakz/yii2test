<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">


    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>Задание по работе с MongoDB и Yii2</h2>
                <ol class="cyrilic">
                <li>Реализовать модель (Yii2) для коллекции ‘product’ и наполнить её тестовыми данными (используя Yii2 ConsoleApplication, стоит учитывать, что данные потребуются и в следующем задании). Запуск php yii fill-product
                </li>
                <li><a href="<?=Url::toRoute('product/test2')?>">Ссылка</a> Подготовить запрос (mongodb), который отберёт все товары, у которых емеется хотябы одна запись в объекте 'eav'</li>
                <li><a href="<?=Url::toRoute('product/test3')?>">Ссылка</a> Подготовить запрос (mongodb), который отберёт все товары, у которых емеется атрибут 2 со значениями 255 и 256</li>
                <li><a href="<?=Url::toRoute('product/test4')?>">Ссылка</a> Подготовить запрос (mongodb), который отберёт все товары, у которых отсутствует атрибут 2</li>
                <li><a href="<?=Url::toRoute('product/test5')?>">Ссылка</a> Реализовать метод в модели для коллекции product, который отберёт товары, у которых разнится один атрибут (то есть товары идентичны, за исключением одного параметра-атрибута из объекта 'eav')</li>
                <ol>
            </div>
        </div>

    </div>
</div>
