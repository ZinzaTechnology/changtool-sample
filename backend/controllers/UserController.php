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
use yii\data\Pagination;
use yii\web\Response;
use common\lib\logic\LogicUser;
use common\lib\helpers\AppArrayHelper;

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
    
    public function actionIndex()
    {
        $logicUser = new LogicUser();
        $userSearch = new UserSearch();
        
        $param_tmps = Yii::$app->request->queryParams;
        $params = [];
        
        if (!empty($param_tmps)) {
            if (isset($param_tmps['UserSearch'])) {
                $params = AppArrayHelper::filterKeys($param_tmps['UserSearch'], ['globalSearch']);
            }
        }
        
        $dataProvider = $logicUser->findUserBySearch(['UserSearch' => $params], $userSearch);
        $dataProvider->pagination->pageSize = 5;
        
        return $this->render('index', [
            'searchModel' => $userSearch,
            'dataProvider' => $dataProvider,
        ]);
    }
        
    /**
     * Create action.
     *
     */
    
    public function actionCreate()
    {
        $request = Yii::$app->request->post();
        
        if (isset($request['User'])) {
            $logicUser = new LogicUser();
            
            $params = AppArrayHelper::filterKeys($request['User'], ['u_name', 'u_fullname', 'u_role', 'u_mail', 'u_password_hash']);
            $newUser = $logicUser->createUserById($params);
                    
            if (empty($newUser->errors)) {
                return $this->redirect('index');
            } else {
                $this->setSessionFlash('error', Html::errorSummary($newUser));
                return $this->render('create', [
                    'model' => $newUser,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => new User(),
            ]);
        }
    }
    
    public function actionValidate()
    {
        $model = new User();
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            return ActiveForm::validate($model);
        }
    }
    
     /**
     * Login action.
     *
     * @return string
     */
    
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
     * View action.
     *
     */
    
    public function actionView($id)
    {
        $logicUser = new LogicUser();
        
        return $this->render('view', [
            'model' => $logicUser->findUserById($id),
        ]);
    }
    
    /**
     * Delete action.
     *
     */
    
    public function actionDelete($id)
    {
        $logicUser = new LogicUser();
        $logicUser->deleteUserById($id);
        return $this->redirect('index');
    }
    
    /**
     * Update action.
     *
     */
    
    public function actionUpdate($id)
    {        
        $request = Yii::$app->request->post();
        $user = LogicUser::findUserById($id);
        
        if (isset($request['User'])) {
            $updateUser = new LogicUser();
            
            $params = AppArrayHelper::filterKeys($request['User'], ['u_fullname', 'u_role', 'u_mail']);
            $updateUser->updateUserById($user, $params);
            
            return $this->redirect('index');
        }
        
        return $this->render('update', [
                'model' => $user,
            ]);
    }
    
    /**
     * Change Password action.
     *
     */
    
    public function actionChangepassword($id)
    {
        $request = Yii::$app->request->post();
        $user = LogicUser::findUserById($id);
        
        if (isset($request['User'])) {
            $changePwd = new LogicUser();
            
            $params = AppArrayHelper::filterKeys($request['User'], ['u_password_hash']);
            $changePwd->changePasswordUserById($user, $params);

            return $this->redirect('index');
        }
        
        return $this->render('changepassword', [
            'model' => $user,
            ]);
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
