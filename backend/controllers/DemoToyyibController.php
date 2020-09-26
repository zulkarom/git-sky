<?php

namespace backend\controllers;

use Yii;
use backend\models\DemoToyyib;
use backend\models\DemoToyyibSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DemoToyyibController implements the CRUD actions for DemoToyyib model.
 */
class DemoToyyibController extends Controller
{
    /**
     * {@inheritdoc}
     */
	 
	     

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
					[
                        'actions' => ['callback-url'],
                        'allow' => true,
						'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
		
        ];
    }

    /**
     * Lists all DemoToyyib models.
     * @return mixed
     */
    public function actionIndex()
    {
		
        $searchModel = new DemoToyyibSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DemoToyyib model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DemoToyyib model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DemoToyyib();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DemoToyyib model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DemoToyyib model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DemoToyyib model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DemoToyyib the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DemoToyyib::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionCreateBillPage($id){
		echo 'Please wait while we are directing you to ToyyibPay. Please do NOT close or refresh the browser...';
		$model = $this->findModel($id);
		$amount = $model->billAmount * 100;
		
		  $some_data = array(
			'userSecretKey'=> $this->secretKey,
			'categoryCode'=> 'kqr7djwa', //dev category
			'billName'=> $model->billName,
			'billDescription'=> $model->billDescription,
			'billPriceSetting'=> 1, //Put 1 if the bill has fix amount, put 0 if dynamic amount.
			'billPayorInfo'=>1,
			'billAmount'=> $amount,
			'billReturnUrl'=>'https://skyhint.com/pengurusan/site/return-url',
			'billCallbackUrl'=>'https://skyhint.com/pengurusan/site/callback-url',
			'billExternalReferenceNo' => $model->order_id,
			'billTo'=> $model->billTo,
			'billEmail'=> $model->billEmail,
			'billPhone'=> $model->billPhone,
			'billSplitPayment'=>0, //[OPTIONAL] Set 1 if the you need the payment to be splitted to other toyyibPay users.
			'billSplitPaymentArgs'=>'', // [OPTIONAL] Provide JSON for split payment. e.g. [{"id":"johndoe","amount":"200"}]
			'billPaymentChannel'=>'2', //[OPTIONAL] 0 = FPX Only, 1 = Credit/Debit Card only, 2 = FPX and Credit Card
			'billDisplayMerchant'=>1, //[OPTIONAL] 0 = Not display merchant details in email, 1 = Display merchant details in email.
			//'billContentEmail'=>'Thank you for purchasing our product!', // [OPTIONAL] Provide your email content.
			'billChargeToCustomer'=> '' //Leave blank to set charges for both FPX and Credit Card on bill owner.
		  );  
		  
		  /* echo '<pre>';
		  print_r($some_data);die(); 
 */
		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_POST, 1);
		  curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');  
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

		  $result = curl_exec($curl);
		  $info = curl_getinfo($curl);  
		  curl_close($curl);
		  $obj = json_decode($result);
		  
		 // print_r($obj[0]);die();
		  
			if($obj){
				//echo $obj->BillCode;die();
				$code = $obj[0]->BillCode;
				$model->billcode = $code;
				if($model->save()){
					header("Location: https://dev.toyyibpay.com/" . $code);
						die();
				}else{
					echo 'Sorry, there is problem to store bill code!';
					die();
				}
			}else{
				echo 'Sorry, there is problem to create ToyyibPay Bill!';
				die();
			}
		
	}
	
	protected function getSecretKey(){
		return 'v1gc99hq-vfih-91gm-gu1s-46xxkrzxdehu'; // dev
		
		//return 'rbrywmkm-u92f-8qfw-jqlw-7mq6q6pk2lp0'; //prod
	}
	
	
	
	
}
