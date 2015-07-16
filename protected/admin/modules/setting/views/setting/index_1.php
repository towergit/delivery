<?php
if ($items):
echo BsHtml::beginForm();

foreach($items as $i => $item)
{
	if ($item->type == 'char')
	{
		?>
		<div class="row">
			<div class="col-md-12">
				<?php echo BsHtml::activeLabel($item, $item->label); ?>
				<br />
				<?php echo BsHtml::activeTextField($item, "[$i]value"); ?>
			</div>
		</div>
		<br />
		<?php
	}
	else if ($item->type == 'text')
	{
		?>
		<div class="row">
			<div class="col-md-12">
				<?php echo BsHtml::activeLabel($item, $item->label); ?>
				<br />
				<?php echo BsHtml::activeTextArea($item, "[$i]value"); ?>
			</div>
		</div>
		<br />
		<?php
	}
	else if ($item->type == 'check')
	{
		?>
		<div class="row">
			<div class="col-md-12">
				<?php echo BsHtml::activeLabel($item, $item->label); ?>
				<br />
				<?php echo BsHtml::activeCheckBox($item, "[$i]value"); ?>
			</div>
		</div>
		<br />
		<?php
	}
	else if ($item->type == 'radio')
	{
		?>
		<div class="row">
			<div class="col-md-12">
				<?php echo BsHtml::activeLabel($item, $item->label); ?>
				<br />
				<?php echo BsHtml::activeRadioButton($item, "[$i]value"); ?>
			</div>
		</div>
		<br />
		<?php
	}
	else if ($item->type == 'list')
	{
		?>
		<div class="row">
			<div class="col-md-12">
				<?php echo BsHtml::activeLabel($item, $item->label); ?>
				<br />
				<?php echo BsHtml::activeDropDownList($item, "[$i]value", $parentElement) ?>
			</div>
		</div>
		<br />
		<?php
	}
	?>
	<?php
}
?>

<?php
echo BsHtml::submitButton('Сохранить');

echo BsHtml::endForm();
endif;
?>