<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //For Oagni-Styles
        'ogani-assets/css/bootstrap.min.css',
        'ogani-assets/css/font-awesome.min.css',
        'ogani-assets/css/elegant-icons.css',
        'ogani-assets/css/nice-select.css',
        'ogani-assets/css/jquery-ui.min.css',
        'ogani-assets/css/owl.carousel.min.css',
        'ogani-assets/css/slicknav.min.css',
        'ogani-assets/css/style.css',
        //From Cloud
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', 
        'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap',

    ];
    public $js = [
        'build/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
