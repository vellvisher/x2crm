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

$menuItems = array(
	array('label'=>Yii::t('docs','List Docs'),'url'=>array('index')),
	array('label'=>Yii::t('docs','Create Doc'),'url'=>array('create')),
	array('label'=>Yii::t('docs','Create Email'),'url'=>array('createEmail')),
	array('label'=>Yii::t('docs','Create Quote'), 'url'=>array('createQuote')),
);

?>
<div class="page-title icon docs"><h2><?php
	if($this->action->id=='createEmail') {
		unset($menuItems[2]['url']);
		echo Yii::t('docs','Create Email Template');
	} else if($this->action->id == 'createQuote') {
		unset($menuItems[3]['url']);
		echo Yii::t('docs','Create Quote');
	} else {
		unset($menuItems[1]['url']);
		echo Yii::t('docs','Create Document');
	}

	?></h2>
</div>

<?php
$this->actionMenu = $this->formatMenu($menuItems);

if($model->type==='email' || $model->type ==='quote')
    echo $this->renderPartial('_form_email', array('model'=>$model,'users'=>$users));
else {
    echo $this->renderPartial('_form', array('model'=>$model,'users'=>$users));
}
?>
