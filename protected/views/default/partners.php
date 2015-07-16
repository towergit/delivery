<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'Партнеры'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Партнеры'),
);

$this->showHeadering = false;
?>
<div class="container team-parthners">
    <div class="row ">
        <h1>Наши партнеры</h1>
        <p>Мы высоко ценим уровень сотрудничества с нашими партнерами и благодарим Вас за поддержку и вдохновение! Вместе мы меняем мир к лучшему, доброму и светлому. Каждый может присоединиться и сделать шаг на пути к нашей общей и благородной цели.</p> 
        <p>Узнайте подробнее о том, как стать партнером фонда Благовест.</p>
        <?php foreach ($partners as $key => $val): ?>
            <div class="col-md-4">
                <a target="_blank" href="<?php echo $val['url']; ?>"><img src="<?php echo $this->assetsBase . $val['img']; ?>" alt="" />
                    <h4 style="color: black;"><?php echo $val['name']; ?></h4></a>
                <p><?php echo $val['text']; ?></p>
            </div>
        <?php endforeach; ?>

        <div class="col-md-8 restore-banner">
            <video width="728" height="90" loop="" autoplay="" style="margin-top: 48px;">                        
                <source type="video/mp4" src="https://blago-vest.org/uploads/banners/banner 728-90_x264.mp4"></source>                        
                <source type="video/webm" src="https://blago-vest.org/uploads/banners/banner 728-90_x264.webm"></source> 
                <source type="video/ogg" src="https://blago-vest.org/uploads/banners/banner 728-90_x264.ogv"></source>   
            </video>   
            <div class="help">
                <!-- Button trigger modal -->
                <a  id="show-banners">
                    Разместите баннер у себя на сайте
                </a>
            </div>

        </div>

    </div>
    <hr style="width: 100%;border-width: 1px 0 0;border-top-color:black;"> 
    
    <div  class="row" id="banner-list" style="display: none;">
        <div class="col-md-12">
            <p><?php echo htmlentities('Для установки баннера у Вас на сайте - нажмите на кнопку «Показать код»  скопируйте и вставьте его перед закрывающим тегом </body> .'); ?></p>
        </div>
        <div class="col-md-3">
            <div class="banner banner1">                
                <a target="_blank" href="https://blago-vest.org/">                    
                    <video width="160" height="600" loop="" autoplay="">                        
                        <source type="video/mp4" src="https://blago-vest.org/uploads/banners/banner 160-600_x264.mp4"></source>                        
                        <source type="video/webm" src="https://blago-vest.org/uploads/banners/banner 160-600_x264.webm"></source> 
                        <source type="video/ogg" src="https://blago-vest.org/uploads/banners/banner 160-600_x264.ogv"></source>  
                    </video>                
                </a>  
                <div class="help">
                    <!-- Button trigger modal -->
                    <a  class="" data-toggle="modal" data-target="#code1">
                        Показать код
                    </a>
                </div>
            </div>
        </div>



        <div class="col-md-6">
            <div class="banner banner4">                
                <a target="_blank" href="https://blago-vest.org/">            
                    <video width="468" height="60" loop="" autoplay="">          
                        <source type="video/mp4" src="https://blago-vest.org/uploads/banners/banner 468-60_x264.mp4"></source>
                        <source type="video/webm" src="https://blago-vest.org/uploads/banners/banner 468-60_x264.webm"></source> 
                        <source type="video/ogg" src="https://blago-vest.org/uploads/banners/banner 468-60_x264.ogv"></source>            
                    </video>       
                </a>
                <br>
                <div class="help">
                    <a  class="" data-toggle="modal" data-target="#code4">
                        Показать код
                    </a>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div class="banner banner5">                
                <a target="_blank" href="https://blago-vest.org/">                    
                    <video width="728" height="90" loop="" autoplay="">                        
                        <source type="video/mp4" src="https://blago-vest.org/uploads/banners/banner 728-90_x264.mp4"></source>                        
                        <source type="video/webm" src="https://blago-vest.org/uploads/banners/banner 728-90_x264.webm"></source> 
                        <source type="video/ogg" src="https://blago-vest.org/uploads/banners/banner 728-90_x264.ogv"></source>   
                    </video>                
                </a> 
                <br>
                <div class="help">
                    <a  class="" data-toggle="modal" data-target="#code5">
                        Показать код
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="banner banner3">                
                <a target="_blank" href="https://blago-vest.org/">                    
                    <video width="336" height="280" loop="" autoplay="">                        
                        <source type="video/mp4" src="https://blago-vest.org/uploads/banners/banner 336-280_x264.mp4"></source>                        
                        <source type="video/webm" src="https://blago-vest.org/uploads/banners/banner 336-280_x264.webm"></source>                        
                        <source type="video/ogg" src="https://blago-vest.org/uploads/banners/banner 336-280_x264.ogv"></source>                    </video>                

                </a>

                <div class="help">
                    <a  class="" data-toggle="modal" data-target="#code3">
                        Показать код
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">


            <div class="banner banner2">                
                <a target="_blank" href="https://blago-vest.org/">                    
                    <video width="300" height="250" loop="" autoplay="">                        
                        <source type="video/mp4" src="https://blago-vest.org/uploads/banners/banner 300-250_x264.mp4"></source>                        
                        <source type="video/webm" src="https://blago-vest.org/uploads/banners/banner 300-250_x264.webm"></source> 
                        <source type="video/ogg" src="https://blago-vest.org/uploads/banners/banner 300-250_x264.ogv"></source>   
                    </video>


                </a>    
                <br>
                <div class="help">
                    <a  class="" data-toggle="modal" data-target="#code2">
                        Показать код
                    </a>
                </div>
            </div>

        </div>
