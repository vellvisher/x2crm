<?php
/**
 * This is the model class for table "x2_advertise".
 *
 * @package X2CRM.modules.advertise.models
 */
class Advertise extends X2Model {

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'x2_advertise';
    }

    public function getBudgets() {
        $temp = new ReflectionClass('BudgetType');
        return array_flip($temp->getConstants());
    }

    public function getLink() {
        return $this->name;
    }
}

/*
 * Enum substitute
 * @package X2CRM.modules.advertis.models
 */
final class BudgetType {
    const Silver = 0;
    const Gold = 1;
    const Platinum = 2;

    //To prevent it from being instantiated
    private function BudgetType() {}
}