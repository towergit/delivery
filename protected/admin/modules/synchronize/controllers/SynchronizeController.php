<?php
/**
 * Created by PhpStorm.
 * User: Zilot
 * Date: 24.02.2015
 * Time: 10:41
 */


class SynchronizeController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'UserInfoSynchronize';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index',  ),
//                'roles'   => array( 'showSynchronize' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }



    public function actionIndex()
    {
        $this->pageTitle = 'SYNCHRONIZE';

        $user_info = UserInfoSynchronize::model()->find('id=:id', array(':id'=>547));
        $temp_i  = $user_info->attributes;
        $temp_a  = $user_info->address->attributes;
        $temp_c  = $user_info->contact->attributes;

        $temp_452 = array_merge($temp_i,$temp_a,$temp_c);

        $develop = UserProfile::model()->find('user_id=:user_id', array(':user_id'=>547 ));
        $temp_u = $develop->user->attributes;
        $temp_d = $develop->attributes;

        $temp_d_452 = array_merge($temp_u,$temp_d);

        var_dump($temp_452, $temp_d_452);
    }


}

