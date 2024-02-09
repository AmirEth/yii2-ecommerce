<?php

namespace frontend\controllers;

use common\models\Order;
use Yii;
use yii\web\Response;
use yii\rest\Controller;

class ApiController extends Controller
{
    public function actionAdibPayment()
    {
        $requestData = Yii::$app->getRequest()->getBodyParams();
        $transactionId = $requestData['transaction_id'] ?? null;
        $status = $requestData['status'] ?? null;
    
        if (!$transactionId) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'status' => 'failed',
                'status_code' => '01',
                'response' => 'Transaction ID is required.'];
        }
    
        $order = Order::findOne(['transaction_id' => $transactionId]);
    
        if (!$order) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'status' => 'failed',
                'status_code' => '01',
                'response' => 'Order not found for reference number: ' . $transactionId];
        }
    
        if ($status === 'paid') {
            $order->status = Order::STATUS_PAID;
            $order->save();
    
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'status' => 'successful',
                'status_code' => '00',
                'response' => 'Order completed successfully',
            ];
        }
    
        if ($status === 'new') {
            if ($order->status === Order::STATUS_PAID) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'status' => 'failed',
                    'status_code' => '01',
                    'response' => 'This order is already paid for!',
                ];
            }
    
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'status' => 'successful',
                'status_code' => '00',
                'order_id' => $order->id,
                'total_price' => $order->total_price,
                'cif' => '050985',
                // Other order information
            ];
        }
    
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => 'failed',
            'status_code' => '01',
            'response' => 'Invalid status!',
        ];
    }
    
}
