<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DemoToyyibSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Demo Toyyibs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="demo-toyyib-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Demo Toyyib', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'order_id',
            'billName',
            //'billDescription',
            'billTo',
			'return_status',
            //'billEmail:email',
            'billPhone',
            //'return_response:ntext',
            //'callback_response:ntext',

 
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 20%'],
                'template' => '{update} {pay}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['demo-toyyib/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					
                    'pay'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-dollar"></span> PAY',['demo-toyyib/create-bill-page/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					
					
                ],
				
				
            
            ],
        ],
    ]); ?>
</div>
