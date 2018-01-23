<?php

namespace backend\controllers;

use Yii;
use common\models\AdminModel;
use common\models\AdminSearch;
use backend\models\SignupForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AdminController implements the CRUD actions for AdminModel model.
 */
class AdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            //access为简单的ACF权限管理
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        // 当前rule将会针对这里设置的actions起作用，如果actions不设置，默认就是当前控制器的所有操作
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'signup'],
                        // 设置actions的操作是允许访问还是拒绝访问
                        'allow' => true,
                        // @ 当前规则针对认证过的用户; ? 所有人均可访问
                        'roles' => ['@'],
                    ],
                    //只允许userId为1的管理员访问update方法。
//                    [
//                        'actions' => ['update'],
//                        // 自定义一个规则，返回true表示满足该规则，可以访问，false表示不满足规则，也就不可以访问actions里面的操作啦
//                        'matchCallback' => function ($rule, $action) {
//                            return Yii::$app->user->id == 1 ? true : false;
//                        },
//                        'allow' => true,
//                    ],
                ],
            ],

            //行为的定义，RBAC权限控制基于此行为，每次进入此控制器，都会执行行为类的beforeAction方法。
//            'Behavior' => \backend\components\Behavior::className(),

        //一个简单的自定义RBAC
//            'AccessControl' => [
//                'class' => 'backend\components\AccessControl',
//            ],

            //设置访问的请求类型，delete方法只允许POST请求
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AdminModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        //此方法简单，但是方法多了就不行，要用行为来解决。
//        if (!Yii::$app->user->can('/admin/index')) {
//            throw new \yii\web\ForbiddenHttpException("没权限访问.");
//        }
        //此控制器通过上面behaviors方法重写的Behavior行为，跟\backend\components\Behavior类绑定了，可以调用行为类的方法。
//        $myBehavior = $this->getBehavior('myBehavior');
//        $isGuest = $myBehavior->isGuest();
//        var_dump($isGuest);

        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdminModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new AdminModel();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    public function actionSignup()
    {
        $model = new SignupForm();

        // 如果是post提交且有对提交的数据校验成功（我们在SignupForm的signup方法进行了实现）
        // $model->load() 方法，实质是把post过来的数据赋值给model
        // $model->signup() 方法, 是我们要实现的具体的添加用户操作
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(['index']);
        }

        // 渲染添加新用户的表单
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AdminModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdminModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
