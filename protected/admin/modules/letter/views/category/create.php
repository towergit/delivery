<?php
$form = $this->beginWidget('BsActiveForm', array(
	'id' => 'category-form',
	'enableAjaxValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	'htmlOptions' => array( 'role' => 'form' ),
));
?>

<?php
$box = $this->beginWidget(
	'booster.widgets.TbPanel',
	array(
		'title' => CHtml::encode($this->pageTitle),
		'padContent' => false,
		'headerIcon' => 'fa fa-send',
		'headerButtons' => array(
			array(
				'class' => 'booster.widgets.TbButtonGroup',
				'buttonType' => 'link',
				'context' => 'danger',
				'buttons' => array(
					array(
						'label' => 'Отмена',
						'icon' => 'fa fa-times',
						'url' => array( 'index' ),
					),
				),
			),
			array(
				'class' => 'booster.widgets.TbButtonGroup',
				'buttonType' => 'submit',
				'context' => 'success',
				'buttons' => array(
					array( 
						'label' => 'Сохранить',
						'icon' => 'fa fa-floppy-o',
						'htmlOptions' => array(
							'name' => 'button',
							'value' => 'index',
						)
					),
					array( 
						'label' => 'Сохранить и создать', 
						'icon' => 'fa fa-plus-circle',
						'htmlOptions' => array(
							'name' => 'button',
							'value' => 'create',
						)
					),
				),
			),
		),
		'htmlOptions' => array( 'class' => 'panel-table' ),
	)
);
$this->endWidget();
?>

<div class="panel panel-padding">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $form->textFieldControlGroup($model, 'title'); ?>
			<?php echo $form->checkBoxControlGroup($model, 'active'); ?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>