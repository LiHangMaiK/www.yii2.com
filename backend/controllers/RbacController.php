<?php
/**
 * Created by PhpStorm.
 * User: maikuraki
 * Date: 2017/5/5
 * Time: 23:39
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class RbacController extends Controller
{

    public function actionInit ()
    {
        $auth = Yii::$app->authManager;
        // 添加 "/blog/index" 权限
        $blogIndex = $auth->createPermission('/blog/index');
        $blogIndex->description = '博客列表';
        $auth->add($blogIndex);
        // 创建一个角色blogManage，并为该角色分配"/blog/index"权限
        $blogManage = $auth->createRole('博客管理');
        $auth->add($blogManage);
        $auth->addChild($blogManage, $blogIndex);
        // 为用户 test1（该用户的uid=1） 分配角色 "博客管理" 权限
        $auth->assign($blogManage, 1); // 1是test1用户的uid
    }

}