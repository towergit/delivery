<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'Отчеты'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Отчеты'),
);
?>

<div class="container reports">
    <div class="row">
        <h2>Отчеты по выполненным работам</h2>
        <h4>Отчетов пока что нет.</h4>
        
        <!-- <form class="form-inline" role="form">
            <div class="form-group">
                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Дата с">
            </div>
            <button type="submit" class="btn-reports" style="position: relative;top:10px;"><i class="fa fa-long-arrow-right"></i><i class="fa fa-long-arrow-left"></i></button>
            <div class="form-group">
                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Дата по">
            </div>
        </form>
        <div class="col-md-4">
            <h4>Помощь голодающим детям африки</h4>
            <img src="images/child.jpg" alt="" />
            <p>Как тяжело быть голодным ребенком и жить в Африке...</p>
            <div class="print">
                <a href="">Распечатать</a>
            </div>
        </div>
        <div class="col-md-4">
            <h4>Помощь голодающим детям африки</h4>
            <img src="images/child.jpg" alt="" />
            <p>Как тяжело быть голодным ребенком и жить в Африке...</p>
            <div class="print">
                <a href="">Распечатать</a>
            </div>
        </div>
        <div class="col-md-4">
            <h4>Помощь голодающим детям африки</h4>
            <img src="images/child.jpg" alt="" />
            <p>Как тяжело быть голодным ребенком и жить в Африке...</p>
            <div class="print">
                <a href="">Распечатать</a>
            </div>
        </div>-->
    </div>
</div>
 <?php

        Yii::app()->clientScript->registerScript(uniqid(), "
                $(document).ready(function() {
                    $('#owl-demo').owlCarousel({
                        autoPlay: 5000,
                        items: 3,
                        itemsDesktop: [1199, 3],
                        itemsDesktopSmall: [979, 3],
                        rewindSpeed: 4000
                    });
                    
                });
            ", CClientScript::POS_END);
        ?>