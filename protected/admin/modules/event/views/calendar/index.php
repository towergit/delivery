<div class="row">
    <div class="col-sm-3">
        <?php if ($models !== null): ?>
        <div class="grey block">
            <div class="title">Категории</div>
            <ul>
                <?php foreach ($models as $model): ?>
                <li>
                    <div style="background:<?php echo $model->color; ?>" class="square"></div>
                    <?php echo $model->title; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
    <div class="col-sm-9">
        <?php
        $this->widget('ext.EFullCalendar.EFullCalendar',
            array(
        //    'themeCssFile' => 'cupertino/theme.css',
            'lang'        => Yii::app()->language,
            'htmlOptions' => array(
                'style' => 'width:100%'
            ),
            'options'     => array(
                'header'         => array(
                    'left'   => 'prev,next, today',
                    'center' => 'title',
                    'right'  => 'month,agendaWeek,agendaDay'
                ),
                'editable'       => true,
        //        'selectable'     => true,
//                'lazyFetching'   => true,
                'events'         => $this->createUrl('/event/calendar/demo'),
        //        'eventMouseover' => new CJavaScriptExpression("js_function_callback")
            )
        ));
        ?>
    </div>
</div>