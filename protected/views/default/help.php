<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'Процедура подачи заявки'));

$this->showHeadering = false;
?>
<div class="container faq">
    <h1>Процедура подачи заявки на получение материальной помощи от БФ БлагоВест</h1>
    <h3>Обращения принимаются исключительно на электронную почту фонда info@blago-vest.org. Процедура состоит из последовательности двух этапов. Приступайте ко второму только после прохождения первого.</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="issue">
                <div class="issue-head">
                    <h4 class="pull-left">I ЭТАП</h4>
                    <div class="button-plus pull-right">
                        <i class="fa fa-minus"></i>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="issue-text">
                    <ol style="text-transform: none; line-height:20px;">
                        <li>Убедитесь в том, что Ваша заявка соответствует специализации БлагоВеста (<a href="<?php echo $this->createUrl('/about-fund'); ?>">о фонде</a>)</li>
                        <li>Кратко опишите сложившуюся ситуацию</li>
                        <li>Укажите какая конкретная помощь нужна (название, изображение, стоимость, счет, ссылка на товар в интернет магазине)</li>
                        <li>Укажите контакты для обратной связи: адрес, телефон, скайп, имейл, профиль в соц. сетях</li>
                        <li>Укажите как Вы узнали о фонде БлагоВест, а также были ли обращения в другие благотворительные орагнизации. Если были, то укажите с каким итогом. Укажите использовались ли все другие доступные способы получения помощи</li>
                    </ol>
                </div>
            </div>
            <div class="issue issue-over">
                <div class="issue-head">
                    <h4 class="pull-left">II ЭТАП</h4>
                    <div class="button-plus pull-right">
                        <i class="fa fa-plus"></i>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="issue-text">
                    <p>Если в течении трех суток после первого обращения Вы получили положительный ответ от фонда, подготовьте следующий пакет документов:</p>
                    <ol style="text-transform: none; line-height:20px;">
                        <li>Скан­-копия письменного заявления на имя управляющего фондом (<a href="/document/doc.zip" target="_BLANC">скачать образец</a>)</li>
                        <li>Скан­-копия паспорта (1,2 страница, прописка, семейное положение) и идентификационного кода заявителя</li>
                        <li>Скан­-копия справки с места работы или пенсионного удостоверения</li>
                        <li>Скан-­копия свидетельства о рождении или паспорта объекта помощи</li>
                        <li>Фотографии объекта помощи</li>
                        <li>Скан­-копия официальных медицинских документов (в случае наличия трудностей со здоровьем)</li>
                        <li>Видео­обращение о помощи конкретно к фонду БлагоВест по желанию (1-­2 минутная запись)</li>
                        <li>Подписывая заявление на получение помощи Вы также даете согласие и обязуетесь:
                            <ul>
                                <li>на сбор, обработку и публикацию данных на сайте фонда, в Интернете и СМИ</li>
                                <li>предоставлять исключительно правдивую, максимально полную информацию</li>
                                <li>­использовать полученную помощь исключительно по целевому назначению</li>
                                <li>не позднее 7 дней после получения помощи предоставить отчет, наглядно отображающий и подтверждающий фактическое целевое использование средств (благодарность фонду, фотографии, видео­отзыв, а также скан квитанции или накладной)</li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--  begin:carousel //-->
    <!-- 
 <div id="owl-demo-coment" >

 	<div class="item">
 		<div class="col-md-5 col-md-offset-7">
        	<p>Пренебрегая словесами <br>
Жизнь убеждает нас опять: <br>
Талантам надо помогать, <br>
Бездарности пробьются сами <br>
(Лев Озеров) </p>
        </div>
 	</div>
	<div class="item">
		<div class="col-md-5 col-md-offset-7">
			<p>Милосердие имеет несколько ступеней. Высшая из них – научить человека оказывать помощь самому себе. (Моисей Маймонид)</p>
		</div>
	</div>
	<div class="item">
		<div class="col-md-5 col-md-offset-7">
			<p>Помогая ленивым людям ты помогаешь им сесть на свою шею. (Хань Сян-цзы)</p>
		</div>
	</div>
	<div class="item">
		<div class="col-md-5 col-md-offset-7">
			<p>Мы не поможем людям, делая за них то, что они могли бы сделать сами. (Авраам Линкольн)</p>
		</div>
	</div>
	<div class="item">
		<div class="col-md-5 col-md-offset-7">
			<p>Дай человеку рыбу, и ты накормишь его только раз. Научи его ловить рыбу, и он будет кормиться ею всю жизнь. (Китайская пословица)</p>
		</div>
	</div>
	<div class="item">
		<div class="col-md-5 col-md-offset-7">
			<p>Благодеяния, оказанные недостойному, я считаю злодеяниями. (Цицерон)</p>
		</div>
	</div>
 </div>
 //-->
    <!--  end:carousel; //-->
</div>
<?php 
$cs =Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->controller->assetsBase. '/js/owl-carousel/owl.carousel.css', 'screen');
$cs->registerCssFile(Yii::app()->controller->assetsBase. '/js/owl-carousel/owl.theme.css', 'screen');
$cs->registerScriptFile(Yii::app()->controller->assetsBase.'/js/owl-carousel/owl.carousel.js');
?>
<?php
Yii::app()->clientScript->registerScript(uniqid(), "
            $(document).ready(function() {
            
                $('.issue-head').click(function() {
                    
                    $(this).parent().toggleClass('issue-over', 900); 
                    
                     if($(this).find('i.fa').hasClass('fa-plus')) {
                     console.log('+')
                        $(this).find('i.fa').removeClass('fa-plus').addClass('fa-minus');
                    }else {
                    console.log('-')
                        $(this).find('i.fa').removeClass('fa-minus').addClass('fa-plus');
                    }
                })

            });
        ", CClientScript::POS_END);
?>
<?php
Yii::app()->clientScript->registerScript(uniqid(), "
        

        $(document).ready(function() {

		$('#owl-demo-coment').owlCarousel({
                        autoPlay: 6000,
                        slideSpeed: 300,
                        paginationSpeed: 400,
                        singleItem: true,
						pagination: false
                    });

        });
    ", CClientScript::POS_END);
?>
