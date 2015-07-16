<?php
/**
 * Контроллер cron-а
 *  Каторый собирает статиску статистику по зарегистрированым пользователям, инвесторам и
 *  сумма выведенных средств из фонда для вывода в админке.
 * @category Controller
 * @package  Controllers
 * @author   Igor Stcherbina <verycooleagle@gmail.com>
 * 
 * Опись SkiletCronController
 * Переменные
 *  $_curDate - Дата запуска текущего действия,
 *   $_debug - переключатель режимы отладки ,
 *   $_save  - флаг сохранения данных,
 *   $_start - фиксирует время старта действия
 *   $_typeTimeExecute  - указывает на ед. измерения ( TRUE ( микросекунды ) \ FALSE ( секунды ) )
 *   $_Action = 'EMTPY' - указатель выполняемого действия 
 * $_Class - Указывает на класс
 * Методы
 *  getTime() Берет текущее время в взависомисти от _typeTimeExecute в указаной ед. измерения
 *  _addError($message = FALSE) Вывод ошибки и дублирование в лог ошибок данного крона
 *  _addCronLog( $message = FALSE) Добавление в общий лог кронов( 'ДОСТУПА' ) ошибки 
 *  _EndAction() Завершающие операции при завершении действия 
 *  _DebugMode($debug = false ,$data = false ,$save  = true) функция реализует установка параметров для режима отладки
 *  checkDate($needHours) Проверка даты запуска действия 
 *  notification  
 *      {
 *          Функция делает разноцыетные сообщения для визуального отоброжения работы 
 *          кронов где 
 *              @params string $text - текст сообщения
 *              @params string $type - тип сообщения 
 *              (Для формирование блоков)
 *              $block - Будут блоки ( Правда )
 *              $openClose - Начало блока ( Правда ) / Конец блока ( Ложь )
 *      }
 * EXAMPLE ACTION 
 *      public function actionYOU(){
 *          $this->_Action = __FUNCTION__;
 *          $this->_DebugMode(
 *                  FAlse,       // - eneble/disable deburg mode
 *                  False,//'2015-05-09',      // - data ( Y-m-d) or FALSE
 *                  TRUE       // - Save (True / False)
 *              );
 *          $this->_typeTimeExecute = self::MICRO;
 *          $checkCron = new checkCron($this->_debug);
 *          if($this->checkDate(YOU_TIME_EXECUTE)){
 *                  . . . 
 *                  . . . 
 *              }else
 *                  $this->_addCronLog('Not correct TIME');
 *           
 *          $this->_EndAction();
 *     }
 */
class SkiletCronController extends CController
{
    /** PARAMETRS **/
    const MICRO = TRUE;
    const SECONDS = FALSE;
    protected 
            $_curDate,
            $_debug = false,
            $_save = true,
            $_start,
            $_typeTimeExecute = self::MICRO,
            $_Action = 'EMTPY',
            $_Class = __CLASS__,
            $_LogNotice;
    /** PUBLIC **/
   
    // Берет текущее время в взависомисти от _typeTimeExecute в указаной ед. измерения
    public function getTime(){
        if($this->_typeTimeExecute){ 
                list($usec, $sec) = explode(" ", microtime()); 
                $result = ((float)$usec + (float)$sec); 
            }else
                $result = time() ;
        return $result;
    }
    
    /** PROTECTED **/
    
