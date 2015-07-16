<?php
return array(
    'import'  => array(
        'application.admin.modules.ticket.models.*',
    ),
    'modules' => array(
        'application.admin.modules.ticket.TicketModule',
    ),
    'rules'   => array(
        'admin/ticket'          => '/ticket/ticket/index',
        'admin/ticket/category' => '/ticket/category/index',
    )
);
