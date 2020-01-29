<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senha')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'super')->textInput() ?>

    <?= $form->field($model, 'intervalo_atualizacao')->textInput() ?>

    <?= $form->field($model, 'zoom_mapa')->textInput() ?>

    <?= $form->field($model, 'latitude_inicial_mapa')->textInput() ?>

    <?= $form->field($model, 'longitude_inicial_mapa')->textInput() ?>

    <?= $form->field($model, 'quantidade_alertas_visiveis_mapa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
