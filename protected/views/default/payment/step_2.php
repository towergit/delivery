<?php
$this->widget('PaymentWidget', array(
    'totalSum' => Basket::getTotalSum(),
));
?>