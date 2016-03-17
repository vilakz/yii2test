<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'item_number') ?>

    <?= $form->field($model, 'brand_id') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'alias') ?>

    <?php // echo $form->field($model, 'price_wholesale') ?>

    <?php // echo $form->field($model, 'not_produced') ?>

    <?php // echo $form->field($model, 'site_status') ?>

    <?php // echo $form->field($model, 'eav') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
