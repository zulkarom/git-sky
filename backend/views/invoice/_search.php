<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\InvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'summary') ?>

    <?= $form->field($model, 'invoice_date') ?>

    <?= $form->field($model, 'due_date') ?>

    <?= $form->field($model, 'client_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'gst') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'invoice_pic') ?>

    <?php // echo $form->field($model, 'quotation_id') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'trash') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
