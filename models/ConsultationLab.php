<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consultation_lab".
 *
 * @property int $auto_number
 * @property string $patientname
 * @property string $patientcode
 * @property string $accountname
 * @property string $accountcode
 * @property string $gender
 * @property string $age
 * @property string $agegroup
 * @property string $dateofbirth
 * @property string $typeofpatient
 * @property string $doctor
 * @property string $accountho
 * @property string $desprepotno
 * @property string $testname
 * @property string $categoryname
 * @property string $testcode
 * @property float $testrate
 * @property string $urgent
 * @property string $invno
 * @property string $docno
 * @property string $sampledocno
 * @property string $labsamplecoll
 * @property string $labrefund
 * @property string $refundapprove
 * @property string $paymentmode
 * @property float $totalamount
 * @property string $ipaddress
 * @property string $username
 * @property string $storename
 * @property string $storecode
 * @property float $discountpercent
 * @property float $discountamount
 * @property float $subtotal
 * @property string $locationname
 * @property string $locationcode
 * @property string $consultationdate
 * @property string $consultationtime
 * @property string $samplecollectedon
 * @property string $resultentry
 * @property string $resultdoc
 * @property string $publishstatus
 * @property string $cashrecd
 * @property string $balamount
 * @property string $bankname
 * @property string $cardno
 * @property string $mpesano
 * @property float $mpesaamount
 * @property float $cardamount
 * @property float $cashamount
 * @property float $chequeamount
 * @property string $chequebankname
 * @property string $chequeno
 * @property string $chequedate
 * @property string $labrefundstatus
 * @property string $billdatetime
 * @property int $printorder
 * @property string $status
 * @property string $originalstatus
 * @property int $batchnumber
 * @property string $mrdno
 * @property string $acc_editedby
 * @property string $acc_updatedatetime
 * @property int $restore
 * @property int $flag
 * @property string $refund_initiatedby
 * @property string $refund_initiateddate
 * @property string $refund_approvedby
 * @property string $refund_approveddate
 * @property string $refund_flag
 */
