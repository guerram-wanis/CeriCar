<?php
namespace app\models;

use yii\db\ActiveRecord;

class voyage extends ActiveRecord
{
    public static function tableName(){
        return 'fredouil.voyage';
    }


    public $ville_depart;
    public $ville_arrivee; 

    public function rules()
    {
        return [
            [['ville_depart', 'ville_arrivee'], 'required', 'message' => 'Villes obligatoires.'],

            [['conducteur', 'trajet', 'idtypev', 'idmarquev', 'tarif', 'nbplacedispo', 'nbbagage', 'heuredepart'], 'required'],
            
            [['conducteur', 'trajet', 'idtypev', 'idmarquev', 'nbplacedispo', 'nbbagage', 'heuredepart'], 'integer'],
            
            [['tarif'], 'number'],
            [['contraintes'], 'string', 'max' => 500],
        ];
    }

    public static function getVoyageByTrajetId($id){
        return self::findAll(['trajet' => $id]);
    }

    public static function getVoyageId($id){
        return self::findOne($id);
    }

    public function getInfosTrajet() {
    return $this->hasOne(trajet::class, ['id' => 'trajet']);
    }

    public function getMarque() {
        return $this->hasOne(marquevehicule::class, ['id' => 'idmarquev']);
    }
    public function getType() {
        return $this->hasOne(typevehicule::class, ['id' => 'idtypev']);
    }

     public function getNomConducteur() {
        return $this->hasOne(internaute::class, ['id' => 'conducteur']);
    }

    public function getPlacesDisponibles(){
    $places_prises = (int) $this->getReservations()->sum('nbplaceresa'); 
    return $this->nbplacedispo - $places_prises;
    }
    

    public function getReservations() {
        return $this->hasMany(reservation::class, ['voyage' => 'id']);
    }
    
    public function estComplet(){
        return $this->getPlacesDisponibles() ==0;
    }

    public function getCoutTotal($distance, $nbPersonnes) {
    return number_format($this->tarif * $distance * $nbPersonnes, 2, ',', ' ');
    }

    public function getHeurreArrive($distance) {
    return gmdate('H:i', floor(($distance * 60) + ($this->heuredepart * 3600)));
    }

    public function getPlacesMax()
    {
        return (int) $this->nbplacedispo;
    }

    public static function getVoyagesByConducteur($id_conducteur)
    {
        return static::findAll(['conducteur' => $id_conducteur]);
    }

    public function getNbPlacesReservees()
    {
        $reservees = $this->nbplacedispo - $this->getPlacesDisponibles();
        return $reservees . ' / ' . $this->nbplacedispo;
    }
}