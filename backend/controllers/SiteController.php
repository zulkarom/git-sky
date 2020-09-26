<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Product;
use backend\models\Customer;
use backend\modules\staff\models\Staff;
use common\models\User;
use backend\models\DemoToyyib;

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
                        'actions' => ['login', 'login-portal', 'error', 'callback-url', 'return-url'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
					'callback-url' => ['post']
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
		if ($action->id == 'callback-url' or $action->id == 'return-url') {
			$this->enableCsrfValidation = false;
		}

		return parent::beforeAction($action);
	}
	
	

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		
        return $this->render('index', [

		'customer' => 33
		
		]); 
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			
            return $this->goBack();
        } else {
            $this->layout = "//main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionLoginPortal($u,$t)
    {
        /* if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        } */
	

        $last5 = time() - (60);
		
		$db = Staff::find()
		->where(['staff_id' => $u, 'user_token' => $t])
		->andWhere('user_token_at > ' . $last5)
		->one();
		
		$staff = Staff::findOne(['staff_id' => $u]);
		$id = $staff->user_id;
		//echo $id;
		
		if($db){
		   $user = User::findIdentity($id);
			if(Yii::$app->user->login($user)){
				return $this->redirect(['jeb/submission']);
			}
		}else{
			throw new ForbiddenHttpException;
		}
    }
	

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        if(Yii::$app->user->logout()){
			return $this->goHome();
		}
    }
	
	public function actionCallbackUrl(){
		
		
		$arr= array();
		$arr['ip_address'] = $_SERVER['REMOTE_ADDR'];
		if(Yii::$app->request->post()){
			$billcode = Yii::$app->request->post('billcode');
			$order_id = Yii::$app->request->post('order_id');
			$model = DemoToyyib::findOne(['billcode' => $billcode, 'order_id' => $order_id]);
			if($model){
				$post = json_encode(Yii::$app->request->post());
				$arr['post'] = $post;
				$arr['datetime'] = date('y-m-d h:m:s');
				$model->callback_response = json_encode($arr);
				if($model->save()){
					Yii::$app->response->statusCode = 200;
					Yii::$app->response->content = 'OK';
				}
			}
			
			
		}
		
		
	}
	
	public function actionReturnUrl(){
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
				$model = DemoToyyib::findOne(['billcode' => $billcode, 'order_id' => $order_id]);
				if($model){
					$model->return_status = 1;
					$model->return_response = json_encode($arr);
					if($model->save()){
						//echo 'Congratulation, your payment is successful.';
						Yii::$app->session->addFlash('success', "Congratulation, your payment is successful.");
						
					}
				}else{
					echo 'billcode not exist!';
				}
			}else{
				echo 'no billcode supplied!';
			}
		}else{
			Yii::$app->session->addFlash('info', "Sorry, your payment is not successful.");
		}
		return $this->redirect(['demo-toyyib/index']);
	}

}
