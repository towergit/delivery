<?php
Yii::import('zii.widgets.CMenu');

/**
 * Меню
 *
 * @category Behavior
 * @package  Behaviors
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class RMenu extends CMenu
{
	/**
	 * @var string детали
	 */
	public $detail;
	
	/**
	 * @var string иконка 
	 */
	public $icon;
	
	/**
	 * Отрисовка пункта меню
	 * @param array $item массив пункта меню
	 * @return string
	 */
	public function renderMenuItem($item)
	{
		if (isset($item['url']))
		{
			if ($this->linkLabelWrapper === null)
			{
				$label = '<span class="title">' . $item['label'] . '</span>';
				
				if (isset($item['detail']))
				{
					$label .= '<span class="details">' . $item['detail'] . '</span>';

					if (isset($item['linkOptions']))
						$item['linkOptions'] = CMap::mergeArray(array( 'class' => 'detailed' ), $item['linkOptions']);
					else
						$item['linkOptions'] = array( 'class' => 'detailed' );
				}
				
				if (isset($item['items']))
					$label .= '<span class="arrow"><i class="fa fa-angle-left"></i></span>';
			}
			else
				$label = CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
			
			$itemMenu = CHtml::link($label, $item['url'], isset($item['linkOptions']) ? $item['linkOptions'] : array());
			
			if (isset($item['icon']))
				$itemMenu .= '<span class="icon"><i class="fa ' . $item['icon'] . '"></i></span>';
			
			return $itemMenu;
		}
		else
			return CHtml::tag('span', isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
	}
}