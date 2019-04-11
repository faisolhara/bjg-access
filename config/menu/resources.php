<?php

return 
[
    [
        'id'        => 'id-1',
        'label'     => 'Access Control',
        'resources' => 'AccessControl',
        'privilege' => ['view', 'edit'],
    ],
    [
        'id'        => 'id-2',
        'label'     => 'Absence',
        'resources' => 'Absence',
        'privilege' => ['view',],
    ],
    [
        'id'        => 'id-3',
        'label'     => 'Birthday',
        'resources' => 'Birthday',
        'privilege' => ['view',],
    ],
    [
        'id'        => 'id-4',
        'label'     => 'Purchasing / My Requistition',
        'resources' => 'Purchasing\MyRequisition',
        'privilege' => ['view',],
    ],
    [
        'id'        => 'id-5',
        'label'     => 'Purchasing / PO Monitoring',
        'resources' => 'Purchasing\POMonitoring',
        'privilege' => ['view',],
    ],
];
    