<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->registerJsFile('@web/js/cericar.js', [
    'depends' => [\yii\web\JqueryAsset::class]
]);

$this->title = 'Rechercher un voyage';
?>

<div class="site-index">
        <div id="flash-notification" class="alert alert-info" style="display:none; margin-bottom: 20px;"></div>
    <h1>Rechercher un Voyage</h1>

    <div class="well">
        <?php 
        $form = ActiveForm::begin([
            'id' => 'formulaire-recherchex',
            'action' => ['site/index'], 
            'method' => 'post'
        ]); 
        ?>
        
        <div class="row">
            <div class="col-md-4">
                <?= Html::textInput('ville_depart', '', ['placeholder' => 'Ex: Marseille', 'class' => 'form-control']) ?>
            </div>
            <div class="col-md-4">
                <?= Html::textInput('ville_arrivee', '', ['placeholder' => 'Ex: Paris', 'class' => 'form-control']) ?>
            </div>
            <div class="col-md-2">
                <?= Html::input('number', 'nb_personnes', '1', ['min' => 1, 'class' => 'form-control']) ?>
            </div>
            <div class="col-md-2">
                <?= Html::submitButton('Rechercher', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>

    <hr>

<div id="zone-resultats" style="background-color: rgba(255,255,255, 0.95); padding: 20px; border-radius: 10px; margin-top: 20px;"></div>
</div>