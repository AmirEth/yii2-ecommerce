<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'SMTP_HOST',
                'username' => 'engebeyayshoping@gmail.com',
                'password' => 'ppzy deba fwqh rywf', 
                'port' => 'SMTP_PORT',
                'encryption' => 'tls',
            ],
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
    ],
];
