<p align="center">
    <a href="https://github.com/AmirEth" target="_blank">
   <!--     <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">-->
    </a>
    <h1 align="center">E-commerce application With Yii2 </h1>
    <br>
</p>

Yii2 E-commerce system by AmirEth

## Features

- Bootstrap 4
- Custom [Admin template](https://startbootstrap.com/theme/sb-admin-2) in backend
- Product Management
- Implement cart page
- Checkout for guests
- Checkout for authorized users
- Sending email when order is made
- Payments with PayPal - [PayPal buttons](https://developer.paypal.com/demo/checkout/#/pattern/client)
- Payment with Yenepay
- Order validation
- Display order in backend
- Dashboard with basic statistics
  - Total earnings
  - Total products sold
  - Total number of orders made
  - Total users
  - Earnings by day
  - Revenue by country

## Installation

1. Clone the repository
2. Go to the project root directory and run `composer install`
3. Run `php init` from the project root directory and choose your desired environment
4. Create the database
5. Open `common/config/main-local.php`
   - Configure database credentials by changing the following lines
     ```php
     'dsn' => 'mysql:host=localhost;dbname=your_website_db',
     'username' => 'root',
     'password' => '',
     'charset' => 'utf8mb4',
     ```
   - If you want to use real SMTP credentials to send emails, configure the mail provider by replacing `mailer` component with the following code
     ```php
     'mailer' => [
         'class' => 'yii\swiftmailer\Mailer',
         'transport' => [
             'class' => 'Swift_SmtpTransport',
             'host' => 'SMTP_HOST', // smtp.gmail.com
             'username' => 'SMTP_USERNAME', //EMAIL_HOST_USER = 'engebeyayshoping@gmail.com'
             'password' => 'SMTP_PASSWORD', //EMAIL_HOST_PASSWORD = 'ppzy deba fwqh rywf'
             'port' => 'SMTP_PORT', // 587
             'encryption' => 'tls',
         ],
     ],
     ```
6. Run `php yii migrate` to apply all system migrations.
7. Create virtual hosts for `frontend/web` and `backend/web` directories.
   Virtual Host templates

   ```
   <VirtualHost *:80>
       ServerName yii2-ecommerce.localhost
       DocumentRoot "/path/to/ecommerce-website/frontend/web/"

       <Directory "/path/to/ecommerce-website/frontend/web/">
           # use mod_rewrite for pretty URL support
           RewriteEngine on
           # If a directory or a file exists, use the request directly
           RewriteCond %{REQUEST_FILENAME} !-f
           RewriteCond %{REQUEST_FILENAME} !-d
           # Otherwise forward the request to index.php
           RewriteRule . index.php

           # use index.php as index file
           DirectoryIndex index.php

           # ...other settings...
           # Apache 2.4
           Require all granted

           ## Apache 2.2
           # Order allow,deny
           # Allow from all
       </Directory>
   </VirtualHost>


   <VirtualHost *:80>
       ServerName backend.yii2-ecommerce.localhost
       DocumentRoot "/path/to/ecommerce-website/backend/web/"

       <Directory "/path/to/ecommerce-website/backend/web/">
           # use mod_rewrite for pretty URL support
           RewriteEngine on
           # If a directory or a file exists, use the request directly
           RewriteCond %{REQUEST_FILENAME} !-f
           RewriteCond %{REQUEST_FILENAME} !-d
           # Otherwise forward the request to index.php
           RewriteRule . index.php

           # use index.php as index file
           DirectoryIndex index.php

           # ...other settings...
           # Apache 2.4
           Require all granted

           ## Apache 2.2
           # Order allow,deny
           # Allow from all
       </Directory>
   </VirtualHost>
   ```

8. Inside `common/config/params-local.php`
   [create PayPal application](https://developer.paypal.com/developer/applications/)
   ```php
   <?php
   //For paypal and front-end url configuration
   return [
       'frontendUrl' => 'YOUR_FRONTEND_HOST',
       'paypalClientId' => '',
       'paypalSecret' => '',
       'vendorEmail' => 'admin@yourwebsite.com'
   ];
   ```

## Building assets

The project uses webpack to build the assets.<br>
The project styles and bootstrap styles are built together.
Source files are located in `frontend/scss` and `backend/js`.

#### Bootstrap customization

If you want to customize bootstrap variables, open `frontend/scss/bootstrap-variables.scss`<br>
Check [the following link](https://getbootstrap.com/docs/4.0/getting-started/theming/)

#### For Development

Run`npm run dev`

#### For production

Run `npm run prod`

## Create seller

```bash
php yii app/create-seller-user USERNAME [PASSWORD]
```

php yii app/create-seller-user username ex-amir password- 9b34xsu2

## fix npm dev:

delete npm modules <br>
delete package-lock.json <br>
run npm install postcss@latest --save-dev <br>
run npm cache clean --force <br>
run npm run dev

## fix Bugs

1. inside php.ini uncomment _extension=intl_

## API calls for payment systems (post request)

1.  Paying for product
    http://frontend.yii2-ecomerce.localhost/api/adib-payment/
    {
    "transaction_id" : "referance_number"
    "status" : "new"
    }
2.  Confrming payment
    http://frontend.yii2-ecomerce.localhost/api/adib-payment/
    {
    "transaction_id" : "referance_number"
    "status" : "paid"
    }
