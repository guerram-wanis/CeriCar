<?php
namespace app\models;

use yii\db\ActiveRecord;

class reservation extends ActiveRecord
{
    public static function tableName(){
        return 'fredouil.reservation';
    }

    public static function getReservationsByVoyageId($id) {
        return static::findAll(['voyage' => $id]);
    }

    public function getInfosVoyage() {
        return $this->hasOne(voyage::class, ['id' => 'voyage']);
    }

    public function getNomVoyageur() {
        return $this->hasOne(internaute::class, ['id' => 'voyageur']);
    }

    public static function getReservationsByVoyageur($id_voyageur)
    {
        return static::findAll(['voyageur' => $id_voyageur]);
    }

}