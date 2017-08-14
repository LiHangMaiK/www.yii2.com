<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\models\UserModel;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;

    private $_user;

    const GET_API_TOKEN = 'generate_api_token';

    public function init ()
    {
        parent::init();
        $this->on(self::GET_API_TOKEN, [$this, 'onGenerateApiToken']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    //配置中文，两种方法，页面配置也可。
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('common','username'),
            'password' => Yii::t('common','password'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('common','Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $this->trigger(self::GET_API_TOKEN);//触发生成token事件
            return $this->_user;
        } else {
            return false;
        }
    }

    /**
     * 登录校验成功后，为用户生成新的token
     * 如果token失效，则重新生成token
     */
    public function onGenerateApiToken()
    {
        $user = $this->getUser();
        if (!$user->apiTokenIsValid($user->access_token)) { //该用户的token值查询是否过期
            $user->generateApiToken();//过期就重新生成
            $user->save(false);
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = UserModel::findByUsername($this->username);
        }

        return $this->_user;
    }
}
