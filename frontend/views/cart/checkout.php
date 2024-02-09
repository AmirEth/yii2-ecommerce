<?php
/** @var \common\models\Order $order */
/** @var \common\models\OrderAddress $orderAddress */
/** @var array $cartItems */
/** @var int $productQuantity */

/** @var float $totalPrice */

use yii\bootstrap4\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'checkout-form',
]); ?>
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> You Can Create an account with the Billing that Info You Enter Below!
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Billing Details</h4>
               
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <?= $form->field($order, 'firstname')->textInput(['autofocus' => true]) ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                    <?= $form->field($order, 'lastname')->textInput(['autofocus' => true]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                    <?= $form->field($order, 'phone_number')->textInput(['autofocus' => true]) ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                    <?= $form->field($order, 'email')->textInput(['autofocus' => true]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                            <?= $form->field($orderAddress, 'address') ?>
                            </div>
                            <div class="checkout__input">
                            <?= $form->field($orderAddress, 'city') ?>
                            </div>
                            <div class="checkout__input">
                            <?= $form->field($orderAddress, 'state') ?>
                            </div>
                            <div class="checkout__input">
                            <?= $form->field($orderAddress, 'country') ?>
                            </div>
                            <div class="checkout__input">
                            <?= $form->field($orderAddress, 'zipcode') ?>
                            </div>
                         <hr>
                            <div class="checkout__input__checkbox">
                                <label for="acc">
                                    Create an account?
                                    <input type="checkbox" id="acc">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <p>Create an account by entering the information below. If you are a returning customer
                                please login at the top of the page</p>
                            <div class="checkout__input">
                                <p>Account Password<span>*</span></p>
                                <input type="password">
                            </div>
                            <div class="checkout__input">
                                <p>Confirm Password<span>*</span></p>
                                <input type="password">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul>
                                <?php foreach ($cartItems as $item): ?>
                                    <li><?php echo $item['quantity'] ?> <?php echo $item['name'] ?><span><?php echo Yii::$app->formatter->asCurrency($item['total_price']) ?></span></li>
                                <?php endforeach; ?>
                                </ul>
                                <div class="checkout__order__subtotal">Total Items <span><?php echo $productQuantity ?> items</span></div>
                                <div class="checkout__order__total">Total <span><?php echo Yii::$app->formatter->asCurrency($totalPrice) ?></span></div>

                                <p>I have Checked and agree thet I have provided a valid Phone number related to ADIB Account to 
                                    complete payment with Phone number  </p>
                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                       Valid Phone Number
                                        <input type="checkbox" id="payment">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

<?php ActiveForm::end(); ?>
