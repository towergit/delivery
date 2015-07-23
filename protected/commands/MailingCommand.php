<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailingCommand
 *
 * @author vlad
 */
class MailingCommand extends CConsoleCommand {
    
    public function actionSend($template = null, $limit = 5) {
        error_reporting(E_ALL);
        ini_set('display_errors', true);
        $auth = false;



        echo 'Введите пароль: ' . "\r\n";

        while (!$auth) {
            $handle = fopen("php://stdin", "r");
            $password = fgets($handle);

            if(trim($password) != '123123') {
                echo 'Неверный пароль! Попробуйте еще раз ' . "\r\n";
            }else {
                $auth = true;
            }
        }

        $initstr = '';
        $finishstr = '';

        if (!$template)
            throw new Exception('Необходим парааметр tamplate', '401');

        echo "\r\n" . "Начать рассылку по всей базе подписчиков? ('yes' or 'no')";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        $logName = $_SERVER['PWD'] . '/templates_logs/' . date('Ymd') . '.txt';

        if (trim($line) != 'yes') {
            echo "ABORTING!\n";
            exit;
        }

        $DBH = new PDO("mysql:host=" . Yii::app()->params['HOST'] . ";dbname=" . Yii::app()->params['DBNAME'], Yii::app()->params['USER'], Yii::app()->params['PASS']);
        $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $STH = $DBH->query('SELECT * from emails_base WHERE status = 1');

        # устанавливаем режим выборки
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $total = $STH->rowCount();

        $logFile = fopen($logName, 'a+');
        $initstr .= "\r\n" . "======================================" . "\r\n";
        $initstr = 'Начало рассылки ' . date("Y-m-d H:i:s") . "\r\n";
        $initstr .= "\r\n" . "======================================" . "\r\n";

        fwrite($logFile, $initstr);
        $params = array();
        $mailer = new Mailer;
        $temp = CEmailComponent::getTemplate($template);
        $mailer->from(Yii::app()->params['from_email'], Yii::app()->params['from_name']);
        $mailer->subject('GoldenBirds - Интересная игра с реальной прибылью');
        $mailer->templateMessage($temp, $params);
        
        $i = 1;
        while ($row = $STH->fetch()) {
            echo $i . "\r\n";
        //    $mailer->to($row['email']);
 $mailer->to('lotysh.vm@gmail.com');
            if (!$mailer->send()) {
                fwrite($logFile, 'Письмо не отправлено ' . $row['email'] . ' !!' . "\r\n");
            }
            $i++;
            exit();
        }

        $finishstr .= "\r\n" . "======================================" . "\r\n";
        $finishstr = "\r\n" . 'Рассылка закончена ' . date("Y-m-d H:i:s") . "\r\n";
        $finishstr .= "\r\n" . "======================================" . "\r\n";

        fwrite($logFile, $finishstr);

        echo 'Рассылка успешно закончена!' . "\r\n";
        ;

        exit();
    }

    public function actionTest($template = 'test') {
        echo "Напишите тестовый e-mail" . "\r\n";

        $handle = fopen("php://stdin", "r");
        $email = fgets($handle);
        $params = CEmailComponent::getTemplateParams($template);

        $mailer = new Mailer;
        $temp = CEmailComponent::getTemplate($template);
        $mailer->from(Yii::app()->params['from_email'], Yii::app()->params['from_name']);
        $mailer->subject('Бизнес рассылка');
        $mailer->templateMessage($temp, $params);
        $mailer->to($email);

        if ($mailer->send()) {
            echo 'Письмо успешно отправлено на адрес ' . "\r\n";
        } else {
            echo 'Письмо не было отправлено! Повторите попытку' . "\r\n";
        }
    }

}
