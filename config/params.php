<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'NavisionUsername' => 'iansoft',
    'NavisionPassword' => 'Password12345',

    'server'=>'167.86.83.32', //'167.86.95.19',//'app-svr-dev.rbss.com',//Navision Server
    'WebServicePort'=>'7047',//Nav server Port
    'ServerInstance'=>'BC140',//Nav Server Instance
    'CompanyName'=> 'COGRI', //'COGRI',//Nav Company,

    'IvanPwd' => 'COGRIndl@2016.',



    'codeUnits' => [
        //'CreateInvoicePortal',
        'Create_Invoice_Portal'
    ],


    'ServiceName' => [
    	'CustomerPortal' => 'CustomerPortal',
        'CustomersList' =>  'CustomersList',
        'Create_Invoice_Portal' => 'Create_Invoice_Portal',
        'SaleInvPortal' => 'SaleInvPortal',
        'LISInvoices' => 'LISInvoices', // uSE THIS TO SEND invoice entries to Nav
        'LISCreditmemo' => 'LISCreditmemo', // uSE this for credit memo
    ],
];
