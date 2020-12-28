<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultationLab */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consultation-lab-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'patientname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patientcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accountname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accountcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agegroup')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateofbirth')->textInput() ?>

    <?= $form->field($model, 'typeofpatient')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doctor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accountho')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desprepotno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'testname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoryname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'testcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'testrate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'urgent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'docno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sampledocno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'labsamplecoll')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'labrefund')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refundapprove')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paymentmode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'totalamount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ipaddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'storename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'storecode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discountpercent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discountamount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'locationname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'locationcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consultationdate')->textInput() ?>

    <?= $form->field($model, 'consultationtime')->textInput() ?>

    <?= $form->field($model, 'samplecollectedon')->textInput() ?>

    <?= $form->field($model, 'resultentry')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resultdoc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publishstatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cashrecd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'balamount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bankname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cardno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mpesano')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mpesaamount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cardamount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cashamount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chequeamount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chequebankname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chequeno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chequedate')->textInput() ?>

    <?= $form->field($model, 'labrefundstatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billdatetime')->textInput() ?>

    <?= $form->field($model, 'printorder')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'originalstatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'batchnumber')->textInput() ?>

    <?= $form->field($model, 'mrdno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acc_editedby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acc_updatedatetime')->textInput() ?>

    <?= $form->field($model, 'restore')->textInput() ?>

    <?= $form->field($model, 'flag')->textInput() ?>

    <?= $form->field($model, 'refund_initiatedby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_initiateddate')->textInput() ?>

    <?= $form->field($model, 'refund_approvedby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_approveddate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
