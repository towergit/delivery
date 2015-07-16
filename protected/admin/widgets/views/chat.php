<ul class="nav nav-tabs">
    <li class="active">
        <a href="#chat-users" data-toggle="tab">Пользователи</a>
    </li>
    <li>
        <a href="#chat-messages" data-toggle="tab">Сообщения</a>
    </li>
</ul>
<a href="#" class="close">
    <i class="fa fa-times"></i>
</a>
<div class="tab-content">
    <div class="tab-pane active" id="chat-users">
        <div class="content">
            <div class="view">
                <div class="navbar">
                    <div class="navbar-inner">
                        <input type="text" placeholder="Найти пользователя ..." id="search-user" />
                    </div>
                </div>
                <div class="scrollbar-macosx view-content">
                    <ul class="view-users">
                        <li>
                            <a href="javascrip:;">
                                <img src="<?php echo $this->controller->getAssetsBase(); ?>/images/avatar.png" alt="" />
                                <div class="online"></div>
                                <p>
                                    <span class="name">Александр Тимковский</span>
                                    <span class="status">Разработчик</span>
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="javascrip:;">
                                <img src="<?php echo $this->controller->getAssetsBase(); ?>/images/avatar.png" alt="" />
                                <div class="online"></div>
                                <p>
                                    <span class="name">Евгений Семейский</span>
                                    <span class="status">Руководитель проекта</span>
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="javascrip:;">
                                <img src="<?php echo $this->controller->getAssetsBase(); ?>/images/avatar.png" alt="" />
                                <p>
                                    <span class="name">Наталья Величко</span>
                                    <span class="status">Инвестор</span>
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="javascrip:;">
                                <img src="<?php echo $this->controller->getAssetsBase(); ?>/images/avatar.png" alt="" />
                                <div class="online"></div>
                                <p>
                                    <span class="name">Дмитрий Микитенко</span>
                                    <span class="status">Тех. поддержка</span>
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="javascrip:;">
                                <img src="<?php echo $this->controller->getAssetsBase(); ?>/images/avatar.png" alt="" />
                                <p>
                                    <span class="name">Вячеслав Шилов</span>
                                    <span class="status">Тех. поддержка</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="view">
                <div class="navbar">
                    <div class="navbar-inner">
                        <a href="javasscript:;" class="action">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <div class="view-heding">
                            Александр Тимковский
                            <div class="hint">Online</div>
                        </div>
                    </div>
                </div>
                <div class="view-content">
                    <div class="chat scrollbar-macosx">
                        <div class="message from-them clearfix">
                            Привет Мир!
                        </div>
                        <div class="message from-me clearfix">
                            Добрый вечер! Всем участникам привет.
                        </div>
                        <div class="message from-me clearfix">
                            Приятного вечера!
                        </div>
                        <div class="message from-them clearfix">
                            Я был вчера на коференции.
                        </div>
                        <div class="message from-me clearfix">
                            И как она Вам?
                        </div>
                        <div class="message from-them clearfix">
                            Если не удаваться в некоторые мелочные недочеты - то было даже неплохо.
                        </div>
                        <div class="message from-them clearfix">
                            А ... У Вас?
                        </div>
                        <div class="message from-them clearfix">
                            А будет возможность получить запись видео?
                        </div>
                        <div class="message from-me clearfix">
                            Да. Ссылку дадим позже.
                        </div>
                        <div class="message from-them clearfix">
                            Спасибо.
                        </div>
                    </div>
                    <div class="footer">
                        <div class="footer-inner">
                            <input type="text" id="send-message" placeholder="Отправить сообщение" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="chat-messages">
        2
    </div>
</div>