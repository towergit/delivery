<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="container">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>	
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="container">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>	
    </div>	
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('notify')): ?>
    <div class="alert alert-notify" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="container">
            <?php echo Yii::app()->user->getFlash('notify'); ?>
        </div>	
    </div>	
<?php endif; ?>

