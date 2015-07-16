<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- начало: боковая панель -->
        <nav class="page-sidebar">
            <!-- начало: шапка -->
            <div class="sidebar-header">
                <div class="controls">
                    <a href="#" class="toggle-sidebar">
                        <i class="fa fa-circle-o"></i>
                    </a>
                </div>
            </div>
            <!-- конец: шапка -->

            <!-- начало: главное меню -->
            <div class="sidebar-menu scrollbar-macosx">
                <?php $this->widget('admin.widgets.MainMenuWidget'); ?>
            </div>
            <!-- конец: главное меню -->
        </nav>
        <!-- конец: боковая панель -->

        <div class="page-container">
            <!-- начало: шапка -->
            <div class="header">
                <div class="pull-left">
                    <div class="header-inner">
                        <!-- начало: логотип -->
                        <div class="brand">
                            <img src="<?php echo $this->getAssetsBase(); ?>/images/logo.png" alt="logo" />
                        </div>
                        <!-- конец: логотип -->

                        <!-- начало: уведомления -->
                        <ul class="notification-list list-unstyled">
                            <li>
                                <a href="<?php echo Yii::app()->homeUrl; ?>" target="_blank">
                                    <i class="flaticon-screen50"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="flaticon-envelope42"></i> 
                                    <div class="bubble"></div>
                                </a>
                            </li>
                        </ul>
                        <!-- конец: уведомления -->

                        <!-- начало: глобальный поиск -->
                        <a href="javascript:;" class="search-link">
                            <i class="flaticon-magnifyingglass"></i>
                            <?php echo Yii::t('template', 'Глобальный поиск'); ?>
                        </a>
                        <!-- конец: глобальный поиск -->
                    </div>
                </div>
                <div class="pull-right">
                    <div class="header-inner">
                        <a href="#" class="open-chat">
                            <i class="flaticon-speechbubble"></i>
                        </a>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="login">
                        <?php echo Yii::app()->user->username; ?>
                    </div>
                    <div class="thumbnail-wrapper dropdown">
                        <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown">
                            <img src="<?php echo $this->getAssetsBase(); ?>/images/avatar.png" alt="" />
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo $this->createUrl('/user/user/update', array( 'id' => Yii::app()->user->id )); ?>">
                                    <?php echo Yii::t('template', 'Профиль'); ?>
                                </a>
                            </li>
                            <li class="lighter">
                                <a href="<?php echo $this->createUrl('/user/logout'); ?>" class="clearfix">
                                    <span class="pull-left"><?php echo Yii::t('template', 'Выход'); ?></span>
                                    <span class="pull-right">
                                        <i class="fa fa-power-off"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pull-right">
                    <?php $this->widget('application.admin.modules.language.widgets.LanguageSelectorWidget'); ?>
                </div>
            </div>
            <!-- конец: шапка -->

            <!-- начало: основной контент -->
            <div class="page-content-wrapper">
                <?php echo $content; ?>
            </div>
            <!-- конец: основной контент -->
        </div>

        <!-- начало: чат -->
        <?php if (Yii::app()->user->checkAccess('superadministrator')): ?>
            <div class="chat-wrapper">
                <?php $this->widget('admin.widgets.ChatWidget'); ?>
            </div>
        <?php endif; ?>
        <!-- конец: чат -->

        <!-- начало: глобальный поиск -->
        <?php $this->widget('application.admin.modules.search.widgets.GlobalSearchWidget'); ?>
        <!-- конец: глобальный поиск -->

        <!-- начало: уведомления -->
        <?php $this->widget('application.admin.widgets.FlashMessagesWidget'); ?>
        <!-- конец: уведомления -->
    </body>
</html>