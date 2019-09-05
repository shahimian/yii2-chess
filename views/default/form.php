<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'chess-form',
]);
?>

<h1>Form Movement</h1>

    <?= $form->field($model, 'phrase') ?>

    <?= Html::submitButton('Move') ?>

<?php ActiveForm::end(); ?>
