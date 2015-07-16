<?php
$form = $this->beginWidget('BsActiveForm', array(
	'id' => 'payment-lecture-form',
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
		'headerIcon' => 'fa fa-credit-card',
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
			<?php echo $form->textFieldControlGroup($model, 'code', array( 'readonly' => true )); ?>
			<?php echo $form->dropDownListControlGroup($model, 'system_id', $system->systemList, array( 'disabled' => true )); ?>
			<?php echo $form->textFieldControlGroup($model, 'sum', array( 'readonly' => true )); ?>
			<?php echo $form->textFieldControlGroup($model, 'email', array( 'readonly' => true )); ?>
			
			<?php $data = CJSON::decode($model->data); ?>
			
			<?php if (isset($data['firstname'])): ?>
			<div class="form-group">
				<label class="control-label">Имя</label>
				<div>
					<input readonly="readonly" class="form-control" type="text" value="<?php echo $data['firstname']; ?>">
				</div>
			</div>
			<?php endif; ?>
			
			<?php if (isset($data['lastname'])): ?>
			<div class="form-group">
				<label class="control-label">Фамилия</label>
				<div>
					<input readonly="readonly" class="form-control" type="text" value="<?php echo $data['lastname']; ?>">
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
			
			<?php if (isset($data['phone'])): ?>
			<div class="form-group">
				<label class="control-label">Телефон</label>
				<div>
					<input readonly="readonly" class="form-control" type="text" value="<?php echo $data['phone']; ?>">
				</div>
			</div>
			<?php endif; ?>
			
			<?php if (isset($data['discount'])): ?>
			<div class="form-group">
				<label class="control-label">Скидка</label>
				<div>
					<input readonly="readonly" class="form-control" type="text" value="<?php echo $data['discount']; ?>">
				</div>
			</div>
			<?php endif; ?>
			
			<?php if (isset($data['purse'])): ?>
			<div class="form-group">
				<label class="control-label">Кошелек</label>
				<div>
					<input readonly="readonly" class="form-control" type="text" value="<?php echo $data['purse']; ?>">
				</div>
			</div>
			<?php endif; ?>
			
			<?php if (isset($data['note'])): ?>
			<div class="form-group">
				<label class="control-label">Примечание</label>
				<div>
					<textarea readonly="readonly" class="form-control">
						<?php echo $data['note']; ?>
					</textarea>
				</div>
			</div>
			<?php endif; ?>
			
			<?php echo $form->textFieldControlGroup($model, 'lecture', array( 'readonly' => true )); ?>
			<?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
			<?php echo $form->checkBoxControlGroup($model, 'confirmed'); ?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>