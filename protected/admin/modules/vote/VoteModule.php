<?php

/**
 * Управление пользовательскими голосами
 *
 * @category Module
 * @package  Module.Vote
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class VoteModule extends WebModule
{
    /**
     * Инициализация модуля
     * setImport - импортирует при запуске любого контроллера этого модуля
     * setComponents - импортирует компоненты
     */
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'vote.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('vote', 'Голоса');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('vote', 'Управление пользовательскими голосами');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('vote', 'Beta: 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-star-half-o';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('vote', 'Голоса'),
                'icon'    => $this->icon,
                'url'     => array( '/vote/vote/index' ),
                'visible' => Yii::app()->user->checkAccess('showVote'),
            ),
        );
    }

}

