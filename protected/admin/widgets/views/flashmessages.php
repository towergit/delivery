<div class="notification">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <!-- начало: алерт -->
        <div class="alert alert-success animated zoomInUp">
            <div>
                <div class="message">
                    <p><?php echo Yii::t('template', 'Успех'); ?></p>
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            </div>
            <button type="button" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- конец: алерт -->
    <?php endif; ?>

    <?php if (Yii::app()->user->hasFlash('error')): ?>
        <!-- начало: алерт -->
        <div class="alert alert-danger animated zoomInUp">
            <div>
                <div class="message">
                    <p><?php echo Yii::t('template', 'Неудача'); ?></p>
                    <p><?php echo Yii::app()->user->getFlash('error'); ?></p>
                </div>
            </div>
            <button type="button" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- конец: алерт -->
    <?php endif; ?>

    <?php if (Yii::app()->user->hasFlash('notice')): ?>
        <!-- начало: алерт -->
        <div class="alert alert-warning animated zoomInUp">
            <div>
                <div class="message">
                    <p><?php echo Yii::t('template', 'Предупреждение'); ?></p>
                    <p><?php echo Yii::app()->user->getFlash('notice'); ?></p>
                </div>
            </div>
            <button type="button" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- конец: алерт -->
    <?php endif; ?>

    <?php if (Yii::app()->user->hasFlash('info')): ?>
        <!-- начало: алерт -->
        <div class="alert alert-info animated zoomInUp">
            <div>
                <div class="message">
                    <p><?php echo Yii::t('template', 'Информация'); ?></p>
                    <p><?php echo Yii::app()->user->getFlash('info'); ?></p>
                </div>
            </div>
            <button type="button" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- конец: алерт -->
    <?php endif; ?>
</div>