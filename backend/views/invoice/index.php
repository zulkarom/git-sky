<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <p>
        <?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'summary',
            'invoice_date',
            'due_date',
            'client_id',
			
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{pdf} {update}',
				//'format' => 'raw',
                //'visible' => false,
                'buttons'=>[
                    'pdf'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-file"></span> PDF',['/invoice/pdf', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'target' => '_blank']);
                    },
					'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['question-prime/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
