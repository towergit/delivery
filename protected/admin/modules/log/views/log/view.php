<div class="row">
	<div class="col-sm-12">
		<h3><?php echo $model->event; ?></h3>
		
		<div class="row">
			<div class="col-sm-6">
				<h4>Общее</h4>
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th>Модуль</th>
							<td><?php echo $model->module; ?></td>
						</tr>
						<tr>
							<th>Модель</th>
							<td><?php echo $model->model; ?></td>
						</tr>
						<tr>
							<th>Таблица</th>
							<td><?php echo $model->table; ?></td>
						</tr>
						<tr>
							<th>Операция</th>
							<td><?php echo $model->operation; ?></td>
						</tr>
						<tr>
							<th>Пользователь</th>
							<td><?php echo $model->user->username; ?></td>
						</tr>
						<tr>
							<th>Дата выполнения</th>
							<td><?php echo Date::format($model->created); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-6">
				<?php if (!empty($model->params)): ?>
				<?php $params = CJSON::decode($model->params); ?>
				<h4>Редактируемые поля</h4>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Атрибут</th>
							<th>Было</th>
							<th>Стало</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($params as $key => $value): ?>
						<tr>
							<td><?php echo $model->getParam($key); ?></td>
							<td><?php echo $value[0]; ?></td>
							<td><?php echo $value[1]; ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>