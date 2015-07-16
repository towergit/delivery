<?php
unset($form);
 //
$rub_exchange = Exchange::daily('RUB');
$uah_exchange = Exchange::daily('UAH');

$form = $this->beginWidget('BsActiveForm', array(
    'id' => 'payment',
    'action' => Yii::app()->createUrl('/default/payment'),
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<div class="col-md-3">
    <h3><?php echo Yii::t('main', 'Ваша помощь'); ?></h3>
    <div class="was-patron-line"></div>
    <label class="how-donate">
        <?php echo Yii::t('main', 'Какой суммой Вы хотите помочь?'); ?>
    </label>
    <div class="btn-group" role="group" aria-label="...">
        <div class="row">
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price btn-active" >
                    <?php echo 15 //$totalSum * 5 / 100;  ?> &#36;
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price  sub-price  btn-active" disabled="disabled">
                    <?php echo 15 * $rub_exchange; //$totalSum * 5 / 100;  ?>  &#x20bd;
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price  sub-price  btn-active" disabled="disabled">
                    <?php echo 15 * $uah_exchange; //$totalSum * 5 / 100;  ?>  &#8372;
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price" >
                    <?php echo 50 //$totalSum * 5 / 100;  ?> &#36;
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price  sub-price" disabled="disabled">
                    <?php echo 50 * $rub_exchange; //$totalSum * 5 / 100;  ?>  &#x20bd;
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price  sub-price" disabled="disabled">
                    <?php echo 50 * $uah_exchange; //$totalSum * 5 / 100;  ?>  &#8372;
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price" >
                    <?php echo 100 //$totalSum * 5 / 100;  ?> &#36;
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price  sub-price" disabled="disabled">
                    <?php echo 100 * $rub_exchange; //$totalSum * 5 / 100;  ?>  &#x20bd;
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price  sub-price" disabled="disabled">
                    <?php echo 100 * $uah_exchange; //$totalSum * 5 / 100;  ?>  &#8372;
                </button>
            </div>
        </div>
    </div>
    <div class="form-group">

        <div class="row">
            <div class="col-md-12">
                <?php
                $model->sum = 15;
                echo $form->labelEx($model, 'sum');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">

<?php echo $form->textField($model, 'sum', array('placeholder' => ' ')); ?>


            </div>
            <div class="col-md-4">
                <button type="button" name="sum" class="btn-price sub-price" disabled="disabled"  style="margin-top: 0 !important;;">
                    <span class="rub_value"> <?php echo 100 * $rub_exchange; //$totalSum * 5 / 100;   ?> </span>  &#x20bd;
                </button>
            </div>
            <div class="col-md-4" >
                <button type="button" name="sum" class="btn-price sub-price" disabled="disabled"  style="margin-top: 0 !important;;">
                    <span class="uah_value"> <?php echo 100 * $uah_exchange; //$totalSum * 5 / 100;   ?> </span> &#8372;
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
<?php echo $form->error($model, 'sum'); ?>
            </div>
        </div>
    </div>
</div>
<div class="col-md-5">
    <h3><?php echo Yii::t('main', 'Выбор способа оплаты'); ?></h3>
    <div class="was-patron-line"></div>
    <div class="btn-group payment-sys" role="group" aria-label="...">
        <?php
        $activesystem;
        $i = 0;
        foreach ($systems as $key => $system):
            ?>
            <div class="col-md-6">
                <button type="button" name="payment" class="btn-variant-price <?php echo $i == 0 ? 'btn-active' : ''; ?>">
                    <img src="<?php echo $this->controller->assetsBase; ?>/images/<?php echo $system->code; ?>.png" alt="<?php echo $system->code; ?>" />
                </button>
            </div>
            <?php
            if ($i == 0)
                $activesystem = $system->code;
            $i++;
        endforeach;
        ?>
<?php ?> 

    </div>
    <?php
    $model->system = $activesystem;
    echo $form->hiddenField($model, 'system');
    ?>
</div>
<div class="col-md-4">
    <h3><?php echo Yii::t('main', 'Ваши данные'); ?></h3>
    <div class="was-patron-line"></div>
    <?php
    echo $form->textFieldControlGroup($model, 'name', array(
        'placeholder' => ' ',
    ));
    echo $form->textFieldControlGroup($model, 'email', array(
        'placeholder' => ' ',
    ));
    echo $form->textFieldControlGroup($model, 'phone', array(
        'placeholder' => '+____________',
    ));
    ?>
</div>
<div class="col-md-12">
    <div align="center" class="form-group">
        <button type="submit" class="btn-donate btn-payment">
<?php echo Yii::t('main', 'Оказать помощь'); ?>
        </button>
    </div>
</div>	
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript(uniqid(), "
        $(document).ready(function() {
            
    $(\"#Payment_phone\").mask(\"+999999999999\");
        
    var rub_exchange = " . $rub_exchange . ";
    var uah_exchange = " . $uah_exchange . ";
        
            $('.btn-price').on('click', function() {
                
                $('.btn-price').removeClass('btn-active');
                $(this).parent().parent().find('.btn-price').addClass('btn-active');

                $('#Payment_sum').val(parseInt($(this).text()));
                
                                  var val = $('#Payment_sum').val();

                    $('.rub_value').text(parseFloat((val * rub_exchange).toFixed(2)));
                    $('.uah_value').text(parseFloat((val * uah_exchange).toFixed(2)));
                    
            });
            
            $('.btn-variant-price').on('click', function() {
                $('.btn-variant-price').removeClass('btn-active');
                
                $(this).addClass('btn-active');
                $('#Payment_system').val($(this).find('img').attr('alt'));
                    
            });
            
            $('#Payment_sum').keyup(function(event) {
                $('.btn-price').removeClass('btn-active');
                var val = $(this).val();
                $('.rub_value').text(parseFloat((val * rub_exchange).toFixed(2)));
                $('.uah_value').text(parseFloat((val * uah_exchange).toFixed(2)));
            });
            

            
        });
    ", CClientScript::POS_END);
?>