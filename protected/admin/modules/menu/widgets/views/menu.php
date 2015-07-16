<?php
$this->widget('zii.widgets.CMenu', 
    CMap::mergeArray(
        CMap::mergeArray(array( 'encodeLabel' => false ), $layoutParams), 
        $params)
    );
?>