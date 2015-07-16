<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Управляющие');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Управляющие') => array( 'index' ),
);

$pageCount = Yii::app()->session['pageCount'] ? Yii::app()->session['pageCount'] : 10;
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('user')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('user', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createUserManager')
                        ),
                    ),
                ),
            ),
            'htmlOptions'   => array(
                'class' => 'panel-table'
            ),
        ));
        $this->widget('booster.widgets.TbExtendedGridView',
            array(
            'type'            => 'striped',
            'responsiveTable' => true,
            'dataProvider'    => $model->search(),
            'filter'          => $model,
            'template'        => "{items}\n{pager}",
            'afterAjaxUpdate' => "function() { 
		$('#Manager_create_date, #Manager_last_visit').datepicker({
                    format: 'dd.mm.yyyy'
		}); 
            }",
            'columns'         => array(
                array(
                    'name'        => 'id',
                    'htmlOptions' => array(
                        'style' => 'width: 60px;',
                    ),
                ),
                'username',
                'email',
                array(
                    'name'  => 'phone',
                    'value' => '$data->profile->phone',
                ),
                array(
                    'name'        => 'create_date',
                    'value'       => 'Date::format($data->create_date)',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'create_date',
                        'options'     => array(
                            'lang'   => Yii::app()->language,
                            'format' => 'dd.mm.yyyy',
                        ),
                        'htmlOptions' => array(
                            'class'       => 'form-control',
                            'placeholder' => '',
                        ),
                        ), true
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 130px; text-align: center;',
                    ),
                ),
                array(
                    'name'        => 'last_visit',
                    'value'       => '$data->last_visit !== null ? Date::format($data->last_visit) : "' . Yii::t('user',
                        'никогда') . '"',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'last_visit',
                        'options'     => array(
                            'lang'   => Yii::app()->language,
                            'format' => 'dd.mm.yyyy',
                        ),
                        'htmlOptions' => array(
                            'class'       => 'form-control',
                            'placeholder' => '',
                        ),
                        ), true
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 130px; text-align: center;',
                    ),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updateUserManager'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateUserManager")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteUserManager")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                    Yii::app()->user->checkAccess("updateUserManager")
                    || Yii::app()->user->checkAccess("deleteUserManager")
                )
            ),
        ));
        $this->endWidget();
        ?>
    </div>
</div>

<?php /*
<?php
$selectPageCount = array(
    '1'      => '1',
    '2'      => '2',
    '30'      => '30',
    '50'      => '50',
    '100'     => '100',
    '500'     => '500',
    '1000000' => 'Все',
);
?>

<table>
    <tr>
        <td style="text-align: right;">
            Записей на странице: 
            <?php echo CHtml::dropDownList('',
                Yii::app()->session['postPageCount'] ? Yii::app()->session['postPageCount'] : 10,
                $selectPageCount,
                array( 'onchange' => "document.location.href='/" . Yii::app()->request->pathInfo . "?pageCount='+this.value;" )); ?>
        </td>
    </tr>
</table> 
 */?>