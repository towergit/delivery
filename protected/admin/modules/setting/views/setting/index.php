<?php echo BsHtml::beginForm(); ?>

<?php
$box = $this->beginWidget(
	'booster.widgets.TbPanel',
	array(
		'title' => CHtml::encode($this->pageTitle),
		'padContent' => false,
		'headerIcon' => 'fa fa-gears',
		'headerButtons' => array(
			array(
				'class' => 'booster.widgets.TbButtonGroup',
				'buttonType' => 'link',
				'context' => 'success',
				'buttons' => array(
					array( 
						'label' => 'Добавить',
						'icon'=>'fa fa-plus',
						'url' => array( 'create' ),
						'visible' => Yii::app()->user->checkAccess('superadministrator'),
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
						'visible' => $items,
						'htmlOptions' => array(
							'name' => 'button',
						)
					),
				),
			),
		),
		'htmlOptions' => array('class' => 'panel-table'),
	)
);
$this->endWidget();
?>

<?php if ($items): ?>
<div class="panel">
	<!-- начало: вкладки -->
	<ul class="nav nav-tabs nav-tabs-simple" role="tablist">
		<li class="active">
			<a href="#tab1" data-toggle="tab" role="tab">Основные</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<?php /*
			<?php foreach ($items as $key => $item): ?>
				<?php if ($item->parent_id == 0): ?>
					<div class="form-group">
						<?php echo BsHtml::activeLabel($item, $item->label, array( 'class' => 'control-label' )); ?>
						<?php 
						switch ($item->type)
						{
							case 'char': echo BsHtml::activeTextField($item, "[$key]value");
								break;
							case 'text': echo BsHtml::activeTextArea($item, "[$key]value");
								break;
							case 'check': echo BsHtml::activeCheckBox($item, "[$key]value");
								break;
							case 'radio': echo BsHtml::activeRadioButton($item, "[$key]value");
								break;
							case 'list': echo BsHtml::activeDropDownList($item, "[$key]value", $parentElement);
								break;
						}
						?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			*/ ?>
		</div>
	</div>
	<!-- конец: вкладки -->
</div>
<?php endif; ?>

<?php echo BsHtml::endForm(); ?>