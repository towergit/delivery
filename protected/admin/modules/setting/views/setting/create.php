<?php
$form = $this->beginWidget('BsActiveForm', array(
	'id' => 'setting-form',
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
		'headerIcon' => 'fa fa-gears',
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
			<?php echo $form->textFieldControlGroup($main, 'param'); ?>
			<?php echo $form->textFieldControlGroup($main, 'label'); ?>
			<?php echo $form->textFieldControlGroup($main, 'description'); ?>
			<?php echo $form->dropDownListControlGroup($main, 'type', $main->types, array( 'empty' => 'Выберите тип' )); ?>
			<?php echo $form->textFieldControlGroup($main, 'value'); ?>
			
			<div class="panel panel-padding panel-default" id="sub">
				<table class="table table-striped">
					<tbody>
						<?php for ($i = 0; $i < 5; $i++): ?>
						<tr>
							<td>
								<?php echo $form->textField($sub, "[$i]title"); ?>
							</td>
							<td>
								<?php echo $form->textField($sub, "[$i]value"); ?>
							</td>
							<td width="37">
								<input type="radio" name="radio" value="<?php echo $i; ?>" <?php if ($i == 0): ?>checked="checked"<?php endif; ?> />
							</td>
						</tr>
						<?php endfor; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>

<script>
	var main = 'MainSetting',
		type = $('#' + main + '_type'),
		value = $('#' + main + '_value');
	
	type.change(function() {
		var val = $(this).val();
		
		if (val == 'list') {
			$('#sub').show();
			value.parents('.form-group').addClass('hidden')
		} else {
			$('#sub').hide();
			value.parents('.form-group').removeClass('hidden');
		}
	}).change();
</script>