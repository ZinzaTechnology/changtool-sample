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
            $this->layout = 'none';
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
        
        if (!empty($id)) {
            $model = $logicUser->findUserById($id);
            if ($model == null) {
                $this->setSessionFlash('error', "User not found");
            } else {
                return $this->render('view', [
                    'model' => $logicUser->findUserById($id),
                ]);
            }
        } else {
            $this->setSessionFlash('error', 'Invalid user');
        }
        return $this->redirect('index');
    }
    
    /**
     * Delete action.
     *
     */
    
    public function actionDelete($id)
    {
        $logicUser = new LogicUser();
        
        if (!empty($id)) {
            $model = $logicUser->findUserById($id);
            
            if ($model == null) {
                $this->setSessionFlash('error', 'User not found');
            } else {
                $logicUser->deleteUserById($id);
            }
        } else {
            $this->setSessionFlash('error', 'Invalid User');
        }
        
        return $this->redirect('index');
    }
    
    /**
     * Update action.
     *
     */
    
    public function actionUpdate($id)
    {
        $request = Yii::$app->request->post();
        $logicUser = new LogicUser();
        
        if (!empty($id)) {
            $user = $logicUser->findUserById($id);
            
            if (empty($user)) {
                $this->setSessionFlash('error', 'User not found');
                return $this->redirect('index');
            } else {
                if (isset($request['User'])) {
                    $params = AppArrayHelper::filterKeys($request['User'], ['u_fullname', 'u_role', 'u_mail']);
                    $logicUser->updateUser($user, $params);
                    
                    return $this->redirect('index');
                }
            
                return $this->render('update', [
                    'model' => $user,
                ]);
            }
        } else {
            $this->setSessionFlash('error', 'Invalid user');
            
            return $this->redirect('index');
        }
    }
    
    /**
     * Change Password action.
     *
     */
    
    public function actionChangepassword($id)
    {
        $request = Yii::$app->request->post();
        
        $logicUser = new LogicUser();
        if (!empty($id)) {
            $user = $logicUser->findUserById($id);
            
            if (empty($user)) {
                $this->setSessionFlash('error', 'User not found');
                return $this->redirect('index');
            } else {
                if (isset($request['User'])) {
                    $params = AppArrayHelper::filterKeys($request['User'], ['u_password_hash', 'confirm_pwd_update']);
                    $user = $logicUser->changePassword($user, $params);
                    if ($user == null) {
                        $this->setSessionFlash('error', 'Confirm password incorrect!');
                        return $this->redirect('changepassword');
                    }
                    
                    return $this->redirect('index');
                }
            
                return $this->render('changepassword', [
                    'model' => $user,
                    ]);
            }
        } else {
            $this->setSessionFlash('error', 'Invalid user');
            
            return $this->redirect('index');
        }
    }
}
