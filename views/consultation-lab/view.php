<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultationLab */

$this->title = $model->auto_number;
$this->params['breadcrumbs'][] = ['label' => 'Consultation Labs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="consultation-lab-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->auto_number], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->auto_number], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'auto_number',
            'patientname',
            'patientcode',
            'accountname',
            'accountcode',
            'gender',
            'age',
            'agegroup',
            'dateofbirth',
            'typeofpatient',
            'doctor',
            'accountho',
            'desprepotno',
            'testname',
            'categoryname',
            'testcode',
            'testrate',
            'urgent',
            'invno',
            'docno',
            'sampledocno',
            'labsamplecoll',
            'labrefund',
            'refundapprove',
            'paymentmode',
            'totalamount',
            'ipaddress',
            'username',
            'storename',
            'storecode',
            'discountpercent',
            'discountamount',
            'subtotal',
            'locationname',
            'locationcode',
            'consultationdate',
            'consultationtime',
            'samplecollectedon',
            'resultentry',
            'resultdoc',
            'publishstatus',
            'cashrecd',
            'balamount',
            'bankname',
            'cardno',
            'mpesano',
            'mpesaamount',
            'cardamount',
            'cashamount',
            'chequeamount',
            'chequebankname',
            'chequeno',
            'chequedate',
            'labrefundstatus',
            'billdatetime',
            'printorder',
            'status',
            'originalstatus',
            'batchnumber',
            'mrdno',
            'acc_editedby',
            'acc_updatedatetime',
            'restore',
            'flag',
            'refund_initiatedby',
            'refund_initiateddate',
            'refund_approvedby',
            'refund_approveddate',
        ],
    ]) ?>

</div>
