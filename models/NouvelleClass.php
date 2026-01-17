<?php

namespace app\models;

use Yii;
use yii\base\Model;

class NouvelleClass
{
    public $tableau;
    
    public function __construct()
    {
        $this->tableau = [
            '1' => [
                'id' => '1',
                'produit' => 'Rose',
            ],
            '2'=> [
                'id' => '2',
                'produit' => 'Tulipe',
            ],
            '3'=>[
                'id' =>'3',
                'produit' => 'Jasmin',
            ],
            '4'=>[
                'id' =>'4',
                'produit' => 'Laurier Rose',
            ],
            '5'=>[
                'id' =>'5',
                'produit' => 'Orchidée',
            ]
        ];
    }
}