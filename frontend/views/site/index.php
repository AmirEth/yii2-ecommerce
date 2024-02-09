<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = 'My Yii Application';
?>
    <section class="blog-details-hero set-bg" style="background-image: url('<?= \yii\helpers\Html::encode(Yii::$app->request->baseUrl) ?>/img/details-hero.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog__details__hero__text">
                        <h2>The Largest Ecommerce Platform In Ethiopia</h2>
                        <ul>
                            <li>Powerd By ADIB</li>
                            <li>Shop Now</li>
                            <li>Service In 8 Regions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Section Begin -->
    <section class="hero mt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Shop Types</span>
                        </div>
                        <ul>
                        <li><a href="#">All</a></li>
                            <li><a href="#">Supermarket</a></li>
                            <li><a href="#">Vegtables</a></li>
                            <li><a href="#">Pharmacy</a></li>
                            <li><a href="#">Kids Store</a></li>
                            <li><a href="#">Sports Shop</a></li>
                            <li><a href="#">Electronics</a></li>
                            <li><a href="#">Cars Dealer</a></li>
                            

                          
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                  
                    <div class="hero__search">
                    <div class="hero__search__form" style="border: 0px;">
                    <h2>Find Your Shop </h2>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>Customer Service</h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>

                  <!--Featured Shop Section-->
                  <?php foreach ($dataProvider->models as $shop): ?>
                  <div class="col-lg-12 col-md-11 order-md-1 order-1">
                  <div class="blog__details__content">    
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="blog__details__author">
                                    <div class="blog__details__author__pic">
                                        <img src="<?php echo $shop->getImageUrl() ?>" alt="Shop Logo">
                                    </div>
                                    <div class="blog__details__author__text">
                                        <a  href="<?= \yii\helpers\Url::to(['/site/shop-detail', 'id' => $shop->id]) ?>">
                                        <h6><?php echo \yii\helpers\StringHelper::truncateWords($shop->shop_name, 20) ?></h6>
                                        </a>
                                        <span><?php echo $shop->category ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="blog__details__widget">
                                    <ul>
                                        <li><span>Tags: </span><?php echo $shop->tags ?></li>
                                        <li><span>Rating :</span> 3.5 stars</li>
                                    </ul>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="blog__details__text">
                        <p><?= Html::decode($shop->description) ?>
                          </p>
                      
                    </div>
                </div>
                <div class="col-lg-12">
                                <div class="blog__details__widget">
                                    <ul>
                                    <li><span>Opening Days: </span>  <?php echo $shop->getFormattedOpeningDays() ?></li>

                                    </ul>
                                    <div class="blog__details__social">
                                        Social: 
                                        <a href=""><i class="fa fa-facebook"></i></a>
                                        <a href=""><i class="fa fa-twitter"></i></a>
                                        <a href=""><i class="fa fa-google-plus"></i></a>
                                        <a href=""><i class="fa fa-linkedin"></i></a>
                                        <a href=""><i class="fa fa-envelope"></i></a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php endforeach; ?>
                    <!-- Featured Shop Section-->

                   
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
