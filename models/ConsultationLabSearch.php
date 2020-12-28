<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ConsultationLab;

/**
 * ConsultationLabSearch represents the model behind the search form of `app\models\ConsultationLab`.
 */
class ConsultationLabSearch extends ConsultationLab
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auto_number', 'printorder', 'batchnumber', 'restore', 'flag'], 'integer'],
            [['patientname', 'patientcode', 'accountname', 'accountcode', 'gender', 'age', 'agegroup', 'dateofbirth', 'typeofpatient', 'doctor', 'accountho', 'desprepotno', 'testname', 'categoryname', 'testcode', 'urgent', 'invno', 'docno', 'sampledocno', 'labsamplecoll', 'labrefund', 'refundapprove', 'paymentmode', 'ipaddress', 'username', 'storename', 'storecode', 'locationname', 'locationcode', 'consultationdate', 'consultationtime', 'samplecollectedon', 'resultentry', 'resultdoc', 'publishstatus', 'cashrecd', 'balamount', 'bankname', 'cardno', 'mpesano', 'chequebankname', 'chequeno', 'chequedate', 'labrefundstatus', 'billdatetime', 'status', 'originalstatus', 'mrdno', 'acc_editedby', 'acc_updatedatetime', 'refund_initiatedby', 'refund_initiateddate', 'refund_approvedby', 'refund_approveddate'], 'safe'],
            [['testrate', 'totalamount', 'discountpercent', 'discountamount', 'subtotal', 'mpesaamount', 'cardamount', 'cashamount', 'chequeamount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ConsultationLab::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'auto_number' => $this->auto_number,
            'dateofbirth' => $this->dateofbirth,
            'testrate' => $this->testrate,
            'totalamount' => $this->totalamount,
            'discountpercent' => $this->discountpercent,
            'discountamount' => $this->discountamount,
            'subtotal' => $this->subtotal,
            'consultationdate' => $this->consultationdate,
            'consultationtime' => $this->consultationtime,
            'samplecollectedon' => $this->samplecollectedon,
            'mpesaamount' => $this->mpesaamount,
            'cardamount' => $this->cardamount,
            'cashamount' => $this->cashamount,
            'chequeamount' => $this->chequeamount,
            'chequedate' => $this->chequedate,
            'billdatetime' => $this->billdatetime,
            'printorder' => $this->printorder,
            'batchnumber' => $this->batchnumber,
            'acc_updatedatetime' => $this->acc_updatedatetime,
            'restore' => $this->restore,
            'flag' => $this->flag,
            'refund_initiateddate' => $this->refund_initiateddate,
            'refund_approveddate' => $this->refund_approveddate,
        ]);

        $query->andFilterWhere(['like', 'patientname', $this->patientname])
            ->andFilterWhere(['like', 'patientcode', $this->patientcode])
            ->andFilterWhere(['like', 'accountname', $this->accountname])
            ->andFilterWhere(['like', 'accountcode', $this->accountcode])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'age', $this->age])
            ->andFilterWhere(['like', 'agegroup', $this->agegroup])
            ->andFilterWhere(['like', 'typeofpatient', $this->typeofpatient])
            ->andFilterWhere(['like', 'doctor', $this->doctor])
            ->andFilterWhere(['like', 'accountho', $this->accountho])
            ->andFilterWhere(['like', 'desprepotno', $this->desprepotno])
            ->andFilterWhere(['like', 'testname', $this->testname])
            ->andFilterWhere(['like', 'categoryname', $this->categoryname])
            ->andFilterWhere(['like', 'testcode', $this->testcode])
            ->andFilterWhere(['like', 'urgent', $this->urgent])
            ->andFilterWhere(['like', 'invno', $this->invno])
            ->andFilterWhere(['like', 'docno', $this->docno])
            ->andFilterWhere(['like', 'sampledocno', $this->sampledocno])
            ->andFilterWhere(['like', 'labsamplecoll', $this->labsamplecoll])
            ->andFilterWhere(['like', 'labrefund', $this->labrefund])
            ->andFilterWhere(['like', 'refundapprove', $this->refundapprove])
            ->andFilterWhere(['like', 'paymentmode', $this->paymentmode])
            ->andFilterWhere(['like', 'ipaddress', $this->ipaddress])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'storename', $this->storename])
            ->andFilterWhere(['like', 'storecode', $this->storecode])
            ->andFilterWhere(['like', 'locationname', $this->locationname])
            ->andFilterWhere(['like', 'locationcode', $this->locationcode])
            ->andFilterWhere(['like', 'resultentry', $this->resultentry])
            ->andFilterWhere(['like', 'resultdoc', $this->resultdoc])
            ->andFilterWhere(['like', 'publishstatus', $this->publishstatus])
            ->andFilterWhere(['like', 'cashrecd', $this->cashrecd])
            ->andFilterWhere(['like', 'balamount', $this->balamount])
            ->andFilterWhere(['like', 'bankname', $this->bankname])
            ->andFilterWhere(['like', 'cardno', $this->cardno])
            ->andFilterWhere(['like', 'mpesano', $this->mpesano])
            ->andFilterWhere(['like', 'chequebankname', $this->chequebankname])
            ->andFilterWhere(['like', 'chequeno', $this->chequeno])
            ->andFilterWhere(['like', 'labrefundstatus', $this->labrefundstatus])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'originalstatus', $this->originalstatus])
            ->andFilterWhere(['like', 'mrdno', $this->mrdno])
            ->andFilterWhere(['like', 'acc_editedby', $this->acc_editedby])
            ->andFilterWhere(['like', 'refund_initiatedby', $this->refund_initiatedby])
            ->andFilterWhere(['like', 'refund_approvedby', $this->refund_approvedby]);

        return $dataProvider;
    }
}
