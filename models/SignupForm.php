<?php 

namespace app\models;

use Yii;
use yii\base\Model;
     
    /**
     * Signup form
     */
    class SignupForm extends Model
    {
     
        public $username;
        public $email;
        public $password;
     
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                ['username', 'trim'],
                ['username', 'required', 'message' => 'Поле не может быть путсым.'],
                ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Введенное вами имя уже используется.'],
                ['username', 'string', 'min' => 2, 'max' => 255],
                ['email', 'trim'],
                ['email', 'required', 'message' => 'Поле не может быть путсым.'],
                ['email', 'email', 'message' => 'Введенная вами строка не соответствет формату email.'],
                ['email', 'string', 'max' => 255],
                ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Введенный вами email уже используется.'],
                ['password', 'required', 'message' => 'Поле не может быть путсым.'],
                ['password', 'string', 'min' => 6],
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
     
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            return $user->save() ? $user : null;
        }
     
    }