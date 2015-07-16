<div class="row">
	<div class="col-sm-12">
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
						'context' => 'success',
						'buttons' => array(
							array( 
								'label' => 'Добавить',
								'icon'=>'fa fa-plus',
								'url' => array( 'create' ),
								'visible' => Yii::app()->user->checkAccess('administrator'),
							),
						),
					),
				),
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
					'title',
					array(
						'name' => 'create_date',
						'value' => 'Date::format($data->create_date)',
					),
					array(
						'class' => 'booster.widgets.TbToggleColumn',
						'toggleAction' => 'toggle',
						'name' => 'active',
						'filter' => $model->activeStatusList,
						'visible' => Yii::app()->user->checkAccess('administrator'),
					),
					array(
						'class' => 'booster.widgets.TbButtonColumn',
						'template' => '{update} {delete}',
						'buttons'		 => array(
							'update' => array(
								'visible' => 'Yii::app()->user->checkAccess("administrator")',
							),
							'delete' => array(
								'visible' => 'Yii::app()->user->checkAccess("administrator")',
							),
						),
						'htmlOptions' => array( 
							'nowrap' => 'nowrap',
						),
						'visible' => 
							Yii::app()->user->checkAccess("administrator") || 
							Yii::app()->user->checkAccess("administrator")
					)
				),
			)
		);
		$this->endWidget();
		?>
	</div>
</div>