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
Testing
-------
For test this extension use these commands:
```bash
> java -jar selenium-server-standalone-*.jar -Dwebdriver.chrome.driver=chromedriver
> chromedriver
```
and then `codecept run`. Pay attention to **run server** firstly, so you can create new terminal for each line in upper commands.

*Notice* Make sure to set config Yii2 at `codeception.yml` in root folder and set your url that you test to be exact. For this purpose, modify `acceptance.suite.yml` in test folder.
