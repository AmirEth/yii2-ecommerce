<?php

use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $order common\models\Order */

$this->title = 'Order Details';
?>

<div class="card">
    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="row d-flex align-items-baseline">
                <div class="col-xl-9">
                
                </div>
                <div class="col-xl-3 float-end">
                    <!-- Add your print and export buttons here if needed -->
                </div>
                <hr>
            </div>

            <div class="container">
                <div class="col-md-12">
                    <div class="text-center">
                    <img src="<?= Yii::$app->request->baseUrl ?>/img/ADIB_logo.png" alt="ADIB-Logo" width="70" height="70">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8">
                        <ul class="list-unstyled">
                            <li class="text-muted">To: <span style="color: #5d9fc5;">Amir</span></li>
                            <li class="text-muted">Street, City</li>
                            <li class="text-muted">State, Country</li>
                            <li class="text-muted"><i class="fas fa-phone"></i>251972795880</li>
                        </ul>
                    </div>
                    <div class="col-xl-4">
                        <p class="text-muted">Invoice</p>
                        <ul class="list-unstyled">
                            <li class="text-muted"><i class="fas fa-circle" style="color: #84B0CA;"></i> <span class="fw-bold">Order Date: </span><?= Yii::$app->formatter->asDate($order->created_at) ?></li>
                            <li class="text-muted"><i class="fas fa-circle" style="color: #84B0CA;"></i> <span class="me-1 fw-bold">Status: </span><span class="badge bg-success text-danger fw-bold"> Paid</span></li>
                        </ul>
                    </div>
                </div>

                <!-- ... Additional details and Bootstrap table ... -->

                <div class="row">
                    <div class="col-xl-10">
                        <p class="ms-3">Thank you for your purchase</p>
                    </div>
                    <div class="col-xl-3">
                        <ul class="list-unstyled">
                            <li class="text-muted ms-3"><span class="text-black me-4">SubTotal: </span> ETB <?= Html::encode($order->total_price) ?></li>
                            <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Tax(0%)</span> 0</li>
                        </ul>
                        <p class="text-black float-start"><span class="text-black me-3"> Total Amount: </span> <span style="font-size: 20px;"><b> ETB <?= Html::encode($order->total_price) ?> </b></span></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-2">
                        <button type="button" class="btn btn-primary text-capitalize"  style="background-color: #60bdf3;">Print</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
