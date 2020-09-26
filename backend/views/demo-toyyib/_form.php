<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DemoToyyib */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="demo-toyyib-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'billcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'return_status')->textInput() ?>

    <?= $form->field($model, 'billName')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'billAmount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billDescription')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billTo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billEmail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billPhone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'return_response')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'callback_response')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
