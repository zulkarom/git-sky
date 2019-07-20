<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Quotation;
use backend\models\QuotationPdf;

/**
 * Site controller
 */
class QrPubQuoteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
						'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {

    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($token = false)
    {
		if($token){
			$model = $this->findInvoice($token);
			$pdf = new QuotationPdf;
			$pdf->model = $model;
			$pdf->generatePdf();
		}else{
			$this->notFound();
		}
        
    }
	
	protected function findInvoice($token)
    {
        if (($model = Quotation::findOne(['token' => $token])) !== null) {
            return $model;
        }else{
			$this->notFound();
		}

    }
	
	protected function notFound(){
		echo 'Document not found';
	}
	

}
