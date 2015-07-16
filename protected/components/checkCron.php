<?php
/**
 * Проверка Запущен крон этого сайта
 *
 * @package  Component
 * @author   Stcherbina Igor <verycooleagle@gmail.com>
 */
class checkCron{
        private $getPass,$result;
        static $pass='testWebInvest';
        static function checkPass($pass){  return self::$pass==$pass ? true : false ; }
        public function __construct( $deburg = FALSE ) {
                if( !$deburg ){
                        if(isset($_REQUEST['pass'])){
                                $this->getPass  =$_REQUEST['pass'];
                                $this->result   = self::checkPass($this->getPass);
                            }else
                                $this->result=false;

                        if(!$this->result){
                                if( class_exists('log') ){
                                        $log =new log();
                                        $log->_content='Array Server ->';
                                        $log->_content=$_SERVER;
                                        $log->_content='Array REQUEST ->';
                                        $log->_content=$_REQUEST;

                                        $log->addToLog();
                                    }
                                 Yii::app()->end();
                            }else{
//                                if( Yii::app()->mutex->lock($_SERVER['REQUEST_URI'], 30) )echo 'Be LOck!!!';
//                                    else Yii::app()->end();
                            }
                    }
            }
    }
