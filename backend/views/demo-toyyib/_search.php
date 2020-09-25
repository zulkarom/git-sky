<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DemoToyyibSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="demo-toyyib-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'billcode') ?>

    <?= $form->field($model, 'return_status') ?>

    <?= $form->field($model, 'billName') ?>

    <?php // echo $form->field($model, 'billDescription') ?>

    <?php // echo $form->field($model, 'billTo') ?>

    <?php // echo $form->field($model, 'billEmail') ?>

    <?php // echo $form->field($model, 'billPhone') ?>

    <?php // echo $form->field($model, 'return_response') ?>

    <?php // echo $form->field($model, 'callback_response') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
