<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$cartItemCount = $this->params['cartItemCount'];

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
  <!--################################# Nav Bar ###############################################-->
    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
      <div class="humberger__menu__logo">
        <a href="#"><img src="img/logo.png" alt="" /></a>
      </div>
      <div class="humberger__menu__cart"></div>
      <div class="humberger__menu__widget">
        <div class="header__top__right__language">
          <img src="img/language.png" alt="" />
          <div>English</div>
          <span class="arrow_carrot-down"></span>
          <ul>
            <li><a href="#">Amharic</a></li>
            <li><a href="#">English</a></li>
          </ul>
        </div>
        <div class="header__top__right__auth"></div>
      </div>
      <nav class="humberger__menu__nav mobile-menu">
        <ul>
          <li class="active"><a href="<?= Yii::$app->homeUrl ?>">Home</a></li>
          <li><a href="./shop-grid.html">Shops</a></li>
          <li>
            <a href="#">About Us</a>
            <ul class="header__menu__dropdown">
              <li><a href="./shop-details.html">About</a></li>
              <li><a href="./shoping-cart.html">Blogs</a></li>
            </ul>
          </li>
          <li><a href="./contact.html">Contact</a></li>
        </ul>
      </nav>
      <div id="mobile-menu-wrap"></div>
      <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
      </div>
      <div class="humberger__menu__contact">
        <ul>
          <li><i class="fa fa-envelope"></i>adib@email.com</li>
          <li><i class="fa fa-phone"></i>+111-0000-000</li>
        </ul>
      </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
      <div class="header__top">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="header__top__left">
                <ul>
                  <li><i class="fa fa-envelope"></i>adib@email.com</li>
                  <li><i class="fa fa-phone"></i>+111-0000-000</li>
                </ul>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="header__top__right">
                <div class="header__top__right__social">
                  <a href="#"><i class="fa fa-facebook"></i></a>
                  <a href="#"><i class="fa fa-twitter"></i></a>
                  <a href="#"><i class="fa fa-linkedin"></i></a>
                  <a href="#"><i class="fa fa-pinterest-p"></i></a>
                </div>
                <div class="header__top__right__language">
                  <img src="img/language.png" alt="" />
                  <div>English</div>
                  <span class="arrow_carrot-down"></span>
                  <ul>
                    <li><a href="">Amharic</a></li>
                  </ul>
                </div>
                <div class="header__top__right__auth">
                  <a href="<?= Yii::$app->urlManager->createUrl(['/site/logout']) ?>" data-method="post"><i class="fa fa-door"> Logout</i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <div class="header__logo">
              <a href="<?= Yii::$app->homeUrl ?>">
              
              <span style="font-size: 30px; font-family: 'Times New Roman', Times, serif; color:#00affe;">E-C<img src="<?= Yii::$app->request->baseUrl ?>/img/ADIB_logo.png" alt="ADIB-Logo" width="50" height="50">MMERCE</span> 
             </a> 
            </div>
          </div>
          <div class="col-lg-6">
            <nav class="header__menu">
              <ul>
                <li class="active"><a href="<?= Yii::$app->homeUrl ?>">Home</a></li>
                <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/products']) ?>">Products</a></li>
                <li>
                  <a href="#">About Us</a>
                  <ul class="header__menu__dropdown">
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/products']) ?>">About Us</a></li>
                    <li><a href="./shoping-cart.html">Blog</a></li>
                  </ul>
                </li>
                <li><a href="./contact.html">Contact</a></li>
              </ul>
            </nav>
          </div>
          <div class="col-lg-3">
            <div class="header__cart">
              <ul>
                <li>
                  <a href="<?= Yii::$app->urlManager->createUrl(['/cart/index']) ?>"
                    ><i class="fa fa-shopping-bag"></i> <span><?= $cartItemCount ?></span></a
                  >
                </li>
                <?php if (Yii::$app->user->isGuest): ?>
                <li>
                  <i class="fa fa-user">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Login</a>
                        |
                    <a href="<?= Yii::$app->urlManager->createUrl(['/site/signup']) ?>">Signup</a>
                  </i> 
                </li>
                <?php else: ?>
                    <li>
                  <a href="<?= Yii::$app->urlManager->createUrl(['/profile/index']) ?>">
                  <i class="fa fa-user"> <?= Yii::$app->user->identity->getDisplayName() ?></i></a>
                </li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="humberger__open">
          <i class="fa fa-bars"></i>
        </div>
      </div>
    </header>
    <!-- Header Section End -->
    <!--############################## Nav Bar End #############################################-->

 <div class="wrap">

    <div class=" mt-2">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
 </div>

 <footer class="footer spad mt-4">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="footer__about">
              <div class="footer__about__logo">
              <a href="<?= Yii::$app->homeUrl ?>">
              <img src="<?= Yii::$app->request->baseUrl ?>/img/ADIB_logo.png" alt="ADIB-Logo" width="60" height="60"> 
              ECOMMERCE
             </a> 
              </div>
              <ul>
                <li>Phone: +65 11.188.888</li>
                <li>Email:adib@email.com</li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
            <div class="footer__widget">
              <h6>Useful Links</h6>
              <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">About Our Shop</a></li>
                <li><a href="#">Secure Shopping</a></li>
                <li><a href="#">Delivery infomation</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Our Sitemap</a></li>
              </ul>
              <ul>
                <li><a href="#">Who We Are</a></li>
                <li><a href="#">Our Services</a></li>
                <li><a href="#">Projects</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Innovation</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4 col-md-12">
            <div class="footer__widget">
              <h6>Join Our Newsletter Now</h6>
              <p>
                Get E-mail updates about our latest shop and special offers.
              </p>
              <form action="#">
                <input type="text" placeholder="Enter your mail" />
                <button type="submit" class="site-btn">Subscribe</button>
              </form>
              <div class="footer__widget__social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="footer__copyright">
              <div class="footer__copyright__text">
                <p>
                  Copyright &copy;
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  All rights reserved | ADIB Team
                 
                </p>
              </div>
              <div class="footer__copyright__payment">
                <img src="img/payment-item.png" alt="" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
