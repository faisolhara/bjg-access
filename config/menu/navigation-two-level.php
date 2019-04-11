<?php

return  
[
    [
    'label'     => 'Purchasing',
    'icon'      => 'mdi mdi-database',
    'children'  => 
        [
            [
            'label'     => 'My Requisition',
            'route'     => 'purchasing/my-requisition',
            'resource'  => 'Purchasing\MyRequisition',
            ],
            [
            'label'     => 'PO Monitoring',
            'route'     => 'purchasing/po-monitoring',
            'resource'  => 'Purchasing\POMonitoring',
            ],
        ],
    ],
    [
    'label'     => 'transaction',
    'icon'      => 'icon mdi mdi-phone-in-talk',
    'children'  =>
        [
            [
            'label'     => 'complaint',
            'route'     => 'complaint',
            'resource'  => 'Complaint',
            ],
        ]
    ],
];
