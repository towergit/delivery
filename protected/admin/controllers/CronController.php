<?php

/*Yii::import('admin.modules.stock.models.StockUser');
Yii::import('admin.modules.stock.models.StockUserHistory');
Yii::import('admin.modules.payment.models.CashTransaction');
Yii::import('admin.modules.currency.models.*');
Yii::import('application.admin.modules.stock.models.StockUser');*/

/**
 * Контроллер cron-а
 *
 * @category Controller
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CronController extends CController {

    private $_curDate,
            $_termExecution = 30;
    private static $_percent = 3;

    public static function get_percent(){
    	return self::$_percent;
    }
    /**
     * Запуск
     */
    public function actionIndex() {
        $checkCron = new checkCron;
        $this->notification('Start Cron accruals');
        $this->_curDate = new DateTime;
//                $this->notification('Not real date','e');
//               $this->_curDate     = new DateTime('2015-06-26 23:00:00');
//                $this->_curDate->setTime(23, 30, 00);

        if ($this->checkDate()) {
            // Начисления
        	//$this->action();
            //$this->accrualsToStocks();
            
        }
        $this->notification('End Cron accruals');
    }
    
    
    /**
     * Запуск ежидневного обновления валют
     */
    public function actionCurrency() {
       
        $currencys = array('RUB','USD');
        $checkCron = new checkCron;
        
        foreach ($currencys as $currency) {
            
            Converter::dailyCurrency($currency);
            
        }
        
       
    }

    /**
     * Проверка даты
     * @return boolean
     */
    private function checkDate() {
        $hours = $this->_curDate->format('H');
        $minutes = $this->_curDate->format('i');

        if ($hours >= 23 || ($hours == 23 && $minutes == 59))
            return true;
        echo $this->notification('Крон должен быть запущен (по времени) с 23:00 до 23:59, но не позже', 'e');
        return false;
    }

    /**
     * Начисления По Акциям
     */
    private function accrualsToStocks() {
        
        $stocks = StockUser::getAllForAccuals();
        if (!empty($stocks)) {
            $this->notification('Proccess Stokes');
            foreach ($stocks as $stoke) {
                $dateStock = new DateTime(
                        ( $stoke->update != '0000-00-00 00:00:00') ? $stoke->update : $stoke->created
                );
                if (date_diff($this->_curDate, $dateStock)->days >= $this->_termExecution) {
                    $dateStock = $dateStock->modify('+' . $this->_termExecution . ' days');
                    $stoke->update = $dateStock->format('Y-m-d 00:00:00');
                    $this->accrualsStock($stoke);
                }
            }
            $this->notification('END Proccess Stokes');
        } else
            $this->notification('Empty Stoke', 'i');
    }

    private function accrualsStock($stoke) {
        $percent = $this->_percent / 100;
        $sum = $stoke->count * $stoke->price;
        $payout = $sum * $percent;
        CashTransaction::addRecord($stoke->user_id, $payout, 'percent');
        $stoke->save(false);
        $history = new StockUserHistory;

        $history->price = $stoke->price;
        $history->stock_user_id = $stoke->id;

        $history->save(false);
        $this->notification(
                'UserID ' . $stoke->user_id
                . ' UserLogin ' . $stoke->user->username . '<br>'
                . "Sum = $sum Count = " . $stoke->count . " Payout = " . $payout, 'i');
    }

    /* Функция делает разноцыетные сообщения для визуального отоброжения рабаты 
     * кронов где 
     * @params string $text - текст сообщения
     * @params string $type - тип сообщения 
     */

    private function notification($text, $type = 's') {
        $shareOptionCss = 'font-size:20px;padding:2px;font-weight:bold;';
        switch ($type) {
            case 'e':$color = '#f00';
                break;
            case 's':$color = '#005600';
                break;
            default :$color = '#00f';
                break;
        }
        echo "<div style='$shareOptionCss color:$color' >$text</div>";
    }

}
