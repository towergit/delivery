<?php
// название страницы
$this->pageTitle = Yii::t('share', 'Редакитование заявки на покупку акций');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('share', 'Акции'),
    Yii::t('share', 'Заявки на покупку акций')               => array( 'index' ),
    Yii::t('share', 'Редакитование заявки на покупку акций') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'sharepurchase-form',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions'          => array(
        'role' => 'form'
    ),
    ));

$box  = $this->beginWidget('booster.widgets.TbPanel',
    array(
    'title'         => CHtml::encode($this->pageTitle),
    'padContent'    => false,
    'headerIcon'    => Yii::app()->getModule('share')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('share', 'Отмена'),
                    'icon'  => 'fa fa-times',
                    'url'   => array( 'index' ),
                ),
            ),
        ),
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'submit',
            'context'    => 'success',
            'buttons'    => array(
                array(
                    'label'       => $model->isNewRecord 
                        ? Yii::t('share', 'Добавить и продолжить') 
                        : Yii::t('share', 'Сохранить и продолжить'),
                    'icon'        => $model->isNewRecord 
                        ? 'fa fa-plus-circle' 
                        : 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name'  => 'submit-type',
                        'value' => $model->isNewRecord ? 'create' : 'refresh',
                    )
                ),
            ),
        ),
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'submit',
            'context'    => 'success',
            'buttons'    => array(
                array(
                    'label'       => $model->isNewRecord 
                        ? Yii::t('share', 'Добавить и закрыть') 
                        : Yii::t('share', 'Сохранить и закрыть'),
                    'icon'        => 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name'  => 'submit-type',
                        'value' => 'index',
                    )
                ),
            ),
        ),
    ),
    'htmlOptions'   => array(
        'class' => 'panel-table'
    ),
    ));
$this->endWidget();
?>

<div class="panel panel-padding">
    <?php echo $form->dropDownListControlGroup($model, 'type_id', $type->typeList); ?>
    <?php echo $form->textFieldControlGroup($model, 'count'); ?>
    <?php echo $form->textFieldControlGroup($model, 'price'); ?>
    <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
    <?php $data = CJSON::decode($model->data); ?>

    <?php if (isset($data['surname'])): ?>
        <div class="form-group">
            <label class="control-label">Фамилия</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['surname']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['name'])): ?>
        <div class="form-group">
            <label class="control-label">Имя</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['name']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['patronymic'])): ?>
        <div class="form-group">
            <label class="control-label">Отчество</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['patronymic']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['birth_date'])): ?>
        <div class="form-group">
            <label class="control-label">Дата рождения</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['birth_date']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['country'])): ?>
        <div class="form-group">
            <label class="control-label">Страна</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['country']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['city'])): ?>
        <div class="form-group">
            <label class="control-label">Город</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['city']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['add_index'])): ?>
        <div class="form-group">
            <label class="control-label">Индекс</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['add_index']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['address'])): ?>
        <div class="form-group">
            <label class="control-label">Адресс</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['address']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['phone'])): ?>
        <div class="form-group">
            <label class="control-label">Телефон</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['phone']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['wmz'])): ?>
        <div class="form-group">
            <label class="control-label">Кошелек</label>
            <div>
                <input readonly="readonly" class="form-control" type="text" value="<?php echo $data['wmz']; ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($data['comment'])): ?>
        <div class="form-group">
            <label class="control-label">Примечание</label>
            <div>
                <textarea readonly="readonly" class="form-control">
                    <?php echo $data['comment']; ?>
                </textarea>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $this->endWidget(); ?>