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

    /**
     * 项目初始化RBAC权限方法。
     */
    public function actionInit ()
    {
        //初始化权限管理类
        $auth = Yii::$app->authManager;
        // 添加 "/admin/index" 权限
//        $adminIndex = $auth->createPermission('/admin/index');
//        $adminIndex->description = '管理员列表';
//        $auth->add($adminIndex);

        $adminView = $auth->createPermission('/admin/view');
        $adminView->description = '管理员详情';
        $auth->add($adminView);

        $adminSignup = $auth->createPermission('/admin/signup');
        $adminSignup->description = '添加管理员';
        $auth->add($adminSignup);

        $adminUpdate = $auth->createPermission('/admin/update');
        $adminUpdate->description = '修改管理员';
        $auth->add($adminUpdate);

        $adminDelete = $auth->createPermission('/admin/delete');
        $adminDelete->description = '删除管理员';
        $auth->add($adminDelete);

        // 创建一个角色adminManage
//        $adminManage = $auth->createRole('管理员管理');
//        $adminManage->description = '高级管理员角色';
//        $auth->add($adminManage);

        $adminManage = $auth->getRole('管理员管理');
        //并为该角色分配"/admin/index"权限
//        $auth->addChild($adminManage, $adminIndex);
        $auth->addChild($adminManage, $adminView);
        $auth->addChild($adminManage, $adminSignup);
        $auth->addChild($adminManage, $adminUpdate);
        $auth->addChild($adminManage, $adminDelete);

        // 为用户 admin（该用户的uid=1） 分配角色 "管理员管理" 角色权限（角色权限就有admin/index权限）
//        $auth->assign($adminManage, 1); // 1是admin用户的uid
    }

}