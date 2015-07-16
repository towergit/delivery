<div class="row">
    <div class="col-md-6 login-input">
        <h3><?php echo Yii::t('main', 'У меня уже есть аккаунт'); ?></h3>
        <div class="was-patron-line"></div>
        <?php $this->widget('application.modules.user.widgets.LoginUserWidget', array(
            'view' => 'loginuser_1',
        )); ?>
    </div>
    <div class="col-md-6 login-text">
        <h3><?php echo Yii::t('main', 'Пройти регистрацию'); ?></h3>
        <div class="was-patron-line"></div>
        <p>
           Вы получите доступ в Личный Кабинет, и сможете ознакомиться со всей информацией, которая сделает наше сотрудничество с Вами максимально удобным индивидуально для Вас!
        </p>

        <div class="link-login">
            <div class="pull-left">
                <a href="<?php echo $this->createUrl('/default/authorization', array( '#' => 'registration' )); ?>">
                    <?php echo Yii::t('main', 'Зарегистрироваться'); ?>
                </a>
            </div>	
            <div>
                <a href="<?php echo $this->createUrl('payment/step/2', array('auth' => 'anonim')); ?>">
                    <?php echo Yii::t('main', 'Оформить анонимно'); ?>
                </a>
            </div>
        </div>		
    </div>
</div>