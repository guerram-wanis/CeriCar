<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Inscription';
?>
<div class="site-inscription container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Veuillez remplir les champs pour vous inscrire :</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'form-inscription',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
            ]); ?>

                <?= $form->field($model, 'nom')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'prenom')->textInput() ?>
                <?= $form->field($model, 'pseudo')->textInput() ?>
                <?= $form->field($model, 'mail')->input('email') ?>
                
                <?= $form->field($model, 'pass')->passwordInput() ?>
                
                <?= $form->field($model, 'permis')->textInput(['placeholder' => 'Numéro (Optionnel)']) ?>
                <?= $form->field($model, 'photo')->textInput(['placeholder' => 'URL de la photo (Optionnel)']) ?>

                <div class="form-group">
                    <?= Html::submitButton('S\'inscrire', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>