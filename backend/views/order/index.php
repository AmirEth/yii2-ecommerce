<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'id' => 'ordersTable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => \yii\bootstrap4\LinkPager::class
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions' => ['style' => 'width: 80px;'],
                'filterInputOptions' => ['class' => 'form-control', 'hidden' => 'hidden'],
                'enableSorting' => false,
            ],
            [
                'attribute' => 'fullname',
                'content' => function ($model) {
                    return $model->firstname . ' ' . $model->lastname;
                },
            ],
            'total_price:currency',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', \common\models\Order::getStatusLabels(), [
                    'class' => 'form-control',
                    'prompt' => 'All'
                ]),
                'enableSorting' => false,
                'format' => ['orderStatus']
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime'],
                'contentOptions' => ['style' => 'white-space: nowrap'],
                'filterInputOptions' => ['class' => 'form-control', 'hidden' => 'hidden'],
            ],

            [
                'class' => 'common\grid\ActionColumn',
                'template' => '{view} {update}',
                'contentOptions' => [
                    'class' => 'td-actions'
                ]
            ],
        ],
    ]); ?>


</div>
