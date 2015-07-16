<div class="row">
    <div class="col-md-6 login-input">
        <h3><?php echo Yii::t('main', 'У меня уже есть аккаунт'); ?></h3>
        <div class="was-patron-line"></div>
        <?php $this->widget('application.modules.user.widgets.LoginUserWidget', array(
            'view' => 'loginuser',
        )); ?>
    </div>
    <div class="col-md-6 login-text">
        <h3><?php echo Yii::t('main', 'Пройти регистрацию'); ?></h3>
        <div class="was-patron-line"></div>
        <p>
            Наши интересы и цели выходят далеко за пределы. Мы знаем, что путь к 
            настоящему успеху, на самом деле, лежит не через удачную карьеру.
        </p>
        <p>
            Наши интересы и цели выходят далеко за пределы.
        </p>
        <div class="link-login">
            <div class="pull-left">
                <a href="<?php echo $this->createUrl('/default/authorization', array( '#' => 'registration' )); ?>">
                    <?php echo Yii::t('main', 'Зарегистрироваться'); ?>
                </a>
            </div>	
            <div>
                <a href="<?php echo $this->createUrl('/default/authorization', array( '#' => 'restore' )); ?>">
                    <?php echo Yii::t('main', 'Восстановить доступ'); ?>
                </a>
            </div>
        </div>		
    </div>
</div>