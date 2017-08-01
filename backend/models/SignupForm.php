<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\AdminModel;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repassword;

    public $created_at;
    public $updated_at;


    /**
     * @inheritdoc
     * 对数据的校验规则
     */
    public function rules()
    {
        return [
//            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'trim'],
            ['username', 'required','message'=>'用户名不能为空'],//message不写，默认也有提示
            ['username', 'unique', 'targetClass' => '\common\models\AdminModel', 'message' => Yii::t('common','This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\AdminModel', 'message' => Yii::t('common','This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 18, 'tooShort' => '密码至少填写6位', 'tooLong' => '密码最多填写18位'],

            ['repassword', 'required'],
            ['repassword', 'string', 'min' => 6, 'max' => 18, 'tooShort' => '密码至少填写6位', 'tooLong' => '密码最多填写18位'],

            ['repassword', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码必须相同'],

            // default 默认在没有数据的时候才会进行赋值
            [['created_at', 'updated_at'], 'default', 'value' => date('Y-m-d H:i:s')]
        ];
    }

    /**
     * 配置中文标签
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('common', 'username'),
            'email'    => Yii::t('common', 'Email'),
            'password' => Yii::t('common', 'password'),
            'repassword' => Yii::t('common', 'repassword')
        ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new AdminModel();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->created_at = $this->created_at;
        $user->updated_at = $this->updated_at;

        //密码要加密处理
        $user->setPassword($this->password);
        //生成‘记住我’的认证key，自动登录。
        $user->generateAuthKey();
        
        return $user->save(false);
    }
}
