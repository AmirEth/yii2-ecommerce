<?php

/** @var array $items */
?>

 <!-- Shoping Cart Section Begin -->
 <section class="shoping-cart spad">
    <?php if (!empty($items)): ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr data-id="<?php echo $item['id'] ?>" data-url="<?php echo \yii\helpers\Url::to(['/cart/change-quantity']) ?>">
                                    <td class="shoping__cart__item">
                                        <img style="width:50px;" src="<?php echo \common\models\Product::formatImageUrl($item['image']) ?>">
                                        <h5><?php echo $item['name'] ?></h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                    <?php echo Yii::$app->formatter->asCurrency($item['price']) ?>
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="number" min="1" class="form-control item-quantity"  value="<?php echo $item['quantity'] ?>"
                                                  value="1">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                    <?php echo Yii::$app->formatter->asCurrency($item['total_price']) ?>
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <?php echo \yii\helpers\Html::a('', ['/cart/delete', 'id' => $item['id']], [    'class' => 'icon_close','data-method' => 'post',]) ?>                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="<?= Yii::$app->homeUrl ?>" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="<?php echo \yii\helpers\Url::to(['/cart/checkout']) ?>" class="ml-2 btn primary-btn"><span class="icon_loading"></span>
                           CheckOut</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY & CheckOut</button>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <section class="breadcrumb-section set-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2 style="color:red">Your Cart is Empty</h2>
                        <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn mt-2">CONTINUE SHOPPING</a>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
 </section>
    <!-- Shoping Cart Section End -->