   // Вывод ошибки и дублирование в лог ошибок данного крона
    protected function _addError($message = FALSE){
        if(!$message)
            $message ='BE EMPRY ERROR IN ADDING';
        if( class_exists('log') ){
                $log =new log($this->_Class.date('Y-m').'Error.txt');
                $log->_content="[ {$this->_Action} ]{$message}";
                $log->addToLog();
            }else
                $message = "Not HAVE COMPONET log (NOT WORKING LOGGING)\r\n".$message;
        $this->notification($message,'e');
    }
    // Добавление в общий лог кронов( 'ДОСТУПА' ) ошибки 
    protected function _addCronLog( $message = FALSE){
        $title = '['.$this->_Class.' / '.$this->_Action.']';
         
        if(!$message)
            $message ='BE EMPRY MESSAGE IN ADDING';
        if( class_exists('log') ){
                $log =new log();
                $log->_content="[{$title}]{$message}";
                $log->_content='Array Server ->';
                $log->_content=$_SERVER;
                $log->_content='Array REQUEST ->';
                $log->_content=$_REQUEST;
                $log->addToLog();
            }else
                $message = "Not HAVE COMPONET log (NOT WORKING LOGGING)\r\n".$message;
            
        $this->notification($message,'e');   
    }
     // Завершающие операции при завершении действия 
    protected function _EndAction(){
        $from = '['.$this->_Class.' / '.$this->_Action.']';
        $end = $this->Time;
        $exTime = 'Execute time -> '.((float)$end-(float)$this->_start);
        $this->notification($exTime,'e'); 
        $this->notification("End job {$from}");
        echo "<br>END for $exTime";
    }
    // функция реализует установка параметров для режима отладки
    protected function _DebugMode($debug = false ,$data = false ,$save  = true , $logNotice = false){
        $from = '['.$this->_Class.' / '.$this->_Action.']';
        $this->_debug = $debug;
        $this->_start = $this->Time;
        $this->_LogNotice = $logNotice;
        if($debug){
                $this->_save = $save;
                if($data != false ) $this->_curDate=new DateTime($data);
                    else $this->_curDate=new DateTime;
                ?>
                    <style>
                        .s{font-size:20px;color:#005600}
                        .e{font-size:22px;color:#f00}
                        .i{font-size:18px;color:#00f}
                        .notification{padding:2px}
                        .notification p{color:#B95c00}
                        .content{padding-left:15px;}
                        .blocks{text-decoration:underline;cursor: pointer;color:cadetblue}
                        .active{color:red}
                    </style>
                    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'></script>
                    <script>
                    $(function(){
                            $('.blocks').each(function(){
                                var el = $(this);
                                el.click(function(){
                                    el.toggleClass('active');
                                    el.next().slideToggle();
                                });
                                el.click();
                            });
                        });
                    </script>
                <?php
                $this->notification('<h1>Enable Debug MODE</h1>','e');
                $this->notification("Start $from");
                $this->notification('Current date->'.$this->_curDate->format('Y-m-d'),'i');
               
            }else
                $this->_curDate=new DateTime;
    }
    // Проверка даты запуска действия 
    protected function checkDate($needHours){
            if($this->_debug){
                 $this->notification('Be check date');
                return TRUE;
            }
            $hours		 = $this->_curDate->format('H');
            if ( $hours == $needHours ) return true;
            echo $this->_addCronLog("Крон должен быть запущен (по времени) в {$needHours} часов, но не {$hours}");
            return false;
        }
    /* Функция делает разноцыетные сообщения для визуального отоброжения работы 
    * кронов где 
    * @params string $text - текст сообщения
    * @params string $type - тип сообщения 
     * (Для формирование блоков)
     * $block - Будут блоки ( Правда )
     * $openClose - Начало блока ( Правда ) / Конец блока ( Ложь )
    */
    protected function notification($text,$type='s',$block = false , $openClose = true){
        if($this->_debug){
                echo "<div class='notification $type'>$text</div>";
                if($block){
                        echo (
                                $openClose
                                ? "<div class='blocks' >Show/Hide Current Block</div></div><div class='content'>"
                                : '</div>' 
                            );
                    }
            }
        if( $this->_LogNotice ){
            $title = $this->_Class.'-'.$this->_Action;
            if( class_exists('log') ){
                $log =new log( $title. '-Notice-'.date('m-y').'.txt' );
                $log->_content="[TYPE->{$type}]\r\n TEXT: \r\n {$text} ";
                $log->addToLog();
            }
        }
    }
    
}