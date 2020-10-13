<?php
namespace ebook\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use common\models\UserToken;
use yii\web\ForbiddenHttpException;
use ebook\models\BookOrder;
use ebook\models\Book;


/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['signup', 'index', 'login', 'staff-login', 'download', 'download-file', 'book', 'failed','return', 'callback'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'staff-login'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
	
	public function beforeAction($action)
	{            
		if ($action->id == 'callback' or $action->id == 'return') {
			$this->enableCsrfValidation = false;
		}

		return parent::beforeAction($action);
	}

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$this->layout = 'landing-page';
		return $this->render('landing');
        
    }
	
	public function actionDownload($transaction)
    {
		$order = $this->findSuccessOrder($transaction);
		return $this->render('download', compact($transaction));
		
		
        
    }
	
	function collect_file($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
       // curl_setopt($ch, CURLOPT_REFERER, "http://www.xcontest.org");
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return($result);
    }

    function write_to_file($text,$new_filename){
        $fp = fopen($new_filename, 'w');
        fwrite($fp, $text);
        fclose($fp);
    }


  
	
	public function actionDownloadFile($transaction)
    {
		$order = $this->findSuccessOrder($transaction);
		
		$new_file_name = "basic_accounting_apt1043.pdf";
		$url = "https://ebook.skyhint.com/download/filef3tgswq34234.pdf";
		$temp_file_contents = collect_file($url);
		write_to_file($temp_file_contents,$new_file_name);
        
    }
	
	public function actionFailed()
    {
		
		return $this->render('failed');
        
    }
	
	public function actionBook($blink)
    {
		$book = $this->findBook($blink);
		$model = new BookOrder;
		$model->scenario = 'purchase';
		
		if ($model->load(Yii::$app->request->post())){
			
			$string = $book->id . '_' .$book->bname;
			$string = preg_replace('/[^\da-z _]/i', '', $string);
			$strBill = $string;
			if (strlen($string) > 25){
				$strBill = substr($string, 0, 25) . '...';
			}
			$strDesc = $string;
			if (strlen($string) > 95){
				$strDesc = substr($string, 0, 95) . '...';
			}
			
			$transaction_id = 'tran_'.time(). $this->quickRandom(6);
			// get unique recharge transaction id
			while( (BookOrder::find()->where(['transaction_id' => $transaction_id])->count() ) > 0) {
				$transaction_id = 'reid_'.time().$this->quickRandom(5);
			}
			$transaction_id = strtoupper($transaction_id);
			
			$model->transaction_id = $transaction_id;
			$model->billAmount = $book->price;
			$model->book_id = $book->id;
			$model->billName = $strBill;
			$model->billDescription = $strDesc;
			$model->status = 'initiate';
			if($model->save()){
				return $this->createBill($model);
			}else{
				echo 'Sorry, failed to create order!';
				print_r($model->getErrors());
				die();
			}
			
			
			exit;
		}
		
		
		return $this->render('index', 
			compact('model')
		);
        
    }
	
	private function createBill($model){
		//echo 'Please wait while we are directing you to ToyyibPay. Please do NOT close or refresh the browser...';
		$amount = $model->billAmount * 100;
		
		
		
		  $some_data = array(
			'userSecretKey'=> 'v1gc99hq-vfih-91gm-gu1s-46xxkrzxdehu',
			'categoryCode'=> 'kqr7djwa', //dev category
			'billName'=> $model->billName,
			'billDescription'=> $model->billDescription,
			'billPriceSetting'=> 1, //Put 1 if the bill has fix amount, put 0 if dynamic amount.
			'billPayorInfo'=>1,
			'billAmount'=> $amount,
			'billReturnUrl'=>'https://ebook.skyhint.com/site/return',
			'billCallbackUrl'=>'https://ebook.skyhint.com/site/callback',
			'billExternalReferenceNo' => $model->transaction_id,
			'billTo'=> $model->billTo,
			'billEmail'=> $model->billEmail,
			'billPhone'=> $model->billPhone,
			'billSplitPayment'=>0, //[OPTIONAL] Set 1 if the you need the payment to be splitted to other toyyibPay users.
			'billSplitPaymentArgs'=>'', // [OPTIONAL] Provide JSON for split payment. e.g. [{"id":"johndoe","amount":"200"}]
			'billPaymentChannel'=>'0', //[OPTIONAL] 0 = FPX Only, 1 = Credit/Debit Card only, 2 = FPX and Credit Card
			'billDisplayMerchant'=>0, //[OPTIONAL] 0 = Not display merchant details in email, 1 = Display merchant details in email.
			//'billContentEmail'=>'Thank you for purchasing our product!', // [OPTIONAL] Provide your email content.
			'billChargeToCustomer'=> '' //Leave blank to set charges for both FPX and Credit Card on bill owner.
		  );  
		  
		  

		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_POST, 1);
		  curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');  
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

		  $result = curl_exec($curl);
		  $info = curl_getinfo($curl , CURLINFO_HTTP_CODE);   
		  
		  //print_r($some_data);die(); 
	
		//echo $result;die();
		  $obj = json_decode($result);
		  
		  if(curl_errno($curl)) {
				return 'Couldn\'t send request: ' . curl_error($curl);
			}else{
				if($info == 200){
					
					if(is_array($obj)){
						
					$code = $obj[0]->BillCode;
					$model->billcode = $code;

					if($model->save()){
						curl_close($curl);
						header('location:https://dev.toyyibpay.com/'.$code);
						exit();
					}else{
						echo 'Sorry, there is problem to store bill code!';
						die();
					}


					
					

				}else{
					if(is_object($obj)){
						echo json_encode($obj);
					}else{
						echo 'Sorry, there is problem to create ToyyibPay Bill!';
					}
					
				}
					
				}else{
					echo 'Problem with curl';
				}
			}
			curl_close($curl);
		  
	
		
	}

	protected function findBook($blink)
    {
        if (($model = Book::findOne(['blink' => $blink])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findSuccessOrder($transaction)
    {
        if (($model = BookOrder::findOne(['transaction_id' => $transaction, 'status' => 'success'])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	public function quickRandom($length = 16)
	{
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
	}
	

	public function actionCallback(){
		
		$arr= array();
		$arr['ip_address'] = $_SERVER['REMOTE_ADDR'];
		if(Yii::$app->request->post()){
			
			
			$billcode = Yii::$app->request->post('billcode');
			$transaction_id = Yii::$app->request->post('order_id');
			$refno = Yii::$app->request->post('refno');
			$status = Yii::$app->request->post('status');
			$billcode = Yii::$app->request->post('billcode');
			$reason = Yii::$app->request->post('reason');
			
			if($status == '1'){
			if ($transaction_id){
				$payment = BookOrder::find()->where([ 'transaction_id' => $transaction_id])->one();
				if ($payment){
					if ($payment->status <> 'success'){
					//kena check skali lagi TODO:
				  /* $curl = curl_init();
				  curl_setopt($curl, CURLOPT_POST, 1);
				  curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/getBillTransactions');  
				  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				  curl_setopt($curl, CURLOPT_POSTFIELDS, ['billCode' => $billcode]);
				  $result = curl_exec($curl);
				  curl_close($curl);
				  $result = json_decode($result); */
					
					$payment->status = 'success';
					$payment->return_status = 1;
					$payment->toyyib_refno = $refno;
					$payment->toyyib_reason = $reason;
					$payment->payment_created = time();
					//todo: store all request
					
					$post = json_encode(Yii::$app->request->post());
					$arr['post'] = $post;
					$arr['datetime'] = date('y-m-d h:m:s');
					$payment->callback_response = json_encode($arr);
					
					
					$payment->save();

					}
				}
			}
		}
			

			
			
		}

		

		
		
		// Reply with an empty 200 response
       Yii::$app->response->statusCode = 200;
		Yii::$app->response->content = 'OK';
		
    }
	
	public function actionReturn(){
		$get = Yii::$app->getRequest();
		$status_id = $get->getQueryParam('status_id'); //Payment status. 1= success, 2=pending, 3=fail
		$billcode = $get->getQueryParam('billcode');
		$order_id = $get->getQueryParam('order_id');
		
		$arr = array();
		$arr['billcode'] = $billcode;
		$arr['order_id'] = $order_id;
		$arr['status_id'] = $status_id;
		$arr['datetime'] = date('y-m-d h:m:s');
		$arr['ip_address'] = $_SERVER['REMOTE_ADDR'];
		
		
		if($status_id == 1){
			if($billcode){
				$model = BookOrder::findOne(['billcode' => $billcode, 'transaction_id' => $order_id]);
				if($model){
					if($model->status <> 1){
						$model->return_status = 1;
						$model->status = 'success';
						$model->payment_created = time();
						$model->return_response = json_encode($arr);
						if($model->save()){
							return $this->redirect(['site/download', 'transaction' => $model->transaction_id]);
							
						}
					}else{
						echo 'Status already good';
					}
					
				}else{
					echo 'billcode not exist!';
				}
			}else{
				echo 'no billcode supplied!';
			}
		}else{
			return $this->redirect(['site/failed']);
		}
		
	}

}
