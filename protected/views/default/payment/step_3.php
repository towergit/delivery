<?php

$status = Yii::app()->request->getQuery('status');
?>
<div class="notification-text">
<?php if ($status == 'success'): ?>
    <i class="fa fa-check-circle-o"></i>
    <h3>Платеж успешно выполнен</h3>
    <p>Спасибо Вам за пожертвование</p>
<?php else: ?>
    <i class="fa fa-check-circle-o"></i>
    <h3>Платеж не выполнен!</h3>
    <p>Повторите попытку</p>
<?php endif; ?>

</div>
<?php

if ($status == 'success') {
    Yii::app()->clientScript->registerScript('timeout', "$(function() {
            
                setTimeout(function(){ 
             
window.location.href = '/payment/step/4'; }, 5000);
            })", CClientScript::POS_END);
}else {
        Yii::app()->clientScript->registerScript('timeout', "$(function() {
            
                setTimeout(function(){ 
             
window.location.href = '/payment/step/2?auth=anonim'; }, 5000);
            })", CClientScript::POS_END);
    
    
} ?>