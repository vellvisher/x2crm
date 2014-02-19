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

    /**
     * Retrieves a list of models.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function all() {
        return new SmartDataProvider('Newsletters', array(
            'pagination' => array(
                'pageSize' => ProfileChild::getResultsPerPage(),
            ),
            'sort' => array(
                'defaultOrder' => 'dateUpdated DESC, id DESC',
            )
        ));
    }

    /**
     * Flips the constants array from the NewsletterType class to retrieve the type
     */
    public function parseType() {
        return array_flip(
            (new ReflectionClass('NewsletterType'))->getConstants()
        )[$this->type];
    }
}
