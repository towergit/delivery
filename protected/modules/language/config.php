<?php
return array(
    'import'     => array(
        'application.modules.language.models.*',
        'application.modules.language.components.LanguageBehavior',
    ),
    'modules'    => array(
        'application.modules.language.LanguageModule',
    ),
    'components' => array(
        'urlManager' => array(
            'class' => 'application.modules.language.components.LangUrlManager',
        ),
    ),
    'rules'      => array()
);
