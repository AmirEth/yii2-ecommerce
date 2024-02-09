<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \common\models\Order $order */
$orderAddress = $order->orderAddress
?>
    <section class="checkout spad">
      <div class="container">
        <div class="checkout__form">
          <h4>Order #<?php echo $order->id ?> Summary</h4>
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="checkout__input">
                <p><b>Full Name: </b><?php echo $order->firstname ?> <?php echo $order->lastname ?></p>
              </div>
              <div class="checkout__input">
                <p><b> Email: </b><?php echo $order->email ?></p>
              </div>  
              <hr />
              <div class="checkout__input">
                <p><b>Address: </b><?php echo $orderAddress->address ?></p>
              </div>
              <div class="checkout__input">
                <p><b>Town/City: </b><?php echo $orderAddress->city ?></p>
              </div>
              <div class="checkout__input">
                <p><b>State: </b><?php echo $orderAddress->state ?></p>
              </div>
              <div class="checkout__input">
                <p><b>Postcode/ZIP: </b><?php echo $orderAddress->zipcode ?></p>
              </div>
              <div class="checkout__input">
                <p><b>Country: </b><?php echo $orderAddress->country ?></p>
              </div>
              <div class="checkout__input">
                <input
                  type="text"
                  placeholder="If you forgot to add Discount Coupan Now is your chance!"
                />
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="checkout__order">
                <h4>Order From ShopName</h4>
                <div class="checkout__order__products">
                  Products <span>Qty</span> <span>Total</span>
                </div>
                <ul>
                <?php foreach ($order->orderItems as $item): ?>
                  <li><img src="<?php echo $item->product->getImageUrl() ?>"style="width: 50px;">
                  <?php echo $item->product_name ?> <span><?php echo $item->quantity ?></span> <span><?php echo Yii::$app->formatter->asCurrency($item->quantity * $item->unit_price) ?></span></li>
                </ul>
                <?php endforeach; ?>
                <div class="checkout__order__subtotal">
                  Total Items <span><?php echo $order->getItemsQuantity() ?></span>
                </div>
                <div class="checkout__order__total">
                  Total <span><?php echo Yii::$app->formatter->asCurrency($order->total_price) ?></span>
                </div>
                <div class="checkout__input__checkbox"></div>
                <?php 
                echo Html::beginForm(['cart/generate-reference-number', 'orderId' => $order->id], 'post');;?>
                <button type="submit" class="btn site-btn">
                  Pay With E-Banking
                </button>
                <?php echo Html::endForm();?>
                <hr>
                <p>Pay Directly With Your Phone <?php echo $order->phone_number?> </p>
                <button type="submit" id="initiateOtpGeneration" class="btn site-btn">
                  Pay With Phone Number
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
 <button
      style ="display: none;"
      type="button"
      class="btn btn-warning"
      data-toggle="modal"
      data-target="#verifyPhone"
      id="modal"
    >
    verify Otp
 </button>
 <button
      style ="display: none;"
      type="button"
      class="btn btn-warning"
      data-toggle="modal"
      data-target="#completePayment"
      id="pay"
    >
    complete payment
 </button>
   <!-- Verify Phone Modal-->
    <div class="modal fade" id="verifyPhone" tabindex="-1" role="dialog" aria-labelledby="verifyPhoneTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button
              type="button"
              class="close"
              id="closeVerify"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
            <div
              class="d-flex justify-content-center align-items-center container"
            >
              <div class="card py-5 px-3 border-0">
                <h5 class="m-0">Mobile phone verification</h5>
                <span class="text-muted"
                  >Enter OTP Sent to: +
                  <b class="text-danger"><?php echo $order->phone_number ?></b></span
                >
                <div class="alert alert-danger" id="error-message" role="alert" style="display: none;">
                </div>
                <div class="d-flex flex-row mt-4">
                  <input
                    type="number"
                    class="form-control ml-2 border-bottom"
                    maxlength="6"
                    min="0"
                    id="otp_field"
                    autofocus
                  />
                  <button class="btn btn-primary  ml-2" id="verify_otp">Verify</button>
                </div>
                <div class="text-center mt-3">
                  <span class="d-block text-danger text-muted"
                    >Time Left:
                    <b><span id="timer"></span></b>
                  </span>
                  <span class="d-block text-muted"
                    >Didn't receive the code?
                    <a class="font-weight-bold text-danger cursor" id="resendOtp" href="">
                      Resend</a
                    >
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Complete Payment Modal-->
    <div class="modal fade" id="completePayment" tabindex="-1" role="dialog" aria-labelledby="verifyPhoneTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <button
              type="button"
              class="close"
              id="closePayment"
              data-dismiss="modal"
              aria-label="Close"
            >
            <span aria-hidden="true" class="btn btn-sm btn-danger">Cancel</span>
          </button>
             
             
            <div
              class="d-flex justify-content-center align-items-center container"
            >
              <div class="card py-5 px-3 border-0">
                <h5 class="m-0">Complete Your Payment</h5>
                <span class="d-block text-danger mt-2 text-muted"
                  >Accout No: <b><span id="account"></span></b> <br>
                  Total Amount:
                    <b><span id="total"></span></b>
                </span>
                <div class="d-flex flex-row mt-4"></div>
                <div class="text-center mt-3">
                  <span class="d-block text-danger text-muted"
                    >
                    <?php 
                    echo Html::beginForm(['cart/complete-payment', 'orderId' => $order->id], 'post');
                    echo Html::submitButton('Complete Payment', ['class' => 'btn btn-warning']);
                    echo Html::endForm();?>
                    
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>  
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"
    ></script>
  <script>
    $(document).ready(function() {
       var timer;
       var timerRunning = false;

        function stopTimer() {
            clearInterval(timer);
            timerRunning = false;           
        }

        // New OTP Generation
        $("#initiateOtpGeneration").click(function() {
            var phoneNumber = <?php echo $order->phone_number ?>;
            var order_id = '<?php echo $order->id ?>';       
        $.ajax({
            url: "<?php echo \yii\helpers\Url::to(['/cart/send-otp']); ?>",
            type: "POST",
            data: { phone_number: phoneNumber, order_id: order_id },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $("#modal").click();
                    if (!timerRunning) { 
                        var duration = 120;
                        var timerElement = $("#timer");

                        timer = setInterval(function() {
                            var minutes = Math.floor(duration / 60);
                            var seconds = duration % 60;
                            timerElement.text(minutes + ":" + (seconds < 10 ? "0" : "") + seconds);
                            if (--duration < 0) {
                                clearInterval(timer);
                                window.location.href = "<?php echo \yii\helpers\Url::to(['/cart/verify-phone-number-failed', 'orderId' => $order->id]); ?>";
                            }
                        }, 1000);
                        timerRunning = true; 
                    }
                } else {
                    $("#error-message").text(response.message).show();
                    console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
              
            }
        });
    });
 

    $("#resendOtp").click(function(e) {
            e.preventDefault();
            var order_id = '<?php echo $order->id ?>';
            var resend = true; 
            $.ajax({
                url: "<?php echo \yii\helpers\Url::to(['/cart/send-otp']); ?>",
                type: "POST",
                data: { order_id: order_id, resend: resend },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        console.log("OTP resent successfully");
                    } else {
                        console.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

    //Verify OTP
        $("#verify_otp").click(function() {
            var enteredOtp = $("#otp_field").val();
            var order_id = '<?php echo $order->id ?>';
            $.ajax({
                url: "<?php echo \yii\helpers\Url::to(['/cart/verify-phone-number']); ?>",
                type: "POST",
                data: { otp: enteredOtp, order_id: order_id },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        console.log("OTP verified successfully");
                        stopTimer(); 
                        $("#total").text(response.order.total_price); 
                        $("#account").text(response.accountNumber); 
                        $("#closeVerify").click();
                        $("#pay").click();
                    } else {
                        console.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
        $("#closePayment").click(function() {
            window.location.href = "<?php echo \yii\helpers\Url::to(['/']); ?>";
        });
    });
  </script>
       
    </div>
</div>