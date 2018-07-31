<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\Form1;
use app\models\Bids;
use app\models\Events;
use app\models\Subscription;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
               // 'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login','error','signup'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['tasks'],
                        'allow' => true,
                        'roles' => ['canAdmin'],
                    ],
                    [
                        'actions' => ['role'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['moderator'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        $model->created_at = date("Y-m-d");
        $model->updated_at = date("Y-m-d");
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

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->username = 'admin';
        $model->password = 'admin';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionTasks()
    {
        $modelf = new Form1();
        $modelf->students = '28';
        $modelf->sport = '75';

        $onequery = "SELECT * FROM bids 
        INNER JOIN events ON bids.id_event = events.id_event
        WHERE bids.price = (SELECT MAX(price) FROM bids)
        ";

        $twoquery = "SELECT * FROM events
        WHERE events.id_event NOT IN (SELECT id_event FROM bids)
        ";

        $threequery = "SELECT events.caption, count(bids.id_event) as kol FROM events
        INNER JOIN bids ON bids.id_event = events.id_event
        GROUP BY events.caption";

        $fourquery = "SELECT events.caption, count(bids.id_event) as kol FROM events
        INNER JOIN bids ON bids.id_event = events.id_event
        GROUP BY events.caption";


        $bids1 = Bids::findBySql($onequery)->all();
        $bids2 = Events::findBySql($twoquery)->all();
        $bids3 = Events::findBySql($threequery)->all();
        $bids4 = Events::findBySql($fourquery)->all();

        if ($modelf->load(Yii::$app->request->post()) && $modelf->validate()) {

        return $this->render('tasks',[
                'modelf' => $modelf,
                'bids1' => $bids1,
                'bids2' => $bids2,
                'bids3' => $bids3,
                'bids4' => $bids4,
            ]);
        } else {
            return $this->render('tasks',[
                'modelf' => $modelf,
                'bids1' => $bids1,
                'bids2' => $bids2,
                'bids3' => $bids3,
                'bids4' => $bids4,
            ]);
        }
    }

    public function actionRole() 
    {
        /*
        $admin = Yii::$app->authManager->createRole('admin');
        $admin->description = 'Администратор';
        Yii::$app->authManager->add($admin);

        $manager = Yii::$app->authManager->createRole('manager');
        $manager->description = 'Менеджер';
        Yii::$app->authManager->add($manager);

        $moderator = Yii::$app->authManager->createRole('moderator');
        $moderator->description = 'Модератор';
        Yii::$app->authManager->add($moderator);

        $ban = Yii::$app->authManager->createRole('banned');
        $ban->description = 'Заблокированный';
        Yii::$app->authManager->add($ban); 

        $permit = Yii::$app->authManager->createPermission('canAdmin');
        $permit->description = 'Право входа в админку';
        Yii::$app->authManager->add($permit); 


        $role_admin = Yii::$app->authManager->getRole('admin');
        $role_manager = Yii::$app->authManager->getRole('manager');
        $permit = Yii::$app->authManager->getPermission('canAdmin');
        Yii::$app->authManager->addChild($role_admin, $permit);
        Yii::$app->authManager->addChild($role_manager, $permit); 
        $role_admin = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->assign($role_admin, Yii::$app->user->id); */
        /*
        if (Yii::$app->user->can('canAdmin')) { // для троих
          //  if (Yii::$app->user->can('Admin')) только админ
        } else {

        } 

        $auth = Yii::$app->authManager;
        $rule = new AuthorRule();
        $auth->add($rule);*/

        /* добавляем право "updateOwnPost" и связываем правило с ним
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Редактировать посты';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);*/
    

        return 123;
        //return $this->render('roles');
    }


}
