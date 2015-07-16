<?php $this->beginContent('//layouts/main'); ?>
    <div class="content">
        <div class="container-fluid">
            <!-- начало: хлебные крошки -->
            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs',
                    array(
                    'separator' => ' &nbsp;>&nbsp; ',
                    'links'     => $this->breadcrumbs,
                    'homeLink'  => false,
                ));
                ?>
            <?php endif; ?>
            <!-- конец: хлебные крошки -->

            <?php echo $content; ?>
        </div>
    </div>
    <div class="container-fluid footer">
        <div class="copyright">
            <?php echo Yii::t('template', 'Все права защищены'); ?> © <?php echo date('Y'); ?> <strong>Blago-vest.org</strong>.
        </div>
    </div>
<?php $this->endContent(); ?>