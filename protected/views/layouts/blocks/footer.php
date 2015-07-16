<div class="container-fluid block-8">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <img class="logo-footer" src="<?php echo $this->assetsBase; ?>/images/footer_logo.png" alt="" />
                <p><?php echo Yii::t('main', 'Мы направляем наши усилия на поиск, поддержку и продвижение одаренных и талантливых детей, инновационных проектов по раскрытию способностей и созданию возможностей для развития юных дарований.') ?></p> 
                <div class="footer-help">  
                    <div>	
                        <a href="<?php echo $this->createUrl('/default/help'); ?>" style="width:200px;">
                            <?php echo Yii::t('main', 'Нужна помощь фонда?'); ?>
                        </a>
                    </div>	
                </div>       
            </div>
            <div class="col-md-4 col-sm-4  icon-adress">
                <h3><?php echo Yii::t('main', 'Контакты'); ?></h3>
                <p>
                    <i class="fa fa-home"></i> 
                    <?php echo Yii::t('main', '04300, Украина, Киев'); ?><br />
                    <?php echo Yii::t('main', 'ул. Днепровская набережная 26Ж'); ?>
                </p>
                <p>
                    <i class="fa fa-skype"></i> 
                    <a href="skype:blago-vest.org?chat">blago-vest.org</a>
                </p>
                <p>
                    <i class="fa fa-envelope"></i> 
                    <a href="mailto:info@blago-vest.org">info@blago-vest.org</a>
                </p>
                <div class="footer-help">
                    <a href="<?php echo $this->createUrl('/default/contacts'); ?>" style="width:200px;">
                        <?php echo Yii::t('main', 'обратная связь'); ?>
                    </a>

                </div>
            </div>
            <div class="col-md-4 col-sm-4 subscribe" style="padding: 0;">
                <h3><?php echo Yii::t('main', 'Оформите подписку'); ?></h3>
                <?php $this->widget('SubscribeWidget'); ?>

                <div class="social" style="float:left;">
                    <h3><?php echo Yii::t('main', 'Мы в соцсетях'); ?></h3>
                    <a href="http://vk.com/fundblagovest" target="_blank">
                        <i class="fa fa-vk"></i>
                    </a>
                    <a href="https://www.facebook.com/groups/1584264545157407/" target="_blank">
                        <i class="fa fa-facebook"></i>
                    </a>
                    
                    
                    

                    <a href="http://ok.ru/group/52532506001616" target="_blank">
                        <i class="fa"><img style="margin: 0 8px 2px;position: relative;top: -2px;" src="<?php echo $this->assetsBase; ?>/images/ok.png"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UCMyRfi5RTZryr869sXWi3WA" target="_blank">
                        <i class="fa fa-caret-right"></i>
                    </a>
                </div>
                
<div class="footer-help" style="float:right;"> 
                        <a href="<?php echo $this->createUrl('/default/volonter'); ?>" style="width:180px; margin-top:13px;">
    <?php echo Yii::t('main', 'стать волонтером'); ?>
                        </a>

            </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid footer">
    <p>© Copyright <?php echo date('Y'); ?>. Все права защищены. Разработано в <a target="_blank" href="http://crystal-it.biz">Crystal-IT</a></p>
</div>

<!-- Start SiteHeart code -->
<script>
    (function () {
        var widget_id = 780715;
        _shcp = [{widget_id: widget_id}];
        var lang = (navigator.language || navigator.systemLanguage || navigator.userLanguage || "en").substr(0, 2).toLowerCase();
        var url = "widget.siteheart.com/widget/sh/" + widget_id + "/" + lang + "/widget.js";
        var hcc = document.createElement("script");
        hcc.type = "text/javascript";
        hcc.async = true;
        hcc.src = ("https:" == document.location.protocol ? "https" : "http") + "://" + url;
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hcc, s.nextSibling);
    })();
</script>
<!-- End SiteHeart code -->