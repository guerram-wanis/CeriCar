<?php
namespace app\models;
use yii\db\ActiveRecord;

class trajet extends ActiveRecord
{
    public static function tableName() {
        return 'fredouil.trajet';
    }

    public static function getTrajet($depart, $arrivee) {
        return static::findOne(['depart' => $depart, 'arrivee' => $arrivee]);
    }
    

}