<?php

namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use common\models\UserModel;
use api\models\LoginForm;
use yii\web\IdentityInterface;

class UsersController extends ActiveController
{
    public $modelClass = 'common\models\UserModel';

    //行为重写,array_merge是把父类的行为和重写的合并，意思就是新增了一个authenticatior方法
    //此方法为API验证token的行为,通过查询字段的方式认证,optional是过滤不需要验证的方法。(登录注册不需要)
    //后面API的控制器需要token验证的，都要加上下面的行为。
    public function behaviors() {
        return ArrayHelper::merge (parent::behaviors(), [
            'authenticator' => [
                'class' => QueryParamAuth::className(),
                'tokenParam' => 'access_token', //设置API传入的token名字叫什么，后面API要带上access_token
                'optional' => [
                    'login',
                    'signup-test'
                ],
            ]
        ] );
    }


    /**
     * 添加测试用户
     * 发送手机验证码
     */
//    public function actionSignupTest()
//    {
//        $user = new UserModel();
//        $user->generateAuthKey();
//            $user->setPassword('123456');
//            $user->username = 'test';
//            $user->email = '111@111.com';
//            $user->save(false);
//
//            return [
//                'code' => 0
//            ];
//        }


        /**
         * 登录
         */
        public function actionLogin()
    {
        $model = new LoginForm;
        $model->setAttributes(Yii::$app->request->post());
        if ($user = $model->login()) {
            if ($user instanceof IdentityInterface) {
                unset($user['auth_key']);
                unset($user['password_hash']);
                unset($user['password_reset_token']);
                unset($user['email_validate_token']);
                return $user;
            } else {
                return $user->errors;
            }
        } else {
            return $model->errors;
        }
    }

    /**
     * 仅供测试
     * @param $access_token
     * @return array
     */
    public function actionUserTest($access_token)
    {
        $user = UserModel::findIdentityByAccessToken($access_token);
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ];
    }
}
