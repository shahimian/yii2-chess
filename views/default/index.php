<?php

use shahimian\chess\Chess;

?>

<?php
$game1 = Chess::begin([
    'phrase' => 'e2-e4',
]);
$game1->phrase('e7-e5');
?>

<?= $game1->view() ?>

<?php $game1->end(); ?>
