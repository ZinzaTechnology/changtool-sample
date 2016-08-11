<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\db\ActiveQuery;
use common\models\UserSearch;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\data\Pagination;

/**
 * Dashboard controller
 */
class UserController extends BackendController
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
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return Yii::$app->user->identity->u_role;
                }
                    ],
                ],
             ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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

    /**
     * Login action.
     *
     * @return string
     */
    
	public function actionIndex()
    {
		
    	$searchModel = new UserSearch();   	
    	
    	$param_tmps = Yii::$app->request->queryParams;
    	$param_tmps[$searchModel->formname()]['is_deleted'] = 0; 
		$dataProvider = $searchModel->search($param_tmps);
		$dataProvider->pagination->pageSize=5;
        return $this->render('index', [
        	'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
	public function actionCreate()
    {
    	$model = new User();
  		
	    if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
	    	Yii::$app->response->format = Response::FORMAT_JSON;
	    	return ActiveForm::validate($model);
		}
    	
    	if ($request = Yii::$app->request->post()) {
    		$request = $request['User'];
    		$model->u_name = $request['u_name'];
    		$model->u_fullname = $request['u_fullname'];
    		$model->u_role = $request['u_role'];
    		$model->u_mail = $request['u_mail'];
    		$model->u_password_hash = Yii::$app->security->generatePasswordHash($request['u_password_hash']);       	
    		if ($model->save()) {
            	return $this->redirect(['index', 'id' => $model->u_id]);
        	}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login('ADMIN')) {
            return $this->redirect(['/user/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    


    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
 	public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionDelete($id)
    {
    	$model = $this->findModel($id);
		$model->is_deleted = 1;
		$model->save();
        return $this->redirect(['index']);
    }
    
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);
		if ($request = Yii::$app->request->post()) {
			$request = $request['User'];
			$model->u_fullname = $request['u_fullname'];
			$model->u_mail = $request['u_mail'];
			$model->u_role = $request['u_role'];
			//$model->u_password_hash = Yii::$app->security->generatePasswordHash($request['u_password_hash']);
			if ($model->save()) {
				return $this->redirect(['index', 'id' => $model->u_id]);
			}
		}
        return $this->render('update', [
                'model' => $model,
            ]);
    }
    
	public function actionChangepassword($id)
 	{
 		$model = $this->findModel($id);
 		if ($request = Yii::$app->request->post()) {
 			$request = $request['User'];
 			$model->u_password_hash = Yii::$app->security->generatePasswordHash($request['u_password_hash']);
 			if($model->save()) {
 				return $this->redirect(['index', 'id' => $model->u_id]);
 			}			
 		}
 		return $this->render('changepassword', [
 			'model' => $model
 			]);
    }
    
	protected function findModel($id)
	{
		if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUsername()
	{
	    return $this->hasOne(User::className(), ['id' => 'u_name']);
	}
	 
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getFullname()
	{
	    return $this->hasOne(User::className(), ['id' => 'u_fullname']);
	}
	public function getEmail()
	{
		return $this->hasOne(User::className(), ['id' => 'u_mail']);
	}
	
}
