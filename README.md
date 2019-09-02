Chess
=====
Todo

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist shahimian/yii2-chess "*"
```

or add

```
"shahimian/yii2-chess": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by:

```php
<?= \shahimian\chess\Chess::widget(); ?>
```

Maybe you would want to module this extension then use it in your config Yii2:

```php
'modules' => [
    'chess' => [
        'class' => 'shahimian\chess\Module',
    ],
],
```