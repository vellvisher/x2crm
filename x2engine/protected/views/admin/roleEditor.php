<?php
/*****************************************************************************************
 * X2CRM Open Source Edition is a customer relationship management program developed by
 * X2Engine, Inc. Copyright (C) 2011-2013 X2Engine Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY X2ENGINE, X2ENGINE DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact X2Engine, Inc. P.O. Box 66752, Scotts Valley,
 * California 95067, USA. or at email address contact@x2engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2Engine".
 *****************************************************************************************/

// Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/multiselect/js/jquery-1.3.2.min.js');
// Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/multiselect/js/jquery-ui-1.7.1.custom.min.js');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/multiselect/js/ui.multiselect.js');
//Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl().'/js/multiselect/css/ui.multiselect.css','screen, projection');
//Yii::app()->clientScript->registerCss('multiselectCss',"
//.multiselect {
//	width: 460px;
//	height: 200px;
//}
//#switcher {
//	margin-top: 20px;
//}
//",'screen, projection');


Yii::app()->clientScript->registerScript('renderMultiSelect',"
$(document).ready(function() {
	 $('.multiselect').multiselect();
});
",CClientScript::POS_HEAD);
$selected=array();
$unselected=array();
$fields=Fields::model()->findAllBySql("SELECT * FROM x2_fields ORDER BY modelName ASC");
foreach($fields as $field){
        $unselected[$field->id]=$field->modelName." - ".$field->attributeLabel;
}
$users=User::getNames();
unset($users['']);
unset($users['Anyone']);
unset($users['admin']);
/* x2temp */
$groups=Groups::model()->findAll();
foreach($groups as $group){
    $users[$group->id]=$group->name;
}
/* end x2temp */
?>
<div class="page-title"><h2><?php echo Yii::t('admin','Add Role'); ?></h2></div>
<div class="form">
<div style="width:600px">
    <?php echo Yii::t('admin','Roles allow you to control which fields are editable on a record and by whom.  To add a role, enter the name, a list of users, and a list of fields they are allowed to view or edit.  Any field not included will be assumed to be unavailable to users of that Role.') ?>
</div>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'role-form',
	'enableAjaxValidation'=>false,
        'action'=>'roleEditor',
));
?>
<div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
</div>
<div id="addRole">
        <?php echo $form->labelEx($model,'users'); ?>
        <?php echo $form->dropDownList($model,'users',$users,array('class'=>'multiselect','multiple'=>'multiple','size'=>7)); ?>
        <?php echo $form->error($model,'users'); ?>

    <label><?php echo Yii::t('admin','View Permissions'); ?></label>
    <?php
    echo CHtml::dropDownList('viewPermissions[]',$selected,$unselected,array('class'=>'multiselect','multiple'=>'multiple', 'size'=>8));
    ?>

<br>

    <label><?php echo Yii::t('admin','Edit Permissions'); ?></label>
    <?php
    echo CHtml::dropDownList('editPermissions[]',$selected,$unselected,array('class'=>'multiselect','multiple'=>'multiple', 'size'=>8));
    ?>
</div>

<br>
<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('app','Submit'),array('class'=>'x2-button')); ?>
</div>
<?php $this->endWidget(); ?>
</div>

