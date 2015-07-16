<?php
// название страницы
$this->pageTitle = Yii::t('ticket', 'Просмотр сообщений тикета');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('ticket', 'Тикеты'),
    Yii::t('ticket', 'Список тикетов')            => array( 'index' ),
    Yii::t('ticket', 'Просмотр сообщений тикета') => $this->createUrl('view',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);
?>

<?php if ($models !== null): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="ticket">
                <?php foreach($models as $item): ?>
                    <div class="block <?php echo $item->user_id !== null ? 'user' : 'manager'; ?>">
                        <?php echo $item->message; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<br />
<div class="row">
    <div class="col-sm-9">
        <?php
        $form = $this->beginWidget('BsActiveForm', array(
            'id'                   => 'ticketmessage-form',
            'enableAjaxValidation' => true,
            'clientOptions'        => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions'          => array( 
                'role' => 'form'
            ),
        ));
        ?>
        <div class="form-group">
            <?php $model->ticket_id = Yii::app()->request->getQuery('id'); ?>
            <?php echo $form->hiddenField($model, 'ticket_id'); ?>
            <?php echo $form->labelEx($model, 'message'); ?>
            <?php
            $this->widget('booster.widgets.TbRedactorJs',
                array(
                'model'     => $model,
                'attribute' => 'message',
                'editorOptions' => array(
                    'lang' => Yii::app()->language,
                    'minHeight' => '100',
                ),
            ));
            ?>
            <?php echo $form->error($model, 'message'); ?>
        </div>
        <?php echo BsHtml::submitButton(Yii::t('ticket', 'Ответить')); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>