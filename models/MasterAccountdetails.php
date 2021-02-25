<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_accountdetails".
 *
 * @property int $auto_number
 * @property string $accountcode
 * @property string $accountname
 * @property string $address1
 * @property string $address2
 * @property string $area
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $pincode
 * @property string $phonenumber1
 * @property string $phonenumber2
 * @property string $mobilenumber
 * @property string $emailid1
 * @property string $emailid2
 * @property string $accountho
 * @property float $discountpercent
 * @property string $status
 * @property string $username
 * @property string $dateposted
 * @property string $ipaddress
 * @property string $locationcode
 * @property string $locationname
 * @property int $flag
 */
class MasterAccountdetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_accountdetails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accountcode', 'accountname', 'address1', 'address2', 'area', 'city', 'state', 'country', 'pincode', 'phonenumber1', 'phonenumber2', 'mobilenumber', 'emailid1', 'emailid2', 'accountho', 'discountpercent', 'status', 'username', 'dateposted', 'ipaddress', 'locationcode', 'locationname'], 'required'],
            [['discountpercent'], 'number'],
            [['dateposted'], 'safe'],
            [['flag'], 'integer'],
            [['accountcode', 'accountname', 'address1', 'address2', 'area', 'city', 'state', 'country', 'pincode', 'phonenumber1', 'phonenumber2', 'mobilenumber', 'emailid1', 'emailid2', 'accountho', 'status', 'username', 'ipaddress', 'locationcode', 'locationname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auto_number' => 'Auto Number',
            'accountcode' => 'Accountcode',
            'accountname' => 'Accountname',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'area' => 'Area',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'pincode' => 'Pincode',
            'phonenumber1' => 'Phonenumber1',
            'phonenumber2' => 'Phonenumber2',
            'mobilenumber' => 'Mobilenumber',
            'emailid1' => 'Emailid1',
            'emailid2' => 'Emailid2',
            'accountho' => 'Accountho',
            'discountpercent' => 'Discountpercent',
            'status' => 'Status',
            'username' => 'Username',
            'dateposted' => 'Dateposted',
            'ipaddress' => 'Ipaddress',
            'locationcode' => 'Locationcode',
            'locationname' => 'Locationname',
            'flag' => 'Flag',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\MasterAccountdetailsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\MasterAccountdetailsQuery(get_called_class());
    }
}
