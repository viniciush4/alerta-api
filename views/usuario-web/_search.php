<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'login') ?>

    <?= $form->field($model, 'senha') ?>

    <?= $form->field($model, 'access_token') ?>

    <?= $form->field($model, 'nome') ?>

    <?php // echo $form->field($model, 'telefone') ?>

    <?php // echo $form->field($model, 'super') ?>

    <?php // echo $form->field($model, 'intervalo_atualizacao') ?>

    <?php // echo $form->field($model, 'zoom_mapa') ?>

    <?php // echo $form->field($model, 'latitude_inicial_mapa') ?>

    <?php // echo $form->field($model, 'longitude_inicial_mapa') ?>

    <?php // echo $form->field($model, 'quantidade_alertas_visiveis_mapa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
