<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Proposer un voyage';
?>

<div class="site-proposer container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'proposer-form']); ?>

            <?= $form->field($model, 'ville_depart')->textInput(['placeholder' => 'Ex: Paris']) ?>
            <?= $form->field($model, 'ville_arrivee')->textInput(['placeholder' => 'Ex: Marseille']) ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'heuredepart')->textInput(['type' => 'number', 'min'=>0, 'max'=>23])->label('Heure de départ (0-23h)') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'tarif')->textInput(['type' => 'number', 'step' => '0.01']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'nbplacedispo')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'nbbagage')->textInput(['type' => 'number']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'idmarquev')->textInput(['type' => 'number', 'placeholder' => 'Ex: 1']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'idtypev')->textInput(['type' => 'number', 'placeholder' => 'Ex: 1']) ?>
                </div>
            </div>
            
            <?= $form->field($model, 'contraintes')->textarea(['rows' => 3]) ?>

            <div class="form-group">
                <?= Html::submitButton('Publier le trajet', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>