<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ClientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'ic_no') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'postcode') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'state_id') ?>

    <?php // echo $form->field($model, 'phone1') ?>

    <?php // echo $form->field($model, 'phone2') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'occupation') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'date_drop') ?>

    <?php // echo $form->field($model, 'inactive_remark') ?>

    <?php // echo $form->field($model, 'prospect_id') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'trash') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
