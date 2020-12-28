<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_customer".
 *
 * @property int $auto_number
 * @property string $customercode
 * @property string $customername
 * @property string $customermiddlename
 * @property string $customerlastname
 * @property string $customerfullname
 * @property string $gender
 * @property string $mothername
 * @property string $age
 * @property string $typeofcustomer
 * @property string $address1
 * @property string $address2
 * @property string $area
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $pincode
 * @property string $phonenumber1
 * @property string $phonenumber2
 * @property string $faxnumber
 * @property string $mobilenumber
 * @property string $emailid1
 * @property string $emailid2
 * @property string $tinnumber
 * @property string $cstnumber
 * @property float $openingbalance
 * @property string $remarks
 * @property string $status
 * @property string $dateposted
 * @property string $insuranceid
 * @property string $photoavailable
 * @property string $nameofrelative
 * @property string $dateofbirth
 * @property string $maritalstatus
 * @property string $consultingdoctor
 * @property string $bloodgroup
 * @property string $registrationdate
 * @property string $registrationtime
 * @property string $occupation
 * @property string $nationalidnumber
 * @property string $ageduration
 * @property string $salutation
 * @property string $kinname
 * @property string $kincontactnumber
 * @property string $currentregimen
 * @property string $artdate
 * @property string $justification
 * @property string $billtype
 * @property string $accountname
 * @property string $planname
 * @property string $planvaliditystart
 * @property string $planvalidityend
 * @property string $planid
 * @property int $visitlimit
 * @property string $maintype
 * @property string $subtype
 * @property string $accountexpirydate
 * @property string $planexpirydate
 * @property string $accountho
 * @property float $planfixedamount
 * @property float $planpercentage
 * @property string $mrdno
 * @property string $fileno
 * @property string $promotion
 * @property string $username
 * @property string $locationcode
 * @property string $locationname
 */
class MasterCustomer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customercode', 'customername', 'customermiddlename', 'customerlastname', 'customerfullname', 'gender', 'mothername', 'age', 'typeofcustomer', 'address1', 'address2', 'area', 'city', 'state', 'country', 'pincode', 'phonenumber1', 'phonenumber2', 'faxnumber', 'mobilenumber', 'emailid1', 'emailid2', 'tinnumber', 'cstnumber', 'openingbalance', 'remarks', 'status', 'insuranceid', 'photoavailable', 'nameofrelative', 'dateofbirth', 'maritalstatus', 'consultingdoctor', 'bloodgroup', 'registrationdate', 'registrationtime', 'occupation', 'nationalidnumber', 'ageduration', 'salutation', 'kinname', 'kincontactnumber', 'currentregimen', 'artdate', 'justification', 'billtype', 'accountname', 'planname', 'planvaliditystart', 'planvalidityend', 'planid', 'visitlimit', 'maintype', 'subtype', 'accountexpirydate', 'planexpirydate', 'accountho', 'planfixedamount', 'planpercentage', 'mrdno', 'fileno', 'promotion', 'username', 'locationcode', 'locationname'], 'required'],
            [['openingbalance', 'planfixedamount', 'planpercentage'], 'number'],
            [['dateposted', 'registrationdate', 'planvaliditystart', 'planvalidityend', 'accountexpirydate', 'planexpirydate'], 'safe'],
            [['visitlimit'], 'integer'],
            [['customercode', 'customername', 'customermiddlename', 'customerlastname', 'customerfullname', 'gender', 'age', 'typeofcustomer', 'address1', 'address2', 'area', 'city', 'state', 'country', 'pincode', 'phonenumber1', 'phonenumber2', 'faxnumber', 'mobilenumber', 'emailid1', 'emailid2', 'tinnumber', 'cstnumber', 'remarks', 'status', 'insuranceid', 'photoavailable', 'nameofrelative', 'dateofbirth', 'maritalstatus', 'consultingdoctor', 'bloodgroup', 'registrationtime', 'occupation', 'nationalidnumber', 'ageduration', 'salutation', 'kinname', 'kincontactnumber', 'currentregimen', 'artdate', 'justification', 'billtype', 'accountname', 'planname', 'planid', 'maintype', 'subtype', 'accountho', 'mrdno', 'fileno', 'promotion', 'username', 'locationcode', 'locationname'], 'string', 'max' => 255],
            [['mothername'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auto_number' => 'Auto Number',
            'customercode' => 'Customercode',
            'customername' => 'Customername',
            'customermiddlename' => 'Customermiddlename',
            'customerlastname' => 'Customerlastname',
            'customerfullname' => 'Customerfullname',
            'gender' => 'Gender',
            'mothername' => 'Mothername',
            'age' => 'Age',
            'typeofcustomer' => 'Typeofcustomer',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'area' => 'Area',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'pincode' => 'Pincode',
            'phonenumber1' => 'Phonenumber1',
            'phonenumber2' => 'Phonenumber2',
            'faxnumber' => 'Faxnumber',
            'mobilenumber' => 'Mobilenumber',
            'emailid1' => 'Emailid1',
            'emailid2' => 'Emailid2',
            'tinnumber' => 'Tinnumber',
            'cstnumber' => 'Cstnumber',
            'openingbalance' => 'Openingbalance',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'dateposted' => 'Dateposted',
            'insuranceid' => 'Insuranceid',
            'photoavailable' => 'Photoavailable',
            'nameofrelative' => 'Nameofrelative',
            'dateofbirth' => 'Dateofbirth',
            'maritalstatus' => 'Maritalstatus',
            'consultingdoctor' => 'Consultingdoctor',
            'bloodgroup' => 'Bloodgroup',
            'registrationdate' => 'Registrationdate',
            'registrationtime' => 'Registrationtime',
            'occupation' => 'Occupation',
            'nationalidnumber' => 'Nationalidnumber',
            'ageduration' => 'Ageduration',
            'salutation' => 'Salutation',
            'kinname' => 'Kinname',
            'kincontactnumber' => 'Kincontactnumber',
            'currentregimen' => 'Currentregimen',
            'artdate' => 'Artdate',
            'justification' => 'Justification',
            'billtype' => 'Billtype',
            'accountname' => 'Accountname',
            'planname' => 'Planname',
            'planvaliditystart' => 'Planvaliditystart',
            'planvalidityend' => 'Planvalidityend',
            'planid' => 'Planid',
            'visitlimit' => 'Visitlimit',
            'maintype' => 'Maintype',
            'subtype' => 'Subtype',
            'accountexpirydate' => 'Accountexpirydate',
            'planexpirydate' => 'Planexpirydate',
            'accountho' => 'Accountho',
            'planfixedamount' => 'Planfixedamount',
            'planpercentage' => 'Planpercentage',
            'mrdno' => 'Mrdno',
            'fileno' => 'Fileno',
            'promotion' => 'Promotion',
            'username' => 'Username',
            'locationcode' => 'Locationcode',
            'locationname' => 'Locationname',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\MasterCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\MasterCustomerQuery(get_called_class());
    }
}