<div class="col-md-12">
         <hr style="width: 100%;border-width: 1px 0 0;border-top-color:black;"> 
</div>
    </div>
            <?php foreach ($partners2 as $key => $val): ?>
            <div class="col-md-4">
                <a target="_blank" href="<?php echo $val['url']; ?>"><img src="<?php echo $this->assetsBase . $val['img']; ?>" alt="" />
                    <h4 style="color: black;"><?php echo $val['name']; ?></h4></a>
                <p><?php echo $val['text']; ?></p>
            </div>
        <?php endforeach; ?>
</div>


<br>





<!-- Modal -->
<div class="modal fade" id="code1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Код для вставки</h4>
            </div>
            <div class="modal-body">
                <div style="text-align: left;" class="baner_code" id="banner_5">

                    <code>
                        <p>&lt;!-- Blago-vest.org banner №1 --&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script src="https://blago-vest.org/uploads/banners/banner.js"&gt;&lt;/script&gt;</p>

                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script type="text/javascript"&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; blagoVestBanner.init({<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; bannerName: 'c4ca4238a0b923820dcc509a6f75849b',<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //referralId: 'ref_id' referalId (Oprional)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //class: 'myClass' css class for customize (Oprional)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; });<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;/script&gt;<br>
                            &lt;!-- / End Blago-vest.org banner --&gt;</p>
                    </code>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="code2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Код для вставки</h4>
            </div>
            <div class="modal-body">
                <div style="text-align: left;" class="baner_code" id="banner_5">
                    <code>
                        <p>&lt;!-- Blago-vest.org banner №2 --&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script src="https://blago-vest.org/uploads/banners/banner.js"&gt;&lt;/script&gt;</p>

                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script type="text/javascript"&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; blagoVestBanner.init({<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; bannerName: 'c81e728d9d4c2f636f067f89cc14862c',<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //referralId: 'ref_id' referalId (Oprional)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //class: 'myClass' css class for customize (Oprional)<br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; });<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;/script&gt;<br>
                            &lt;!-- / End Blago-vest.org banner --&gt;</p>
                    </code>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="code3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Код для вставки</h4>
            </div>
            <div class="modal-body">
                <div style="text-align: left;" class="baner_code" id="banner_5">
                    <code>

                        <p>&lt;!-- Blago-vest.org banner №3 --&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script src="https://blago-vest.org/uploads/banners/banner.js"&gt;&lt;/script&gt;</p>

                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script type="text/javascript"&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; blagoVestBanner.init({<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; bannerName: 'eccbc87e4b5ce2fe28308fd9f2a7baf3',<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //referralId: 'ref_id' referalId (Oprional)<br>
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //class: 'myClass' css class for customize (Oprional)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; });<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;/script&gt;<br>
                            &lt;!-- / End Blago-vest.org banner --&gt;</p>
                    </code>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="code4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Код для вставки</h4>
            </div>
            <div class="modal-body">
                <div style="text-align: left;" class="baner_code" id="banner_5">
                    <code>

                        <p>&lt;!-- Blago-vest.org banner №4 --&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script src="https://blago-vest.org/uploads/banners/banner.js"&gt;&lt;/script&gt;</p>

                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script type="text/javascript"&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; blagoVestBanner.init({<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; bannerName: 'a87ff679a2f3e71d9181a67b7542122c',<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //referralId: 'ref_id' referalId (Oprional)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //class: 'myClass' css class for customize (Oprional)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; });<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;/script&gt;<br>
                            &lt;!-- / End Blago-vest.org banner --&gt;</p>
                    </code>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="code5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Код для вставки</h4>
            </div>
            <div class="modal-body">
                <div style="text-align: left;" class="baner_code" id="banner_5">
                    <code>
                        <p>&lt;!-- Blago-vest.org banner №5 --&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script src="https://blago-vest.org/uploads/banners/banner.js"&gt;&lt;/script&gt;</p>

                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;script type="text/javascript"&gt;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; blagoVestBanner.init({<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; bannerName: 'e4da3b7fbbce2345d7772b0674a318d5',<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //referralId: 'ref_id' referalId (Oprional)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //class: 'myClass' css class for customize (Oprional)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; });<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;/script&gt;<br>
                            &lt;!-- / End Blago-vest.org banner --&gt;</p>
                    </code>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript(uniqid(), "
        $(document).ready(function() {
        
            $('#show-banners').on('click',function() {
                    $('#banner-list').show();
                   var topOffset = $(\"#banner-list\").offset().top;
            $('html, body').animate({
                scrollTop: topOffset - 100
            }, 500);
    
                })
                });
    ", CClientScript::POS_END);
