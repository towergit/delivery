<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Список подписчиков');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Список подписчиков') => array( 'index' ),
);

?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box       = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('user')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
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
		$('#User_create_date, #User_last_visit').datepicker({
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
                'email',
                'phone',
                'first_name',
                'last_name',
                'patronymic',
                'role',
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'subscribe',
                ),
            ),
        ));
        $this->endWidget();
        ?>
    </div>
</div>

<?php
/*
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