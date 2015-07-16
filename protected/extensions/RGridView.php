<?php
Yii::import('zii.widgets.grid.CGridView');

/**
 * Grid
 *
 * @category Widget
 * @package  Widgets
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class RGridView extends CGridView
{

    /**
     * Цветовая схема
     */
    const TYPE_DEFAULT = 'default';
    const TYPE_PRIMARY = 'primary';
    const TYPE_INFO    = 'info';
    const TYPE_DANGER  = 'danger';
    const TYPE_WARNING = 'warning';
    const TYPE_SUCCESS = 'success';
    const TYPE_ACTIVE  = 'active';

    /**
     * Boolean иконки
     */
    const ICON_ACTIVE   = '<span class="glyphicon glyphicon-ok text-success"></span>';
    const ICON_INACTIVE = '<span class="glyphicon glyphicon-remove text-danger"></span>';

    /**
     * Выравнивание
     */
    const ALIGN_RIGHT  = 'right';
    const ALIGN_CENTER = 'center';
    const ALIGN_LEFT   = 'left';
    const ALIGN_TOP    = 'top';
    const ALIGN_MIDDLE = 'middle';
    const ALIGN_BOTTOM = 'bottom';

    /**
     * Функции подсчета
     */
    const F_COUNT = 'count';
    const F_SUM   = 'sum';
    const F_MAX   = 'max';
    const F_MIN   = 'min';
    const F_AVG   = 'avg';

    /**
     * Grid формат экспорта
     */
    const HTML  = 'html';
    const CSV   = 'csv';
    const TEXT  = 'txt';
    const EXCEL = 'xls';
    const PDF   = 'pdf';
    const JSON  = 'json';
    
    /**
     * @var type string шаблон панели
     * - {type} тип панели
     * - {panelHeading} название панели
     * - {panelBefore} то, что будет перед блоком
     * - {panelAfter} то, что будет после блока
     * - {panelFooter} то, что будет в нижней части блока
     * - {items} элементы Grid
     * - {summary} краткое изложение подсчетов
     * - {pager} постраничная навигация
     * - {toolbar} панель инструментов
     * - {export} кнопка экспорта
     */
    public $panelTemplate = <<< HTML
<div class="panel {type}">
    {panelHeading}
    {panelBefore}
    {items}
    {panelAfter}
    {panelFooter}
</div>
HTML;
    
    /**
     * @var string шаблон рендеринга шапки панели
     */
    public $panelHeadingTemplate = <<< HTML
<div class="pull-right">
    {summary}
</div>
<h3 class="panel-title">
    {heading}
</h3>
<div class="clearfix"></div>
HTML;
    
    /**
     * @var string шаблон рендеринга подвала панели
     */
    public $panelFooterTemplate = <<< HTML
<div class="kv-panel-pager">
    {pager}
</div>
{footer}
<div class="clearfix"></div>
HTML;
    
    /**
     * @var string
     */
    public $panelBeforeTemplate = <<< HTML
<div class="pull-right">
    <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
        {toolbar}
    </div>    
</div>
{before}
<div class="clearfix"></div>
HTML;
    
    /**
     * @var string
     */
    public $panelAfterTemplate = '{after}';
    
    /**
     * @var array 
     */
    public $beforeHeader = array();
    
    /**
     * @var array 
     */
    public $afterHeader = array();
    
    /**
     * @var array 
     */
    public $beforeFooter = array();
    
    /**
     * @var array 
     */
    public $afterFooter = array();
    
    /**
     * @var array 
     */
    public $toolbar = array(
        '{toggleData}',
        '{export}',
    );
    
    /**
     * @var boolean
     */
    public $toggleData = true;
    
    /**
     * @var array 
     */
    public $toggleDataOptions = array();
    
    /**
     * @var array 
     */
    public $replaceTags = array();
}

