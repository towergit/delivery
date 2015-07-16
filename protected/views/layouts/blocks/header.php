<div class="container-fluid menu-panel">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="main-menu">
                        <?php
                        $this->beginContent('//layouts/blocks/menu');
                        $this->endContent();
                        ?>
                    </div>
                </nav>
            </div>
           <!--<div class="col-md-3">
                <div class="menu-panel-project pull-right">
                    <a href="<?php echo $this->createUrl('/default/authorization'); ?>">
                        <?php echo Yii::t('main', 'Участвовать в проекте'); ?>
                    </a>
                </div> 
            </div>-->
        </div>	
    </div>
</div>
<!-- <div class="container block-1">
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <?php $this->widget('application.modules.language.widgets.LanguageSelectorWidget'); ?>
        </div>
        <div class="col-md-offset-4 col-md-4 col-sm-6 col-sm-offset-2">
            <div class="mail-block1 pull-left">
                <a href="mailto:info@blago-vest.org">info@blago-vest.org</a>
            </div>
            <div class="button-patron">
                <a class="patron" href="<?php echo $this->createUrl('/default/authorization'); ?>">
                    <?php echo Yii::t('main', 'Участвовать в проекте'); ?>
                </a>
            </div>
        </div>
    </div>
</div>//-->
<!--header-->
<div class="container-fluid header">
    <div class="container">
        <div class="row">
            <div class="col-md-3 logo">
                <a href="<?php echo Yii::app()->homeUrl; ?>">
                    <img src="<?php echo $this->assetsBase; ?>/images/logo.png" alt="" />
                </a>
            </div>
            <div class="col-md-9">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="main-menu">
                        <?php
                        $this->beginContent('//layouts/blocks/menu');
                        $this->endContent();
                        ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>