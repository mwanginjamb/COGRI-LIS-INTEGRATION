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
        foreach($transformedCustomers as $tcus)
        {
          
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
        foreach($navArgs as $customer)
        {

                 $result = Yii::$app->navhelper->postData($service, $customer);
                 $log = print_r($result, true);
                 $this->logger($log,'Customer');

                if(!is_string($result))
                {                    
                   // $this->flag($customer['auto_number']);
                }else
                {
                    print '<br/> Error....'.$result;
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
        foreach($transformedCustomers as $tcus)
        {
          
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
        foreach($navArgs as $customer)
        {

                 $result = Yii::$app->navhelper->postData($service, $customer);


                 $log = print_r($result, true);
                 $this->logger($log,'Customer');

                if(is_object($result))
                {  
                    // Flag as created 
                   $flag =  $this->flag($customer['auto_number']);                  
                    '<br /> Success: '.var_dump($flag);

                    $log = print_r($flag, true);
                    $this->logger($log,'Customer');

                }else
                {
                    print '<br/> Error....'.$result;
                   
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
        ->where(['NOT',['accountcode' => '']])
        ->andWhere(['NOT IN','accountcode', $list])
        // ->andWhere(['flag' => 0]) --Pending Update Permissions 
        ->limit($threshold)
       // ->orderBy('auto_number ASC')
        ->asArray()
        ->all();

    
        return json_encode($customers);

    }




    /*Get Invoiceable Custoners */



    public function actionInvoiceableCustomers($threshold = 10)
    {


        $customers = ConsultationLab::find()
        ->where(['NOT',['accountcode' => '']])
        ->andWhere(['>','billdatetime', '2021-07-01 00:00:00'])
        ->andWhere(['>','testrate', 0])
        ->andWhere(['Invoiced' => 0])
        ->limit($threshold)
        ->orderBy('auto_number ASC')
        ->asArray()
        ->all();


    
        return json_encode($customers);

    }





    /*Get unposted Refunds - Processed for Posting*/

    public function actionUnpostedmemos($threshold = 30)
    {


        $customers = ConsultationLab::find()
        ->where(['NOT',['accountcode' => '']])
        ->andWhere(['>','billdatetime', '2021-01-01 00:00:00'])
        ->andWhere(['>','testrate', 0])
        ->andWhere(['Invoiced' => 1])
        ->andWhere(['>','totalamount', 0])
        ->andWhere(['refund_flag' => '0'])
        ->limit($threshold)
        ->orderBy('auto_number ASC')
        ->asArray()
        ->all();

    
        return json_encode($customers);

    }



    /*Generated Credit Memo*/


        public function actionGenerateCreditMemo()
    {
        
        $service = Yii::$app->params['ServiceName']['Create_Invoice_Portal'];

        //Get LIS customers

        $customers = $this->actionunpostedmemos(5);

        // convert json to php object

        $transformedCustomers = json_decode($customers);

        // print '<pre>'; print_r($transformedCustomers); exit;

        // Loop through the transformedCustomers array of objects creating a Nav Payload
        $navArgs = [];
        $i = 0;

        //print '<pre>';
        // print_r($transformedCustomers); exit;
        foreach($transformedCustomers as $tcus)
        {
          
                  ++$i;
                $navArgs[$i] = [
                                'No'                        => $tcus->accountcode,
                                'Name'                      => $tcus->accountname,
                                'Search_Name'               => $tcus->accountname,
                                'Customer_Posting_Group'    => 'Credit',
                                'VAT_Bus_Posting_Group'     => 'LOCAL',
                                'Gen_Bus_Posting_Group'     => 'LOCAL',
                                'auto_number'               => $tcus->auto_number,
                                'testcode' => $tcus->testcode,
                                'testrate' => $tcus->testrate,
                                'billdatetime' => date('Y-m-d',strtotime($tcus->billdatetime)),
                                'postingD' => $tcus->docno.' - '.$tcus->patientname,
                                'discountamount' => $tcus->discountamount,
                                'employeeN' => $tcus->file_no,
                                'totalamount' => $tcus->totalamount
                            ];    
                
        }



       
            // Do credit memo
            foreach($navArgs as $customer)
            {

                
                // Header Arguments
                $CuArgs = [
                    'custNoa46' => $customer['No'],
                    'programH' => 'NDL',
                    'departmentH' => 'LAB-001',
                    'pdate' => $customer['billdatetime'],
                    'postingD' => $customer['postingD'],
                    'employeeN' => $customer['employeeN']
                ];

                // Create credit memo Header IanCreateInvoiceH

                $result = Yii::$app->navhelper->Cogri($service, $CuArgs,'IanCreateMemoH');

                print "<br /> C. Memo Header....".var_dump($result);

                $log = print_r($result, true);
                $this->logger($log,'Memo');

                if(!empty($result['return_value']) && is_string($result['return_value']))
                {
                     /* Create Invoice Lines*/

                       

                            // Lines Arguments

                             $LineArgs = [
                                'invNo' => $result['return_value'],
                                'categoryL' => $customer['testcode'],
                                'quantityL' => 1,
                                'unitpriceL' => $customer['totalamount'], // credit memo amount - refund
                                'programH' => 'NDL',
                                'departmentH' => 'LAB-001',
                                'discountA' => $customer['discountamount'],

                            ];

                            // Invoke code Unit Line Creation Function

                           $lineResult =  Yii::$app->navhelper->Cogri($service, $LineArgs, 'IanCreateMemoL' );

                           if(is_array($lineResult) && $lineResult['return_value'] == 1) 
                           {
                                 // Mark Cusultation as Refunded
                                $this->refund($customer['auto_number']);
                           }
                            print "<br /> C .memo Line .....".var_dump($lineResult);

                            // Log C.Memo Lines commit

                            $log = print_r($lineResult, true);
                            $this->logger($log,'Memo');




                        // Post C.memo

                         $postingArgs= [
                            'inv1' => $result['return_value']
                         ];

                         $postingResult = Yii::$app->navhelper->Cogri($service, $postingArgs, 'IanPostInvoice' );


                         print "<br /> Posting .....".var_dump($postingResult);

                         $log = print_r($postingResult, true);
                         $this->logger($log,'Memo');

                }
                
               
               sleep(1); // Add some latency 
            }
            
    }




    /*Metrics - Unposted  refunds*/


    public function actionMetricsunpostedmemos($threshold = 300)
    {


        $customers = ConsultationLab::find()
        ->where(['NOT',['accountcode' => '']])
        ->andWhere(['>','billdatetime', '2021-01-01 00:00:00'])
        ->andWhere(['>','testrate', 0])
        ->andWhere(['Invoiced' => 1])
        ->andWhere(['>','totalamount', 0])
        ->andWhere(['refund_flag' => 0])
         ->limit($threshold)
        ->orderBy('auto_number ASC')
        ->asArray()
        ->all();

    
        return 'Unposted refunds are :'.count($customers);

    }


    /*Metrics - Posted Refunds*/


 public function actionMetricspostedmemos($threshold = 100)
    {


        $refunds = ConsultationLab::find()
        ->where(['NOT',['accountcode' => '']])
        ->andWhere(['>','billdatetime', '2021-01-01 00:00:00'])
        ->andWhere(['>','testrate', 0])
        ->andWhere(['Invoiced' => 1])
        ->andWhere(['>','totalamount', 0])
        ->andWhere(['refund_flag' => 1])
       // ->limit($threshold)
        ->orderBy('auto_number ASC')
        ->asArray()
        ->all();

    
        return 'Posted refunds are :'.count($refunds);

    }



/*Get walkin customers --> cystomer no is invno*/

    public function actionLisWalkinCustomers($threshold = 50)
    {


         $Imported = $this->actionImported();
         $list = json_decode($Imported, true);

         //return $list;

        $customers = ConsultationLab::find()
        ->where(['NOT IN','invno', $list])
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
        ->update('consultation_lab',['flag' => 0], 'flag > 0')
        ->execute();


        var_dump($result);
    }


/*De Invoice*/

     public function actionDeinvoice()
    {
       $connection = Yii::$app->db;

       $result = $connection->createCommand()
        ->update('consultation_lab',['Invoiced' => 0], 'Invoiced > 0')
        ->execute();


        var_dump($result);
    }



/*Flag posted entries*/
    public function flag($auto_number)
    {


       $connection = Yii::$app->db;

       $result = $connection->createCommand()
        ->update('master_accountdetails',['flag' => 1], 'auto_number = '.$auto_number)
        ->execute();


        var_dump($result);
       

    }

    public function actionFlagged()
    {

        $model = MasterAccountdetails::find()
        ->where(['flag' => 1])
        ->count();

        print '<Pre>';
        print_r($model);
       
    }

/*Mark as invoiced*/
     public function Invoice($auto_number)
    {


       $connection = Yii::$app->db;

       $result = $connection->createCommand()
        ->update('consultation_lab',['Invoiced' => 1], 'auto_number = '.$auto_number)
        ->execute();


       // var_dump($result);
       

    }


    /*Mark as Refunded*/
     public function refund($auto_number)
    {


       $connection = Yii::$app->db;

       $result = $connection->createCommand()
        ->update('consultation_lab',['refund_flag' => 1], 'auto_number = '.$auto_number)
        ->execute();

       /* $model = ConsultationLab::findOne(['auto_number' => $auto_number]);
        $model->refund_flag = 1;
        $model->save(false);*/



       // var_dump($result);
       

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

        if(is_array($result))
        {
            foreach($result as $r)
                 {
                    $nos[] = $r->No; 
                 }
        }
         

         $Nos = array_values($nos);

        return json_encode($Nos);
    }

    public function actionGenerateInvoice()
    {
         // return 1;
            /*@challenge what do we do with records without patientcode or accountcode --> walkins? */
       $service = Yii::$app->params['ServiceName']['Create_Invoice_Portal'];
       $PageService = Yii::$app->params['ServiceName']['SaleInvPortal'];

        //Get LIS customers

        $customers = $this->actionInvoiceableCustomers(5);

        // convert json to php object

        $transformedCustomers = json_decode($customers);

       // print '<pre>'; print_r($transformedCustomers); exit;

        // Loop through the transformedCustomers array of objects creating a Nav Payload
        $navArgs = [];
        $i = 0;

        //print '<pre>';
        // print_r($transformedCustomers); exit;
        foreach($transformedCustomers as $tcus)
        {
          
                  ++$i;
                $navArgs[$i] = [
                                'No'                        => $tcus->accountcode,
                                'Name'                      => $tcus->accountname,
                                'Search_Name'               => $tcus->accountname,
                                'Customer_Posting_Group'    => 'Credit',
                                'VAT_Bus_Posting_Group'     => 'LOCAL',
                                'Gen_Bus_Posting_Group'     => 'LOCAL',
                                'auto_number'               => $tcus->auto_number,
                                'testcode' => $tcus->testcode,
                                'testrate' => $tcus->testrate,
                                'billdatetime' => date('Y-m-d',strtotime($tcus->billdatetime)),
                                'postingD' =>  $tcus->docno.' - '.$tcus->patientname,
                                'discountamount' => $tcus->discountamount,
                                'employeeN' => $tcus->employeeno, //file_no
                            ];    
                
        }



       
            // INVOICE IN NAV
            foreach($navArgs as $customer)
            {

                
                // Header Arguments for Page Service

                $PageArgs = [
                    'Sell_to_Customer_No' => $customer['No'],
                    'Shortcut_Dimension_1_Code' => 'NDL',
                    'Shortcut_Dimension_2_Code' => 'LAB-001',
                    'Posting_Date' => $customer['billdatetime'],
                    'Posting_Description' => $customer['postingD'],
                    'Employee_No' => $customer['employeeN']
                ];

                 // Header Arguments for Codeunit Service
                $CuArgs = [
                    'custNoa46' => $customer['No'],
                    'programH' => 'NDL',
                    'departmentH' => 'LAB-001',
                    'pdate' => $customer['billdatetime'],
                    'postingD' => $customer['postingD'],
                    'employeeN' => $customer['employeeN']
                ];

                // Create Invoice Header IanCreateInvoiceH

               // $result = Yii::$app->navhelper->Cogri($service, $CuArgs,'IanCreateInvoiceH');
                $result = Yii::$app->navhelper->postData($PageService,$PageArgs);
               
                $InvoiceLog =  $result;
                $log = print_r($InvoiceLog, true);
                // Log this as an Invoice
                $this->logger($log,'Invoice');

                if(is_object($result) && $result->No)
                {
                    echo 'Posting...............'.$result->No;
                     /* Create Invoice Lines*/

                            // Lines Arguments

                             $LineArgs = [
                                'invNo' => $result->No,
                                'categoryL' => $customer['testcode'],
                                'quantityL' => 1,
                                'unitpriceL' => $customer['testrate'],
                                'programH' => 'NDL',
                                'departmentH' => 'LAB-001',
                                'discountA' => $customer['discountamount']

                            ];

                            $this->logger('Line To Commit ........', 'Invoice');

                            $this->logger($LineArgs, 'Invoice');

                            // Invoke code Unit Line Creation Function

                           $lineResult =  Yii::$app->navhelper->Cogri($service, $LineArgs, 'IanCreateInvoiceL' );

                           
                           if(is_array($lineResult) && $lineResult['return_value'] == 1) 
                           {
                                 // Mark Cusultation as invoiced
                                $this->invoice($customer['auto_number']);
                           }

                            // Log Invoice Lines
                            $log = print_r($lineResult, true);
                            $this->logger($log, 'Invoice');




                        // Post Invoice

                         $postingArgs= [
                            'inv1' => $result->No 
                         ];

                         $postingResult = Yii::$app->navhelper->Cogri($service, $postingArgs, 'IanPostInvoice' );


                         $postingLog =  $postingResult;

                         // Log Invoice Posting Results

                         $log = print_r($postingLog , true);
                         $this->logger($log,'Invoice');

                }
                
               
               sleep(2); // Add some latency 
              // exit;
            }
            
    }

    private function logger($message, $type)
	{
        if($type == 'Invoice')
        {
            $filename = 'log/invoice.txt';
        }
        elseif($type == 'Memo') 
        {
            $filename = 'log/memo.txt';
        }
        elseif($type == 'Customer') 
        {
            $filename = 'log/Customer.txt';
        }
		
		$req_dump = print_r($message, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
	}


}
