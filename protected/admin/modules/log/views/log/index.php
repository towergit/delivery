<div class="row">
	<div class="col-sm-12">
		<?php
		$box = $this->beginWidget(
			'booster.widgets.TbPanel',
			array(
				'title' => CHtml::encode($this->pageTitle),
				'padContent' => false,
				'headerIcon' => 'fa fa-list-alt',
				'headerButtons' => array(
					array(
						'class' => 'booster.widgets.TbButtonGroup',
						'buttonType' => 'link',
						'context' => 'danger',
						'buttons' => array(
							array(
								'label' => 'Очистить',
								'icon'=>'fa fa-eraser',
								'url' => array( 'clean' ),
								'visible' => Yii::app()->user->checkAccess('cleanLog'),
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
				'template' => "{items}\n{pager}",
				'columns' => array(
					array(
						'name' => 'user_id',
						'value' => '$data->user->username',
					),
					array(
						'name' => 'item',
						'type' => 'raw',
						'value' => '$data->event',
					),
					array(
						'name' => 'created',
						'value' => 'Date::format($data->created)',
					),
					array(
						'class' => 'booster.widgets.TbButtonColumn',
						'template' => '{view} {delete}',
						'buttons'		 => array(
							'view' => array(
								'visible' => 'Yii::app()->user->checkAccess("updateLog")',
							),
							'delete' => array(
								'visible' => 'Yii::app()->user->checkAccess("deleteLog")',
							),
						),
						'htmlOptions' => array( 
							'nowrap' => 'nowrap',
						),
						'visible' => 
							Yii::app()->user->checkAccess("updateLog") ||
							Yii::app()->user->checkAccess("deleteLog"),
					)
				),
			)
		);
		$this->endWidget();
		?>
	</div>
</div>