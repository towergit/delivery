<div class="row">
	<div class="col-sm-12">
		<?php
		$box = $this->beginWidget(
			'booster.widgets.TbPanel',
			array(
				'title' => CHtml::encode($this->pageTitle),
				'padContent' => false,
				'headerIcon' => 'fa fa-credit-card',
				'htmlOptions' => array('class' => 'panel-table'),
			)
		);
		$this->widget('booster.widgets.TbExtendedGridView',
			array(
				'type' => 'striped',
				'responsiveTable' => true,
				'dataProvider' => $model->search(),
				'filter' => $model,
				'template' => "{items}\n{pager}",
				'columns' => array(
					array(
						'name' => 'code',
						'htmlOptions' => array(
							'width' => 130,
						),
					),
					'email',
					array(
						'name' => 'sum',
						'htmlOptions' => array(
							'width' => 100,
						),
					),
					array(
						'name' => 'system_id',
						'value' => '$data->system->title',
						'filter' => $system->systemList,
					),
					array(
						'name' => 'lecture',
						'htmlOptions' => array(
							'width' => 100,
						),
					),
					array(
						'name' => 'status',
						'value' => '$data->getStatus()',
						'filter' => $model->statusList,
					),
					array(
						'name' => 'created',
						'value' => 'Date::format($data->created)',
						'htmlOptions' => array(
							'width' => 130,
						),
					),
					array(
						'class' => 'booster.widgets.TbToggleColumn',
						'toggleAction' => 'toggle',
						'name' => 'confirmed',
						'filter' => $model->confirmedStatusList,
						'visible' => Yii::app()->user->checkAccess('updatePaymentLecture'),
					),
					array(
						'class' => 'booster.widgets.TbButtonColumn',
						'template' => '{update} {delete}',
						'buttons'		 => array(
							'update' => array(
								'visible' => 'Yii::app()->user->checkAccess("updatePaymentLecture")',
							),
							'delete' => array(
								'visible' => 'Yii::app()->user->checkAccess("deletePaymentLecture")',
							),
						),
						'htmlOptions' => array( 
							'nowrap' => 'nowrap',
						),
						'visible' => 
							Yii::app()->user->checkAccess("updatePaymentLecture") || 
							Yii::app()->user->checkAccess("deletePaymentLecture")
					)
				),
			)
		);
		$this->endWidget();
		?>
	</div>
</div>