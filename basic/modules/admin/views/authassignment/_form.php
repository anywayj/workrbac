<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_name')->textInput(['maxlength' => true])->dropDownList(\yii\helpers\ArrayHelper::map(app\models\AuthItem::find()->all(), 'name', 'description'),
    [
        'prompt' => 'Выберите роль',
    ]
    ) ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true])->dropDownList(\yii\helpers\ArrayHelper::map(app\models\User::find()->all(), 'id', 'username'),
    [
        'prompt' => 'Выберите пользователя',
    ]
    ) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
