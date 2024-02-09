<?php

use yii\helpers\Html;
/** @var \common\models\Product $model */
?>
    <div class="card h-100">
    <a href="<?= \yii\helpers\Url::to(['site/product-details', 'id' => $model->id]) ?>"class="img-wrapper">
   
            <img class="card-img-top" src="<?php echo $model->getImageUrl() ?>" alt="product-img">
        </a>
        <div class="card-body">
            <h5 class="card-title">
                <a href="#" class="text-dark"><?php echo \yii\helpers\StringHelper::truncateWords($model->name, 20) ?></a>
            </h5>
            <div class="card-text">
            <?php echo Yii::$app->formatter->asCurrency($model->price) ?>
            </div>
        </div>
        <div class="card-footer text-right">
         <a href="<?php echo \yii\helpers\Url::to(['/cart/add']) ?>" class="btn btn-warning btn-add-to-cart">
     
         <i class="fas fa-cart-plus fa-inverse"></i>

            </a> 
            <a href="<?= \yii\helpers\Url::to(['site/product-details', 'id' => $model->id]) ?>" class="btn btn-info">
            <i class="fas fa-eye fa-inverse"></i> Details
</a>



        </div>
    </div>