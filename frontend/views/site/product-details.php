<?php

/** @var \common\models\Product $model */
/** @var \yii\data\ActiveDataProvider $dataProvider */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'My Yii Application';
?>
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="<?= $model->getImageUrl() ?>" alt="">
                        </div>
                        <!-- <div class="product__details__pic__slider owl-carousel">
                            <img data-imgbigurl="img/product/details/product-details-2.jpg"
                                src="img/product/details/thumb-1.jpg" alt="">
                            <img data-imgbigurl="img/product/details/product-details-3.jpg"
                                src="img/product/details/thumb-2.jpg" alt="">
                            <img data-imgbigurl="img/product/details/product-details-5.jpg"
                                src="img/product/details/thumb-3.jpg" alt="">
                            <img data-imgbigurl="img/product/details/product-details-4.jpg"
                                src="img/product/details/thumb-4.jpg" alt="">
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?= Html::decode($model->name) ?></h3>
                        <div class="product__details__rating">Rated
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        <div class="product__details__price"><?= Yii::$app->formatter->asCurrency($model->price) ?></div>
                        <p ><?= Html::decode($model->description) ?></p>
                        <?php $form = ActiveForm::begin(['id' => 'add-to-cart-form']); ?>
                        <?= Html::hiddenInput('id', $model->id) ?>
                        <button type="submit" id="add-to-cart-btn" class="btn primary-btn">ADD TO CART</button>
                        <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>  
                        <?php ActiveForm::end(); ?>
                     
                        <ul>
                            <li><b>Availability</b> <span>In Stock</span></li>
                            <li><b>Shipping</b> <span>No <samp>data</samp></span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->
    <!-- Add to Cart-->
    <?php
        $url = \yii\helpers\Url::to(['/cart/add']);
        $this->registerJs("
        $('#add-to-cart-form').on('beforeSubmit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '{$url}',
                data: formData,
                success: function(response) {
                    console.log(response);
                    // Redirect to the cart page on success
                    window.location.href = '" . \yii\helpers\Url::to(['/cart/index']) . "';
                },
                error: function(error) {
                    console.log(error);
                    // Handle error, e.g., show an error message
                    alert('Failed to add product to cart.');
                }
            });
        });
    ");
    ?>

