<?php

/**
 * Сортировка записей
 *
 * @category Action
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SortableAction extends CAction
{
    /**
     * @var string название модели 
     */
    public $modelName;

    /**
     * Запуск действия
     */
    public function run()
    {
        if (!$this->isValidRequest())
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));

        $sortableAttribute = Yii::app()->request->getQuery('sortableAttribute');
        
        $model = new $this->modelName;
        if (!$model->hasAttribute($sortableAttribute))
        {
            throw new CHttpException(400,
            Yii::t(
                'yii', '{attribute} "{value}" is invalid.',
                array( '{attribute}' => 'sortableAttribute', '{value}' => $sortableAttribute )
            ));
        }

        $sortOrderData = $_POST['sortOrder'];

        $this->update($model, $sortableAttribute, $sortOrderData);
    }

    private function isValidRequest()
    {
        return Yii::app()->request->isPostRequest
            && Yii::app()->request->isAjaxRequest
            && isset($_POST['sortOrder']);
    }

    private function update($model, $sortableAttribute, $sortOrderData)
    {
        $pk       = $model->tableSchema->primaryKey;
        $pk_array = array();
        if (is_array($pk))
        { // composite key
            $string_ids = array_keys($sortOrderData);

            $array_ids   = array();
            foreach($string_ids as $string_id)
                $array_ids[] = explode(',', $string_id);

            foreach($array_ids as $array_id)
                $pk_array[] = array_combine($pk, $array_id);
        }
        else
        { // normal key
            $pk_array = array_keys($sortOrderData);
        }

        $models      = $model->model()->findAllByPk($pk_array);
        $transaction = Yii::app()->db->beginTransaction();
        try
        {
            foreach($models as $model)
            {
                $_key                        = is_array($pk) ? implode(',', array_values($model->primaryKey)) : $model->primaryKey;
                $model->{$sortableAttribute} = $sortOrderData[$_key];
                $model->save();
            }
            $transaction->commit();
        }
        catch(Exception $e)
        { // an exception is raised if a query fails
            $transaction->rollback();
        }
    }

}