class ConsultationLab extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consultation_lab';
    }

    public static function primaryKey()
    {
        return ['auto_number']; // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['Invoiced', 'integer'],
            ['refund_flag','safe'],
            [['patientname', 'patientcode', 'accountname', 'accountcode', 'gender', 'age', 'agegroup', 'dateofbirth', 'typeofpatient', 'doctor', 'accountho', 'desprepotno', 'testname', 'categoryname', 'testcode', 'testrate', 'urgent', 'invno', 'docno', 'sampledocno', 'labsamplecoll', 'labrefund', 'refundapprove', 'paymentmode', 'totalamount', 'ipaddress', 'username', 'storename', 'storecode', 'discountpercent', 'discountamount', 'subtotal', 'locationname', 'locationcode', 'consultationdate', 'consultationtime', 'samplecollectedon', 'resultentry', 'resultdoc', 'publishstatus', 'cashrecd', 'balamount', 'bankname', 'cardno', 'mpesano', 'mpesaamount', 'cardamount', 'cashamount', 'chequeamount', 'chequebankname', 'chequeno', 'chequedate', 'labrefundstatus', 'billdatetime', 'printorder', 'status', 'originalstatus', 'batchnumber', 'mrdno', 'acc_editedby', 'acc_updatedatetime', 'flag', 'refund_initiatedby', 'refund_initiateddate', 'refund_approvedby', 'refund_approveddate'], 'required'],
            [['dateofbirth', 'consultationdate', 'consultationtime', 'samplecollectedon', 'chequedate', 'billdatetime', 'acc_updatedatetime', 'refund_initiateddate', 'refund_approveddate'], 'safe'],
            [['testrate', 'totalamount', 'discountpercent', 'discountamount', 'subtotal', 'mpesaamount', 'cardamount', 'cashamount', 'chequeamount'], 'number'],
            [['printorder', 'batchnumber', 'restore', 'flag'], 'integer'],
            [['patientname', 'patientcode', 'accountname', 'accountcode', 'gender', 'age', 'agegroup', 'typeofpatient', 'doctor', 'accountho', 'desprepotno', 'testname', 'categoryname', 'testcode', 'urgent', 'invno', 'docno', 'sampledocno', 'labsamplecoll', 'labrefund', 'refundapprove', 'paymentmode', 'ipaddress', 'username', 'storename', 'storecode', 'locationname', 'locationcode', 'resultentry', 'resultdoc', 'publishstatus', 'cashrecd', 'balamount', 'bankname', 'cardno', 'mpesano', 'chequebankname', 'chequeno', 'labrefundstatus', 'status', 'originalstatus', 'mrdno', 'acc_editedby'], 'string', 'max' => 255],
            [['refund_initiatedby', 'refund_approvedby'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auto_number' => 'Auto Number',
            'patientname' => 'Patientname',
            'patientcode' => 'Patientcode',
            'accountname' => 'Accountname',
            'accountcode' => 'Accountcode',
            'gender' => 'Gender',
            'age' => 'Age',
            'agegroup' => 'Agegroup',
            'dateofbirth' => 'Dateofbirth',
            'typeofpatient' => 'Typeofpatient',
            'doctor' => 'Doctor',
            'accountho' => 'Accountho',
            'desprepotno' => 'Desprepotno',
            'testname' => 'Testname',
            'categoryname' => 'Categoryname',
            'testcode' => 'Testcode',
            'testrate' => 'Testrate',
            'urgent' => 'Urgent',
            'invno' => 'Invno',
            'docno' => 'Docno',
            'sampledocno' => 'Sampledocno',
            'labsamplecoll' => 'Labsamplecoll',
            'labrefund' => 'Labrefund',
            'refundapprove' => 'Refundapprove',
            'paymentmode' => 'Paymentmode',
            'totalamount' => 'Totalamount',
            'ipaddress' => 'Ipaddress',
            'username' => 'Username',
            'storename' => 'Storename',
            'storecode' => 'Storecode',
            'discountpercent' => 'Discountpercent',
            'discountamount' => 'Discountamount',
            'subtotal' => 'Subtotal',
            'locationname' => 'Locationname',
            'locationcode' => 'Locationcode',
            'consultationdate' => 'Consultationdate',
            'consultationtime' => 'Consultationtime',
            'samplecollectedon' => 'Samplecollectedon',
            'resultentry' => 'Resultentry',
            'resultdoc' => 'Resultdoc',
            'publishstatus' => 'Publishstatus',
            'cashrecd' => 'Cashrecd',
            'balamount' => 'Balamount',
            'bankname' => 'Bankname',
            'cardno' => 'Cardno',
            'mpesano' => 'Mpesano',
            'mpesaamount' => 'Mpesaamount',
            'cardamount' => 'Cardamount',
            'cashamount' => 'Cashamount',
            'chequeamount' => 'Chequeamount',
            'chequebankname' => 'Chequebankname',
            'chequeno' => 'Chequeno',
            'chequedate' => 'Chequedate',
            'labrefundstatus' => 'Labrefundstatus',
            'billdatetime' => 'Billdatetime',
            'printorder' => 'Printorder',
            'status' => 'Status',
            'originalstatus' => 'Originalstatus',
            'batchnumber' => 'Batchnumber',
            'mrdno' => 'Mrdno',
            'acc_editedby' => 'Acc Editedby',
            'acc_updatedatetime' => 'Acc Updatedatetime',
            'restore' => 'Restore',
            'flag' => 'Flag',
            'refund_initiatedby' => 'Refund Initiatedby',
            'refund_initiateddate' => 'Refund Initiateddate',
            'refund_approvedby' => 'Refund Approvedby',
            'refund_approveddate' => 'Refund Approveddate',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ConsultationLabQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ConsultationLabQuery(get_called_class());
    }
}
