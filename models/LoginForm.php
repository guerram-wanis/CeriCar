<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\internaute;

class LoginForm extends Model
{
    public $pseudo;
    public $motpasse;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['pseudo', 'motpasse'], 'required'],
            ['rememberMe', 'boolean'],
            ['motpasse', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
{
    if (!$this->hasErrors()) {
        $user = $this->getUser();

        if (!$user || !$user->validatePassword($this->motpasse)) {
            $this->addError($attribute, 'Pseudo ou mot de passe incorrect.');
        }
    }
}

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = internaute::findOne(['pseudo' => $this->pseudo]); 
        }
        return $this->_user;
    }
}