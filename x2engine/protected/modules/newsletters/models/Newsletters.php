<?php
/**
 * This is the model class for table "x2_newsletters".
 *
 * @package X2CRM.modules.newsletters.models
 */
class Newsletters extends X2Model {

    /**
     * Returns the static model of the specified AR class.
     * @return Newsletters the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'x2_newsletters';
    }

    // WHAT IS THIS??
    // public function behaviors() {
    //     return array_merge(parent::behaviors(), array(
    //                 'X2LinkableBehavior' => array(
    //                     'class' => 'X2LinkableBehavior',
    //                     'module' => 'docs',
    //                 ),
    //                 'ERememberFiltersBehavior' => array(
    //                     'class' => 'application.components.ERememberFiltersBehavior',
    //                     'defaults' => array(),
    //                     'defaultStickOnClear' => false
    //                 )
    //             ));
    // }

    /**
     * @return array relational rules.
     */
    // public function relations() {
    //     return array(
    //     );
    // }

    // public function parseType() {
    //     if (!isset($this->type))
    //         $this->type = '';
    //     switch ($this->type) {
    //         case 'email':
    //             return Yii::t('docs', 'Template');
    //         default:
    //             return Yii::t('docs', 'Document');
    //     }
    // }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        // $criteria->compare('id',$this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('subject', $this->subject, true);
        // $criteria->compare('text',$this->text,true);
        $criteria->compare('createdBy', $this->createdBy, true);
        $criteria->compare('createDate', $this->createDate);
        $criteria->compare('updatedBy', $this->updatedBy, true);
        $criteria->compare('lastUpdated', $this->lastUpdated);
        $criteria->compare('type', $this->type);

        if (!Yii::app()->params->isAdmin) {
            $condition = 'visibility="1" OR createdBy="Anyone"  OR createdBy="' . Yii::app()->user->getName() .
                '" OR editPermissions LIKE "%' . Yii::app()->user->getName() . '%"';
            /* x2temp */
            $groupLinks = Yii::app()->db->createCommand()->
                select('groupId')->
                from('x2_group_to_user')->
                where('userId=' . Yii::app()->user->getId())->
                queryColumn();
            if (!empty($groupLinks))
                $condition .= ' OR createdBy IN (' . implode(',', $groupLinks) . ')';

            $condition .= 'OR (visibility=2 AND createdBy IN
                (SELECT username FROM x2_group_to_user WHERE groupId IN
                    (SELECT groupId FROM x2_group_to_user WHERE userId=' . Yii::app()->user->getId() . ')))';
            $criteria->addCondition($condition);
        }

        $dateRange = Yii::app()->controller->partialDateRange($this->createDate);
        if ($dateRange !== false)
            $criteria->addCondition('createDate BETWEEN ' . $dateRange[0] . ' AND ' . $dateRange[1]);

        $dateRange = Yii::app()->controller->partialDateRange($this->lastUpdated);
        if ($dateRange !== false)
            $criteria->addCondition('lastUpdated BETWEEN ' . $dateRange[0] . ' AND ' . $dateRange[1]);

        return new SmartDataProvider('Newsletters', array(
                    'pagination' => array(
                        'pageSize' => ProfileChild::getResultsPerPage(),
                    ),
                    'sort' => array(
                        'defaultOrder' => 'lastUpdated DESC, id DESC',
                    ),
                    'criteria' => $criteria,
                ));
    }

    /**
     * Replace tokens with model attribute values.
     *
     * @param type $str Input text
     * @param X2Model $model Model to use for replacement
     * @param array $vars List of extra variables to replace
     * @param bool $encode Encode replacement values if true; use renderAttribute otherwise.
     * @return string
     */
    public static function replaceVariables($str,$model,$vars = array(),$encode = false) {
        if($encode) {
            foreach(array_keys($vars) as $key)
                $vars[$key] = CHtml::encode($vars[$key]);
        }
        $str = strtr($str,$vars);   // replace any manually set variables

        if($model instanceof X2Model) {
            if(get_class($model) !== 'Quote') {
                $matches = array();
                preg_match_all('/{\w+}/',$str,$matches);

                if(isset($matches[0])) {
                    $attributes = array();
                    foreach($matches[0] as &$match) {   // loop through the things (email body)
                        $attribute = substr($match, 1, -1); // remove { and }
                        if($model->hasAttribute($attribute))
                            $attributes[$match] = $model->renderAttribute($attribute,false,true); // get the correctly formatted attribute (which is already in HTML)
                    }
                    $str = strtr($str,$attributes); // replace any attributes that were found
                }
            } else {
                // Specialized, separate method for quotes that can use details from
                // either accounts or quotes.
                // There may still be some stray quotes with 2+ contacts on it, so
                // explode and pick the first to be on the safe side. The most
                // common use case by far is to have only one contact on the quote.
                $contactIds = explode(' ', $model->associatedContacts);
                $contactId = $contactIds[0];
                $accountId = $model->accountName;
                $staticModels = array('Contact' => Contacts::model(), 'Account' => Accounts::model(), 'Quote' => Quote::model());
                $models = array(
                    'Contact' => $model->contact,
                    'Account' => empty($accountId) ? null : $staticModels['Account']->findByPk($model->accountName),
                    'Quote' => $model
                );
                $attributes = array();
                foreach($models as $name => $modelObj) {
                    if(empty($modelObj)) {
                        // Model will be blank
                        foreach ($staticModels[$name]->fields as $field) {
                            $attributes['{' . $name . '.' . $field->fieldName . '}'] = '';
                        }
                    } else {
                        // Insert attributes
                        foreach($modelObj->attributes as $fieldName => $value) {
                            $attributes['{' . $name . '.' . $fieldName . '}'] = $encode ? CHtml::encode($value) : $modelObj->renderAttribute($fieldName);
                        }
                    }
                }
                $quoteParams = array(
                    '{Quote.lineItems}' => $model->productTable(true),
                    '{Quote.dateNow}' => date("F d, Y", time()),
                    '{Quote.quoteOrInvoice}' => Yii::t('quotes',$model->type=='invoice' ? 'Invoice' : 'Quote'),
                );
                // Run the replacement:
                $str = strtr($str,array_merge($attributes,$quoteParams));
                return $str;
            }
        }
        return $str;
    }

}
