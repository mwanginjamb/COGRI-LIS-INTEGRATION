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

                if(!is_string($result))
                {                    
                   $this->flag($customer['auto_number']);
                }/*else
                {
                    print '<br/> Error....'.$result;
                }*/
            
           
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

                if(is_object($result))
                {                    
                    '<br /> Success: '.var_dump($this->flag($customer['auto_number']));
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

        $customers = ConsultationLab::find()
        ->where(['NOT',['accountcode' => '']])
        ->andWhere(['NOT IN','accountcode', $list])
        ->andWhere(['flag' => 0])
        ->limit($threshold)
       // ->orderBy('auto_number ASC')
        ->asArray()
        ->all();

    
        return json_encode($customers);

    }




    /*Get Invoiceable Custoners */



    public function actionInvoiceableCustomers($threshold = 50)
    {


        $customers = ConsultationLab::find()
        ->where(['NOT',['accountcode' => '']])
        //->andWhere(['NOT IN','accountcode', $list])
        ->andWhere(['flag' => 1])
        ->andWhere(['Invoiced' => 0])
        ->limit($threshold)
       // ->orderBy('auto_number ASC')
        ->asArray()
        ->all();

    
        return json_encode($customers);

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



/*Flag posted entries*/
    public function flag($auto_number)
    {


       $connection = Yii::$app->db;

       $result = $connection->createCommand()
        ->update('consultation_lab',['flag' => 1], 'auto_number = '.$auto_number)
        ->execute();


        var_dump($result);
       

    }

    public function actionFlagged()
    {

        $model = ConsultationLab::find()
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

         foreach($result as $r)
         {
            $nos[] = $r->No; 
         }

         $Nos = array_values($nos);

        return json_encode($Nos);
    }

    public function actionGenerateInvoice()
    {
            /*@challenge what do we do with records without patientcode or accountcode --> walkins? */
        $service = Yii::$app->params['ServiceName']['CreateInvoicePortal'];

        //Get LIS customers

        $customers = $this->actionInvoiceableCustomers(5);

        // convert json to php object

        $transformedCustomers = json_decode($customers);

        // Loop through the transformedCustomers array of objects creating a Nav Payload
        $navArgs = [];
        $i = 0;

       
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
                                'testrate' => $tcus->testrate
                            ];    
                
        }



       
        // INVOICE IN NAV
        foreach($navArgs as $customer)
        {

             /*print '<pre>';
        print_r($customer['No']);
        exit;*/


            // Header Arguments
            $CuArgs = [
                'custNoa46' => $customer['No'],
                'programH' => 'NDL',
                'departmentH' => 'LAB-002'
            ];

            // Create Invoice Header IanCreateInvoiceH

            $result = Yii::$app->navhelper->Cogri($service, $CuArgs,'IanCreateInvoiceH');

            print "<br />".var_dump($result);

            if(!empty($result['return_value']) && is_string($result['return_value']))
            {
                 /* Create Invoice Lines*/

                    // Mark Cusultation as invoiced
                    $this->invoice($customer['auto_number']);

                        // Lines Arguments

                         $LineArgs = [
                            'invNo' => $result['return_value'],
                            'categoryL' => 'TEST', //$customer['testcode'],
                            'quantityL' => 1,
                            'unitpriceL' => $customer['testrate'],
                            'programH' => 'NDL',
                            'departmentH' => 'LAB-002'

                        ];

                        // Invoke code Unit Function

                       $lineResult =  Yii::$app->navhelper->Cogri($service, $LineArgs, 'IanCreateInvoiceL' );

                       





                    // Post Invoice

                     $postingArgs= [
                        'inv1' => $result['return_value']
                     ];

                     $postingResult = Yii::$app->navhelper->Cogri($service, $postingArgs, 'IanPostInvoice' );


                     print "<br />".var_dump($postingResult);

            }
            
           
           sleep(1); // Add some latency 
        }
        
    }


}
