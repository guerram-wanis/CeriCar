<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class internaute extends ActiveRecord implements IdentityInterface
{
    public static function tableName(){
        return 'fredouil.internaute';
    }

    public function rules()
    {
        return [
            [['pseudo','pass','nom','prenom','mail'], 'required', 'message' => 'Ce champ est requis.'],
            
            [['pseudo','nom','prenom','mail'], 'string', 'max' => 45],
            [['pass'], 'string', 'max' => 255], 
            [['photo'], 'string', 'max' => 200],
            [['permis'], 'string', 'max' => 12], 

            [['mail'], 'email', 'message' => 'Email invalide.'],
            [['pseudo'], 'unique', 'message' => 'Pseudo déjà pris.'],
            [['mail'], 'unique', 'message' => 'Email déjà utilisé.'],
        ];
    }


    public function getReservations() {
        return $this->hasMany(reservation::class, ['voyageur' => 'id']);
    }
    
    public function getVoyagesProposes() {
        return $this->hasMany(voyage::class, ['conducteur' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByPseudo($pseudo)
    {
        return static::findOne(['pseudo' => $pseudo]);
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
        return $this->getAuthKey() === $authKey;
    }

 
    public function validatePassword($password)
    {
        return $this->pass === sha1($password);
    }
}