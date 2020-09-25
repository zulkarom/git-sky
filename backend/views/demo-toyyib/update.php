<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DemoToyyib */

$this->title = 'Update Demo Toyyib: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Demo Toyyibs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="demo-toyyib-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
