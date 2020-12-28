<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultationLabSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consultation-lab-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'auto_number') ?>

    <?= $form->field($model, 'patientname') ?>

    <?= $form->field($model, 'patientcode') ?>

    <?= $form->field($model, 'accountname') ?>

    <?= $form->field($model, 'accountcode') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'agegroup') ?>

    <?php // echo $form->field($model, 'dateofbirth') ?>

    <?php // echo $form->field($model, 'typeofpatient') ?>

    <?php // echo $form->field($model, 'doctor') ?>

    <?php // echo $form->field($model, 'accountho') ?>

    <?php // echo $form->field($model, 'desprepotno') ?>

    <?php // echo $form->field($model, 'testname') ?>

    <?php // echo $form->field($model, 'categoryname') ?>

    <?php // echo $form->field($model, 'testcode') ?>

    <?php // echo $form->field($model, 'testrate') ?>

    <?php // echo $form->field($model, 'urgent') ?>

    <?php // echo $form->field($model, 'invno') ?>

    <?php // echo $form->field($model, 'docno') ?>

    <?php // echo $form->field($model, 'sampledocno') ?>

    <?php // echo $form->field($model, 'labsamplecoll') ?>

    <?php // echo $form->field($model, 'labrefund') ?>

    <?php // echo $form->field($model, 'refundapprove') ?>

    <?php // echo $form->field($model, 'paymentmode') ?>

    <?php // echo $form->field($model, 'totalamount') ?>

    <?php // echo $form->field($model, 'ipaddress') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'storename') ?>

    <?php // echo $form->field($model, 'storecode') ?>

    <?php // echo $form->field($model, 'discountpercent') ?>

    <?php // echo $form->field($model, 'discountamount') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'locationname') ?>

    <?php // echo $form->field($model, 'locationcode') ?>

    <?php // echo $form->field($model, 'consultationdate') ?>

    <?php // echo $form->field($model, 'consultationtime') ?>

    <?php // echo $form->field($model, 'samplecollectedon') ?>

    <?php // echo $form->field($model, 'resultentry') ?>

    <?php // echo $form->field($model, 'resultdoc') ?>

    <?php // echo $form->field($model, 'publishstatus') ?>

    <?php // echo $form->field($model, 'cashrecd') ?>

    <?php // echo $form->field($model, 'balamount') ?>

    <?php // echo $form->field($model, 'bankname') ?>

    <?php // echo $form->field($model, 'cardno') ?>

    <?php // echo $form->field($model, 'mpesano') ?>

    <?php // echo $form->field($model, 'mpesaamount') ?>

    <?php // echo $form->field($model, 'cardamount') ?>

    <?php // echo $form->field($model, 'cashamount') ?>

    <?php // echo $form->field($model, 'chequeamount') ?>

    <?php // echo $form->field($model, 'chequebankname') ?>

    <?php // echo $form->field($model, 'chequeno') ?>

    <?php // echo $form->field($model, 'chequedate') ?>

    <?php // echo $form->field($model, 'labrefundstatus') ?>

    <?php // echo $form->field($model, 'billdatetime') ?>

    <?php // echo $form->field($model, 'printorder') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'originalstatus') ?>

    <?php // echo $form->field($model, 'batchnumber') ?>

    <?php // echo $form->field($model, 'mrdno') ?>

    <?php // echo $form->field($model, 'acc_editedby') ?>

    <?php // echo $form->field($model, 'acc_updatedatetime') ?>

    <?php // echo $form->field($model, 'restore') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'refund_initiatedby') ?>

    <?php // echo $form->field($model, 'refund_initiateddate') ?>

    <?php // echo $form->field($model, 'refund_approvedby') ?>

    <?php // echo $form->field($model, 'refund_approveddate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
