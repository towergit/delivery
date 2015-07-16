<?php
$form = $this->beginWidget('CActiveForm',
    array(
    'id'                   => 'signup',
    'action'               => Yii::app()->createUrl('/default/registration'),
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    ));
?>
    <table>
        <tbody>
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'username'); ?><br>
                    <?php echo $form->textField($model, 'username', array( 'class' => 'input' )); ?><br>
                    <?php echo $form->error($model, 'username'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'email'); ?><br>
                    <?php echo $form->textField($model, 'email', array( 'class' => 'input' )); ?><br>
                    <?php echo $form->error($model, 'email'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'password'); ?><br>
                    <?php echo $form->passwordField($model, 'password', array( 'class' => 'input' )); ?><br>
                    <?php echo $form->error($model, 'password'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'confirm_password'); ?><br>
                    <?php echo $form->passwordField($model, 'confirm_password', array( 'class' => 'input' )); ?><br>
                    <?php echo $form->error($model, 'confirm_password'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'firstname'); ?><br>
                    <?php echo $form->textField($model, 'firstname', array( 'class' => 'input' )); ?><br>
                    <?php echo $form->error($model, 'firstname'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'lastname'); ?><br>
                    <?php echo $form->textField($model, 'lastname', array( 'class' => 'input' )); ?><br>
                    <?php echo $form->error($model, 'lastname'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Дата рождения<br>
                    <?php echo $form->dropDownList($model, 'bdate', $model->date ,array( 'class' => 'input_short' )); ?>
                    <?php echo $form->dropDownList($model, 'bmonth', $model->month ,array( 'class' => 'input_short' )); ?>
                    <?php echo $form->dropDownList($model, 'byear', $model->year ,array( 'class' => 'input_short' )); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'gender'); ?><br>
                    <?php echo $form->dropDownList($model, 'gender', $model->genderList ,array( 'class' => 'input' )); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'country'); ?><br>
                    <?php echo $form->textField($model, 'country', array( 'class' => 'input' )); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'region'); ?><br>
                    <?php echo $form->textField($model, 'region', array( 'class' => 'input' )); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'region'); ?><br>
                    <?php echo $form->textField($model, 'region', array( 'class' => 'input' )); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'referrerId'); ?><br>
                    <?php echo $form->textField($model, 'referrerId', array( 'class' => 'input' )); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="center">
        <?php echo CHtml::submitButton('зарегистрироваться', array( 'class' => 'submit' )); ?>
    </div>
<?php $this->endWidget(); ?>
<?php unset($form); ?>