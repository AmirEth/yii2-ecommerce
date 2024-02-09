<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = 'My Yii Application';
?> <hr>
    <div class="row ml-4 mt-2">
        <div class="col-lg-6">
            <div class="blog__details__author">
                <div class="blog__details__author__pic">
                    <img src="<?php echo $model->getImageUrl() ?>" alt="Shop Logo">
                </div>
                <div class="blog__details__author__text">
                    <a  href="<?= \yii\helpers\Url::to(['/site/model-detail', 'id' => $model->id]) ?>">
                    <h6><?php echo \yii\helpers\StringHelper::truncateWords($model->shop_name, 20) ?></h6>
                    </a>
                    <span><?php echo $model->category ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
        <div class="section-title product__discount__title">
                            <h2>Products</h2>
                        </div>
        </div>
    </div>
    <section class="blog spad" style="margin-top: -100px" >
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search for Products...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                       
                        <div class="blog__sidebar__item">
                            <h4>Categories</h4>
                            <ul>
                               <li><a href="#">All</a></li>
                                <?php foreach ($categories as $category): ?>
                                    <li><a href="#"><?php echo $category->category_name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Related Stores</h4>
                            <div class="blog__sidebar__recent">
                                <a href="#" class="blog__sidebar__recent__item">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img src="img/blog/sidebar/sr-3.jpg" alt="">
                                    </div>
                                    <div class="blog__sidebar__recent__item__text">
                                        <h6>4 Principles Help You Lose <br />Weight With Vegetables</h6>
                                        <span>MAR 05, 2019</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="row">
                        <?php foreach ($productDataProvider->models as $product): ?>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="<?php echo $product->getImageUrl() ?>" alt="">
                                </div>
                                <div class="blog__item__text">
                                   
                                    <h5><a href="#"><?php echo \yii\helpers\StringHelper::truncateWords($product->name, 20) ?></a></h5>
                                    <p>
                                        
                                    </p>
                                        <ul>
                                        <li>  <?php echo Yii::$app->formatter->asCurrency($product->price) ?></li>
                                        
                                    </ul>
                                    <a href="<?= \yii\helpers\Url::to(['site/product-details', 'id' => $model->id]) ?>" class="blog__btn">Details <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="col-lg-12">
                            <div class="product__pagination blog__pagination">
                                <a href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->