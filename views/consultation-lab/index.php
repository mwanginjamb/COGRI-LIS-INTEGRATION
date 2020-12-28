<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsultationLabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultation Labs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-lab-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Consultation Lab', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'auto_number',
            'patientname',
            'patientcode',
            'accountname',
            'accountcode',
            //'gender',
            //'age',
            //'agegroup',
            //'dateofbirth',
            //'typeofpatient',
            //'doctor',
            //'accountho',
            //'desprepotno',
            //'testname',
            //'categoryname',
            //'testcode',
            //'testrate',
            //'urgent',
            //'invno',
            //'docno',
            //'sampledocno',
            //'labsamplecoll',
            //'labrefund',
            //'refundapprove',
            //'paymentmode',
            //'totalamount',
            //'ipaddress',
            //'username',
            //'storename',
            //'storecode',
            //'discountpercent',
            //'discountamount',
            //'subtotal',
            //'locationname',
            //'locationcode',
            //'consultationdate',
            //'consultationtime',
            //'samplecollectedon',
            //'resultentry',
            //'resultdoc',
            //'publishstatus',
            //'cashrecd',
            //'balamount',
            //'bankname',
            //'cardno',
            //'mpesano',
            //'mpesaamount',
            //'cardamount',
            //'cashamount',
            //'chequeamount',
            //'chequebankname',
            //'chequeno',
            //'chequedate',
            //'labrefundstatus',
            //'billdatetime',
            //'printorder',
            //'status',
            //'originalstatus',
            //'batchnumber',
            //'mrdno',
            //'acc_editedby',
            //'acc_updatedatetime',
            //'restore',
            //'flag',
            //'refund_initiatedby',
            //'refund_initiateddate',
            //'refund_approvedby',
            //'refund_approveddate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
