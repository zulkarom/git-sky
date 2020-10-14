<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DemoToyyibSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of buyers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="demo-toyyib-index">

  
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'transaction_id',
            'billTo',
'student_id',
            'billEmail:email',
            'billPhone',
'group_name',
            //'return_response:ntext',
            //'callback_response:ntext',

 
			
			
				
				
            
            ],
        ],
    ]); ?>
</div>
