<?php


namespace frontend\controllers;

use yii\helpers\Url;
use common\models\CartItem;
use common\models\Order;
use common\models\OrderAddress;
use common\models\Product;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class CartController
 *
 * @package frontend\controllers
 */
class CartController extends \frontend\base\Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add', 'create-order', 'submit-payment', 'change-quantity'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST', 'DELETE'],
                    'create-order' => ['POST'],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $cartItems = CartItem::getItemsForUser(currUserId());

        return $this->render('index', [
            'items' => $cartItems
        ]);
    }

    public function actionAdd()
    {
        $id = \Yii::$app->request->post('id');
        $product = Product::find()->id($id)->published()->one();
        if (!$product) {
            throw new NotFoundHttpException("Product does not exist");
        }

        if (\Yii::$app->user->isGuest) {

            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY, []);
            $found = false;
            foreach ($cartItems as &$item) {
                if ($item['id'] == $id) {
                    $item['quantity']++;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $cartItem = [
                    'id' => $id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'quantity' => 1,
                    'total_price' => $product->price
                ];
                $cartItems[] = $cartItem;
            }

            \Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
        } else {
            $userId = \Yii::$app->user->id;
            $cartItem = CartItem::find()->userId($userId)->productId($id)->one();
            if ($cartItem) {
                $cartItem->quantity++;
            } else {
                $cartItem = new CartItem();
                $cartItem->product_id = $id;
                $cartItem->created_by = $userId;
                $cartItem->quantity = 1;
            }
            if ($cartItem->save()) {
                return [
                    'success' => true
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => $cartItem->errors
                ];
            }
        }
    }

    public function actionDelete($id)
    {
        if (isGuest()) {
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY, []);
            foreach ($cartItems as $i => $cartItem) {
                if ($cartItem['id'] == $id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            \Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
        } else {
            CartItem::deleteAll(['product_id' => $id, 'created_by' => currUserId()]);
        }

        return $this->redirect(['index']);
    }

    public function actionChangeQuantity()
    {
        $id = \Yii::$app->request->post('id');
        $product = Product::find()->id($id)->published()->one();
        if (!$product) {
            throw new NotFoundHttpException("Product does not exist");
        }
        $quantity = \Yii::$app->request->post('quantity');
        if (isGuest()) {
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY, []);
            foreach ($cartItems as &$cartItem) {
                if ($cartItem['id'] === $id) {
                    $cartItem['quantity'] = $quantity;
                    break;
                }
            }
            \Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
        } else {
            $cartItem = CartItem::find()->userId(currUserId())->productId($id)->one();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        }

        return [
            'quantity' => CartItem::getTotalQuantityForUser(currUserId()),
            'price' => Yii::$app->formatter->asCurrency(CartItem::getTotalPriceForItemForUser($id, currUserId()))
        ];
    }

    public function actionCheckout()
    {
        $cartItems = CartItem::getItemsForUser(currUserId());
        $productQuantity = CartItem::getTotalQuantityForUser(currUserId());
        $totalPrice = CartItem::getTotalPriceForUser(currUserId());

        if (empty($cartItems)) {
            return $this->redirect([Yii::$app->homeUrl]);
        }
        $order = new Order();

        $order->total_price = $totalPrice;
        $order->status = Order::STATUS_DRAFT;
        $order->created_at = time();
        $order->created_by = currUserId();
        $transaction = Yii::$app->db->beginTransaction();
        if ($order->load(Yii::$app->request->post())
            && $order->save()
            && $order->saveAddress(Yii::$app->request->post())
            && $order->saveOrderItems()) {
            $transaction->commit();

            CartItem::clearCartItems(currUserId());

            return $this->render('pay-now', [
                'order' => $order,
            ]);
        }

        $orderAddress = new OrderAddress();
        if (!isGuest()) {
            /** @var \common\models\User $user */
            $user = Yii::$app->user->identity;
            $userAddress = $user->getAddress();

            $order->firstname = $user->firstname;
            $order->lastname = $user->lastname;
            $order->email = $user->email;
            $order->status = Order::STATUS_DRAFT;

            $orderAddress->address = $userAddress->address;
            $orderAddress->city = $userAddress->city;
            $orderAddress->state = $userAddress->state;
            $orderAddress->country = $userAddress->country;
            $orderAddress->zipcode = $userAddress->zipcode;
        }

        return $this->render('checkout', [
            'order' => $order,
            'orderAddress' => $orderAddress,
            'cartItems' => $cartItems,
            'productQuantity' => $productQuantity,
            'totalPrice' => $totalPrice
        ]);
    }

    public function actionGenerateReferenceNumber($orderId)
{
    $order = Order::findOne($orderId);
   
    if ($order) {
        if (!$order->transaction_id) {
            
            $referenceNumber = strtoupper(substr(uniqid(), 0, 8));
            $order->transaction_id = $referenceNumber;
            $order->save();

            // Send Mail
            $subject = 'Your Order Reference Number';
            $body = "Dear Customer";
            $body .= "Your order reference number is: {$referenceNumber}\n\n";
            $body .= "Thank you for your purchase!\n";
            $body .= "Sincerely,\nThe E-commerce Team";

            Yii::$app->mailer->compose()
                ->setTo($order->email)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();

            // Send SMS
                $smsApiUrl = 'http://192.168.6.26:9501/api?action=sendmessage';
                $smsParams = [
                    'username' => 'esbapp',
                    'password' => 'esbapp',
                    'recipient' => '251972795880',//$order->phone_number when I add inside 
                    'messagetype' => 'SMS:TEXT',
                    'messagedata' => "Dear customer, your reference number is: {$referenceNumber}, Please complete your payment with ADIB E-Banking. \n" . date('Y-m-d H:i:s'),
                ];

                $smsApiUrl .= '&' . http_build_query($smsParams);

                $httpClient = new \yii\httpclient\Client();
                $response = $httpClient->createRequest()
                    ->setMethod('GET')
                    ->setUrl($smsApiUrl)
                    ->send();

                $smsResponse = $response->content; //Incase I store it in log file!                
        }    
        return $this->render('order-details', ['order' => $order]);
    } else {
        throw new NotFoundHttpException("Order not found for ID: $orderId");
    }
}

    public function actionSendOtp()
    {
        $phoneNum = Yii::$app->request->post('phone_number');
        $orderId = Yii::$app->request->post('order_id');
        $resend = Yii::$app->request->post('resend'); 

        $order = Order::findOne($orderId);

        if (!$resend && $order && $order->otp_generated_at && $order->otp_expiry > time()) {
            return $this->asJson(['success' => true, 'message' => 'OTP already generated']);
        }
        
            $otp = strval(rand(100000, 999999));
            $order->otp = $otp;
            $order->otp_generated_at = time();
            $order->otp_expiry = time() + (2 * 60);
        
            if ($order->save()){

                // $smsApiUrl = 'http://192.168.6.26:9501/api?action=sendmessage';
                //     $smsParams = [
                //         'username' => 'esbapp',
                //         'password' => 'esbapp',
                //         'recipient' =>  $phoneNum,
                //         'messagetype' => 'SMS:TEXT',
                //         'messagedata' => "Dear customer, Please enter {$otp} OTP to continue  \n" . date('Y-m-d H:i:s'),
                //     ];

                //     $smsApiUrl .= '&' . http_build_query($smsParams);

                //     $httpClient = new \yii\httpclient\Client();
                //     $response = $httpClient->createRequest()
                //         ->setMethod('GET')
                //         ->setUrl($smsApiUrl)
                //         ->send();

                //     $smsResponse = $response->content; //Incase I store it in log file!
            return $this->asJson(['success' => true, 'message' => 'OTP sent successfully']);
            }
            else {
                $errors = $order->getErrors();
                foreach ($errors as $attribute => $errorMessages) {
                    foreach ($errorMessages as $errorMessage) {
                        echo "Error for attribute $attribute: $errorMessage";
                    }}}    
        
    }

    public function actionVerifyPhoneNumberFailed()
    {
        $orderId = Yii::$app->request->get('orderId');
        $order = Order::findOne($orderId);

        if ($order) {
            $order->status = Order::STATUS_FAILED;
            $order->save();
            Yii::$app->session->setFlash('error', 'Order verification failed. Please contact support.');
            return $this->redirect(['/site/index']);

        } else {

            Yii::$app->session->setFlash('error', 'Invalid order ID.');
            return $this->redirect(['/site/index']);
        }
  
    }
 public function actionVerifyPhoneNumber()
{
    $orderId = Yii::$app->request->post('order_id');
    $enteredOtp = Yii::$app->request->post('otp');
    
    $order = Order::findOne($orderId);
    
    if ($order && $enteredOtp) {
        $currentTimestamp = time();
    
        if ($currentTimestamp <= $order->otp_expiry) {

            if ($enteredOtp == $order->otp) {
                $phone_number = $order->phone_number;
                $apiUrl = "http://localhost:8080/employees/$phone_number";

                $httpClient = new \yii\httpclient\Client();
                $response = $httpClient->createRequest()
                    ->setMethod('GET')
                    ->setUrl($apiUrl)
                    ->send();

                if ($response->isOk) {
                     $accountNumber = trim($response->content);
                    
                    // Return JSON response instead of rendering the view
                    return $this->asJson([
                        'success' => true,
                        'order' => $order,
                        'accountNumber' => $accountNumber,
                    ]);
                } else {
                    $order->status = Order::STATUS_FAILED;
                    $order->save();

                    Yii::$app->session->setFlash('error', 'You don\'t have an ADIB account with ' . $phone_number . ' phone number.');

                    return $this->redirect(['site/index']);
                }
            } else {
                return $this->asJson(['success' => false, 'message' => 'Incorrect OTP']);
            }
        } else {
            $order->status = Order::STATUS_FAILED;
            $order->save();
            Yii::$app->session->setFlash('error', 'Order verification failed. Please contact support.');

            return $this->redirect(['site/index']);
        }
    } else {
        return $this->asJson(['success' => false, 'message' => 'Invalid request']);
    }
}
public function actionCompletePayment($orderId)
{
    $order = Order::findOne($orderId);

    $phoneNumber = $order->phone_number;
    $total = $order->total_price;
    $currentTime = date('mdHis');

    // Define the XML data template
    $xmlDataTemplate = '<message>' .
        '   <authHeader sourceid=\'CBSTellerUAT\' password=\'cbs@teller#2023\'/>' .
        '   <isomsg direction=\'request\'>' .
        '       <field id=\'0\' value=\'0200\'/>' .
        '       <field id=\'2\' value=\'{phone_number}\'/>'.
        '       <field id=\'3\' value=\'400000\'/>' .
        '       <field id=\'4\' value=\'{total}\'/>'.
        '       <field id=\'7\' value=\'0317170014\' />' .
        '       <field id=\'11\' value=\'144657\' />' .
        '       <field id=\'32\' value=\'ECOM\' />' .
        '       <field id=\'37\' value=\'W234567892\'/>' .
        '       <field id=\'49\' value=\'ETB\'/>' .
        '       <field id=\'65\' value=\'{phone_number}\'/>'.
        '       <field id=\'100\' value=\'FT\'/>' .
        '       <field id=\'102\' value=\'0010001247201001\'/>' .
        '       <field id=\'103\' value=\'0010001317201001\'/>' .
        '   </isomsg>' .
        '</message>';

    // Replace placeholders in the template with actual values
    $xmlData = str_replace('{phone_number}', $phoneNumber, $xmlDataTemplate);
    $xmlData = str_replace('{total}', $total, $xmlData);
    $xmlData = str_replace('{current_time}', $currentTime, $xmlData);

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, 'http://192.168.90.51:7011/ESBWSConnector');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

    // Execute cURL session and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        // Handle the error
        echo 'Curl error: ' . curl_error($ch);
    }
    $order->status = Order::STATUS_COMPLETED;

    curl_close($ch);
    print($response);
    return $this->render('pay-withphone', [
        'order' => $order,
        'response' => $response,
    ]);
}
}