<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ConsultationLab;
use app\models\MasterAccountdetails;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCustomers()
    {
        $service = Yii::$app->params['ServiceName']['CustomerPortal'];

        $data = Yii::$app->navhelper->getData($service, []);

        return count($data);
    }

    public function actionCreateCustomer()
    {

        /*@challenge what do we do with records without patientcode or accountcode --> walkins? */
        $service = Yii::$app->params['ServiceName']['CustomerPortal'];

        //Get LIS customers

        $customers = $this->actionLisCustomers(5);

        // convert json to php object

        $transformedCustomers = json_decode($customers);

        /* print '<pre>';
        print_r($transformedCustomers);
        exit;*/

        // Loop through the transformedCustomers array of objects creating a Nav Payload
        $navArgs = [];
        $i = 0;

        /*print '<pre>';
        print_r($transformedCustomers);
        exit;*/
        foreach ($transformedCustomers as $tcus) {

            ++$i;
            $navArgs[$i] = [
                'No'                        => $tcus->accountcode,
                'Name'                      => $tcus->accountname,
                'Search_Name'               => $tcus->accountname,
                'Customer_Posting_Group'    => 'Credit',
                'VAT_Bus_Posting_Group'     => 'LOCAL',
                'Gen_Bus_Posting_Group'     => 'LOCAL',
                'auto_number'               => $tcus->auto_number
            ];
        }




        // INSERT INTO NAV
        foreach ($navArgs as $customer) {

            $result = Yii::$app->navhelper->postData($service, $customer);
            $log = print_r($result, true);
            $this->logger($log, 'Customer');

            if (!is_string($result)) {
                // $this->flag($customer['auto_number']);
            } else {
                print '<br/> Error....' . $result;
            }


            sleep(1); // Add some latency 
        }
    }




    // Create walking customers - no accountcode or patientcode use invno


    public function actionCreateWalkinCustomer()
    {

        /*@challenge what do we do with records without patientcode or accountcode --> walkins? use invno for No IN Navision */
        $service = Yii::$app->params['ServiceName']['CustomerPortal'];

        //Get LIS customers

        $customers = $this->actionLisWalkinCustomers(5);

        // convert json to php object

        $transformedCustomers = json_decode($customers);

        // Loop through the transformedCustomers array of objects creating a Nav Payload
        $navArgs = [];
        $i = 0;


        /*print '<pre>';
        print_r($customers);
        exit;*/
        foreach ($transformedCustomers as $tcus) {

            ++$i;
            $navArgs[$i] = [
                'No'                        => $tcus->invno,
                'Name'                      => $tcus->patientname,
                'Search_Name'               => $tcus->patientname,
                'Customer_Posting_Group'    => 'Credit',
                'VAT_Bus_Posting_Group'     => 'LOCAL',
                'Gen_Bus_Posting_Group'     => 'LOCAL',
                'auto_number'               => $tcus->auto_number
            ];
        }




        // INSERT INTO NAV
        foreach ($navArgs as $customer) {

            $result = Yii::$app->navhelper->postData($service, $customer);


            $log = print_r($result, true);
            $this->logger($log, 'Customer');

            if (is_object($result)) {
                // Flag as created 
                $flag =  $this->flag($customer['auto_number']);
                '<br /> Success: ' . var_dump($flag);

                $log = print_r($flag, true);
                $this->logger($log, 'Customer');
            } else {
                print '<br/> Error....' . $result;
            }


            // sleep(1); // Add some latency 
        }
    }

    // Get LIS customers

    public function actionLisCustomers($threshold = 50)
    {


        $Imported = $this->actionImported();
        $list = json_decode($Imported, true);

        $customers = MasterAccountdetails::find()
            ->where(['NOT', ['accountcode' => '']])
            ->andWhere(['NOT IN', 'accountcode', $list])
            // ->andWhere(['flag' => 0]) --Pending Update Permissions 
            ->limit($threshold)
            // ->orderBy('auto_number ASC')
            ->asArray()
            ->all();


        return json_encode($customers);
    }




    /*Get Invoiceable Custoners */



    public function actionInvoiceableCustomers($threshold = 25)
    {


        $customers = ConsultationLab::find()
            ->where(['NOT', ['accountcode' => '']])
            ->andWhere(['>', 'billdatetime', '2022-01-01 00:00:00'])
            //->andWhere(['<', 'billdatetime', '2022-06-31 23:59:00'])
            ->andWhere(['>', 'testrate', 0])
            ->andWhere(['Invoiced' => 0])
            ->limit($threshold)
            ->orderBy('auto_number ASC')
            ->asArray()
            ->all();


        return json_encode($customers);
    }


    // Invoiced customers

    public function actionInvoicedCustomers($threshold = 25)
    {


        $customers = ConsultationLab::find()
            ->where(['NOT', ['accountcode' => '']])
            ->andWhere(['>', 'billdatetime', '2022-01-01 00:00:00'])
            ->andWhere(['<', 'billdatetime', '2022-06-31 23:59:00'])
            ->andWhere(['>', 'testrate', 0])
            ->andWhere(['Invoiced' => 1])
            ->limit($threshold)
            ->orderBy('auto_number ASC')
            ->asArray()
            ->all();


        return json_encode($customers);
    }





    /*Get unposted Refunds - Processed for Posting*/

    public function actionUnpostedmemos($threshold = 25)
    {

        //@property string $labrefund
        //@property string $refundapprove = 'Approved'

        $customers = ConsultationLab::find()
            ->where(['refundapprove' => 'Approved'])
            ->andWhere(['>', 'billdatetime', '2022-01-01 00:00:00'])
            // ->andWhere(['<', 'billdatetime', '2022-06-31 23:59:00'])
            ->andWhere(['refund_flag' => 0])
            ->andWhere(['labrefund' => 'refund'])
            ->limit($threshold)
            ->orderBy('auto_number ASC')
            ->asArray()
            ->all();


        return json_encode($customers);
    }



    /*Generated Credit Memo*/


    public function actionGenerateCreditMemo()
    {
        $service = Yii::$app->params['ServiceName']['LISCreditmemo'];
        //Get LIS customers
        $customers = $this->actionunpostedmemos();
        // convert json to php object
        $transformedCustomers = json_decode($customers);
        // print '<pre>'; print_r($transformedCustomers); exit;
        // Loop through the transformedCustomers array of objects creating a Nav Payload
        $navArgs = [];
        $i = 0;


        foreach ($transformedCustomers as $tcus) {

            ++$i;
            $navArgs[$i] = [
                'LIS_Document_No' => $tcus->invno,
                'CreditNoteNo' => $tcus->docno,
                'Quantity' => 0.0,
                'Category'     => $tcus->categoryname,
                'Entry_No' => $tcus->auto_number,
                'CustomeNo' => $tcus->accountcode,
                'TestCode' => $tcus->testcode,
                'LineAmount' => $tcus->testrate,
                'InvoiceDate' => date('Y-m-d', strtotime($tcus->billdatetime)),
                'Description' =>  $tcus->testname . ' - ' . $tcus->docno . ' - ' . $tcus->patientname,
                'DiscountAmount' => $tcus->testrate, //$tcus->discountper_item, //$tcus->discountamount,
                'EmployeeNo' => $tcus->employeeno, //file_no
            ];
        }




        // Do credit memo
        if (!count($navArgs)) {
            echo 'No Credit Memo to Record ';
            $this->logger('NO records to Commit..', 'Memo');
            exit();
        }
        foreach ($navArgs as $memo) {

            $result = Yii::$app->navhelper->postData($service, $memo);

            print '<pre>';
            echo 'Credit Memo Record Committed ...............';
            print_r($result);

            echo 'Nav Payload <br>';
            print_r($result);

            $log = print_r($result, true);
            $this->logger($log, 'Memo');

            if (is_object($result) && $result->Key) {

                $flag =  $this->refund($memo['Entry_No']);
                echo 'Memo Record Flagged as refunded...............';

                print_r($flag);

                $log = print_r($flag, true);
                $this->logger($log, 'Memo');
            } else {
                print 'Attempt to reflag this refund record: ' . $memo['Entry_No'] . '<br />';
                $flag =  $this->refund($memo['Entry_No']);
                echo 'Invoice............... <br />';

                var_dump($flag);

                $log = print_r('Attempt to reflag this refund record: ' . $memo['Entry_No'] . '<br />', true);
                $this->logger($log, 'Memo');
            }


            sleep(2); // Add some latency  

        }
    }




    /*Metrics - Unposted  refunds*/


    public function actionMetricsunpostedmemos($threshold = 300)
    {


        $customers = ConsultationLab::find()
            ->where(['refundapprove' => 'Approved'])
            ->andWhere(['>', 'billdatetime', '2022-02-06 00:00:00'])
            ->andWhere(['refund_flag' => 0])
            // ->limit($threshold)
            ->orderBy('auto_number ASC')
            ->asArray()
            ->all();


        return 'Unposted refunds are :' . count($customers);
    }


    /*Metrics - Posted Refunds*/


    public function actionMetricspostedmemos($threshold = 100)
    {


        $refunds = ConsultationLab::find()
            ->where(['refundapprove' => 'Approved'])
            ->andWhere(['>', 'billdatetime', '2022-02-06 00:00:00'])
            ->andWhere(['refund_flag' => 1])
            // ->limit($threshold)
            ->orderBy('auto_number ASC')
            ->asArray()
            ->all();


        return 'Posted refunds are :' . count($refunds);
    }



    /*Get walkin customers --> cystomer no is invno*/

    public function actionLisWalkinCustomers($threshold = 1)
    {


        $Imported = $this->actionImported();
        $list = json_decode($Imported, true);

        //return $list;

        $customers = ConsultationLab::find()
            ->where(['NOT IN', 'invno', $list])
            ->andWhere(['accountcode' => ''])
            ->andWhere(['flag' =>  0])
            ->limit($threshold)
            // ->orderBy('auto_number ASC')
            ->asArray()
            ->all();


        return json_encode($customers);
    }





    /*Reset All flagged entries*/

    public function actionDeflag()
    {
        $connection = Yii::$app->db;

        $result = $connection->createCommand()
            ->update('consultation_lab', ['Invoiced' => 0], 'Invoiced > 0')
            ->execute();
        var_dump($result);
    }

    public function actionDememo()
    {
        $connection = Yii::$app->db;
        $result = $connection->createCommand()
            ->update('consultation_lab', ['refund_flag' => 0], 'refund_flag > 0')
            ->execute();

        var_dump($result);
    }


    /*De Invoice*/

    public function actionDeinvoice()
    {
        $connection = Yii::$app->db;

        $result = $connection->createCommand()
            ->update('consultation_lab', ['Invoiced' => 0], 'Invoiced > 0')
            ->execute();


        var_dump($result);
    }



    /*Flag posted entries*/
    public function flag($auto_number)
    {


        $connection = Yii::$app->db;

        $result = $connection->createCommand()
            ->update('consultation_lab', ['Invoiced' => 1], 'auto_number = ' . $auto_number)
            ->execute();


        print 'Flagged record with auto no: ' . $auto_number . '<br />';
        var_dump($result);
    }

    public function actionFlagged()
    {

        $model = ConsultationLab::find()
            ->where(['Invoiced' => 1])
            ->count();

        print '<Pre>';
        print_r($model);
    }

    /*Mark as invoiced*/
    public function Invoice($auto_number)
    {


        $connection = Yii::$app->db;

        $result = $connection->createCommand()
            ->update('consultation_lab', ['Invoiced' => 1], 'auto_number = ' . $auto_number)
            ->execute();


        return $result;
    }

    public function UnflagInvoice($auto_number)
    {


        $connection = Yii::$app->db;

        $result = $connection->createCommand()
            ->update('consultation_lab', ['Invoiced' => 0], 'auto_number = ' . $auto_number)
            ->execute();


        return $result;
    }


    /*Mark as Refunded*/
    public function refund($auto_number)
    {


        $connection = Yii::$app->db;

        $result = $connection->createCommand()
            ->update('consultation_lab', ['refund_flag' => 1], 'auto_number = ' . $auto_number)
            ->execute();

        return $result;
    }



    /*Get a count of all invoice entries*/

    public function actionInvoiced()
    {

        $model = ConsultationLab::find()
            ->where(['Invoiced' => 1])
            ->count();

        print '<Pre>';
        print_r($model);
    }


    public function actionImported()
    {
        $service = Yii::$app->params['ServiceName']['CustomersList'];



        $result = Yii::$app->navhelper->getData($service, []);

        $nos = [];

        if (is_array($result)) {
            foreach ($result as $r) {
                $nos[] = $r->No;
            }
        }


        $Nos = array_values($nos);

        return json_encode($Nos);
    }

    public function actionGenerateInvoice()
    {

        $service = Yii::$app->params['ServiceName']['LISInvoices'];

        //Get LIS customers

        $customers = $this->actionInvoiceableCustomers();

        // convert json to php object

        $transformedCustomers = json_decode($customers);
        //print '<pre>'; print_r($transformedCustomers); exit;

        // Loop through the transformedCustomers array of objects creating a Nav Payload
        $navArgs = [];
        $i = 0;

        // from Nov 2021 use "discountper_item"
        foreach ($transformedCustomers as $tcus) {

            ++$i;
            $navArgs[$i] = [
                'InvoiceNo' => $tcus->invno,

                'LIS_Document_No' => $tcus->docno,
                'Quantity' => 0.0,
                'Category'     => $tcus->categoryname,
                'Entry_No' => $tcus->auto_number,
                'CustomeNo' => $tcus->accountcode,
                'TestCode' => $tcus->testcode,
                'LineAmount' => $tcus->testrate,
                'InvoiceDate' => date('Y-m-d', strtotime($tcus->billdatetime)),
                'Description' =>  $tcus->testname . ' - ' . $tcus->docno . ' - ' . $tcus->patientname,
                'DiscountAmount' => $tcus->discountper_item,
                'EmployeeNo' => $tcus->employeeno, //file_no
            ];
        }

        // INVOICE IN NAV
        foreach ($navArgs as $customer) {

            $result = Yii::$app->navhelper->postData($service, $customer);
            $InvoiceLog =  $result;
            $log = print_r($InvoiceLog, true);
            $this->logger($log, 'Invoice');

            if (is_object($result) && $result->Key) {
                $flag =  $this->Invoice($customer['Entry_No']);
                $log = print_r("Mysql Result -Attempting to mark a transaction as invoiced - : " . $flag . ' Transaction: ' . $customer['Entry_No'] . "\n", true);
                $this->logger($log, 'Invoice');
                if ($flag !== 1) { // MYSQL ERROR CHECKING
                    $flag =  $this->UnflagInvoice($customer['Entry_No']);
                    $this->logger('Error Invoice ...' . "\n", 'Invoice');
                    $this->logger($result, 'Invoice');
                    $log = print_r('Attempted to unflag the record: ' . $customer['Entry_No'] . "\n", true);
                    $this->logger($log, 'Invoice');
                }
            } else { //CASE FOR ALREADY EXISTING RECORS IN ERP
                $flag =  $this->Invoice($customer['Entry_No']);
                if ($flag !== 1) { // MYSQL ERROR CHECKING
                    $flag =  $this->UnflagInvoice($customer['Entry_No']);
                    $this->logger('Error Invoice ...' . "\n", 'Invoice');
                    $this->logger($result . "\n", 'Invoice');
                    $log = print_r('Attempted to unflag the record: ' . $customer['Entry_No'] . "\n", true);
                    $this->logger($log, 'Invoice');
                }
                $log = print_r("Flagged Existing transaction as invoiced - : " . $flag . ' Transaction: ' . $customer['Entry_No'] . "\n", true);
                $this->logger($log, 'Invoice');
            }


            sleep(5); // Add some latency 
            // exit;
        }
    }

    private function logger($message, $type)
    {
        if ($type == 'Invoice') {
            $filename = 'log/invoice.txt';
        } elseif ($type == 'Memo') {
            $filename = 'log/memo.txt';
        } elseif ($type == 'Customer') {
            $filename = 'log/Customer.txt';
        }

        $req_dump = print_r($message, TRUE);
        $fp = fopen($filename, 'a');
        fwrite($fp, $req_dump);
        fclose($fp);
    }
}
