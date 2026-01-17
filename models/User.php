<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'fredouil.internaute';
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    // C'est ici je cherche l'utilisateur par son PSEUDO
    public static function findByUsername($username)
    {
        return static::findOne(['pseudo' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null; 
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    
}