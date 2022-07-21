<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

return [
    "local"=>true,
    "api"=>[
        'url'=>env('REPORT_API_URL','http://localhost:8000/api'),
        'token'=>env('REPORT_API_TOKEN', null),
    ],
    "layout"=>"tall-report::layouts.app",
    "models"=>[
        "parent"=>\Tall\Report\Models\Report::class
    ], 
    "routes"=>[
        "reports"=>[
            'list'=>'tall.report.admin.reports',
            'create'=>'tall.report.admin.report.create',
            'edit'=>'tall.report.admin.report.edit',
            'generate'=>'tall.report.admin.report.generate',
        ]
        ],
        "info"=>[]
];
