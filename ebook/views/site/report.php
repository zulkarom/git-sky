<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DemoToyyibSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of buyers';
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="courses">
		<div class="container">
<h3><?=$model->bname?></h3>
<div class="demo-toyyib-index">


<?php $form = ActiveForm::begin([
    'action' => ['report', 'blink' => $model->blink],
	'id' => 'filter-group',
    'method' => 'get',
]); ?>
    
<div class="row">
<div class="col-md-6"></div>
<div class="col-md-4"><?= $form->field($searchModel, 'group_name')->label(false)->dropDownList($model->groupList(),['prompt' => "Select Group"]) ?></div>
<div class="col-md-2"><?= $form->field($searchModel, 'settlement')->label(false)->dropDownList([1 => 'Yes', 0 => 'No'],['prompt' => "Choose Settlement"]) ?></div>
</div>

<?php ActiveForm::end(); ?>


  <div class="table-responsive">  <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'transaction_id',
            'billTo',
			'student_id',
			'group_name',
			
            'billEmail:email',
            'billPhone',
			'payment_created:date',
			[
				'attribute' => 'settlement',
				'value' => function($model){
					return $model->settlement == 1 ? 'Yes' : 'No';
				}
				
			],
			
            ],
    ]); ?></div>
	
	
	
</div></div></div>

<?php 

$this->registerJs('

$("#bookordersearch-group_name, #bookordersearch-settlement").change(function(){
	$("#filter-group").submit();
});






');




?>
