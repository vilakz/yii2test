<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            '_id',
            'category_id',
            'item_number',
            'brand_id',
            'name',
            // 'alias',
            // 'price_wholesale',
            // 'not_produced',
            // 'site_status',
            [ 
                'attribute' => 'eav' , 
                'format' => 'raw' , 
                'value' => function ($data) { return $data->EAVtoString; },
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
