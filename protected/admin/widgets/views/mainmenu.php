<?php
$this->widget('ext.RMenu',
    array(
    'id'                 => '',
    'encodeLabel'        => false,
    'htmlOptions'        => array(
        'class' => 'menu-items',
    ),
    'submenuHtmlOptions' => array(
        'class' => 'sub-menu',
    ),
    'items'              => $items,
));
?>