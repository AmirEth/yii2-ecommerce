<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-between">
        <div class="col-md-4">
            <p>
                <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>

        <div class="col-md-4">
            <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get', 'class' => 'form-inline']); ?>
                <div class="input-group">
                    <?= Html::textInput('ProductSearch[name]', $searchModel->name, ['class' => 'form-control', 'placeholder' => 'Search for products']); ?>
                    <div class="input-group-append">
                        <?= Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'btn btn-warning']); ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="table-responsive">
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
       //    'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'contentOptions' => [
                        'style' => 'width: 60px',
                      
                    ],
                    'enableSorting' => false,
                ],
                [
                    'label' => 'Image',
                    'attribute' => 'image',
                    'content' => function ($model) {
                        /** @var \common\models\Product $model */
                        return Html::img($model->getImageUrl(), ['style' => 'width: 50px']);
                    },
                    'enableSorting' => false,
                    //'filterInputOptions' => ['class' => 'form-control', 'hidden' => 'hidden'],
                ],
                [
                    'attribute' => 'name',
                    'content' => function ($model) {
                        return \yii\helpers\StringHelper::truncateWords($model->name, 7);
                    }
                ],
                'price:currency',
                [
                    'attribute' => 'status',
                    'enableSorting' => false,
                    'content' => function ($model) {
                        /** @var \common\models\Product $model */
                        return Html::tag('span', $model->status ? 'Active' : 'Draft', [
                            'class' => $model->status ? 'badge badge-success' : 'badge badge-danger'
                        ]);
                        
                    }
                ],
                [
                    'attribute' => 'categoryName',
                    'label' => 'Category',
                    'value' => 'category.category_name',            
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['datetime'],
                    'contentOptions' => ['style' => 'white-space: nowrap']
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['datetime'],
                    'contentOptions' => ['style' => 'white-space: nowrap']
                ],
                [
                    'class' => 'common\grid\ActionColumn',
                    'contentOptions' => [
                        'class' => 'td-actions'
                    ]
                ],
            ],
        ]); ?>
    </div>

</div>
