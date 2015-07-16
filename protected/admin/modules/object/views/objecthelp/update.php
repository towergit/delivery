<?php
// название страницы
$this->pageTitle = Yii::t('objecthelp', 'Редактирование Объекта помощи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('objecthelp', 'Объекты'),
    Yii::t('objecthelp', 'Список объектов')        => array( 'index' ),
    Yii::t('objecthelp', 'Редактирование объекта') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form',
    array(
    'model'      => $model,
    'category' => $category,
));
?>

<-- Button to trigger modal -->
<a href="#myModal" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
 
<-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-wrapper" style="width: 50%;margin: 0 auto;background-color: white;border-radius: 10px;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Modal header</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
        
    </div>
</div>