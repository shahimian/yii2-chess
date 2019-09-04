<?php

namespace shahimian\chess;

use yii\web\AssetBundle;

class Assets extends AssetBundle {

    public $sourcePath = '@vendor/shahimian/yii2-chess/assets/dist';

    public $css = [
        'styles.css',
    ];

    public $js = [
        'app.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
