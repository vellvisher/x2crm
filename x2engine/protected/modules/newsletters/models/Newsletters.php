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
     * Flips the constants array from the NewsletterType class to retrieve the types
     */
    public function getTypes() {
        $temp = new ReflectionClass('NewsletterType');
        return array_flip($temp->getConstants());
    }

    public function parseType() {
        if (!is_null($this->type)) {
            return $this->types[$this->type];
        }
        else return null;
    }

    /**
     * Overrides the default getLink to open an inpage modal
     */
    public function getLink($length=30,$frame=true) {
        $text = $this->subject;
        if($length && mb_strlen($text, 'UTF-8') > $length)
            $text = CHtml::encode(mb_substr($text, 0, $length, 'UTF-8').'...');

        $url = Yii::app()->createUrl('/newsletters/newsletters/fullView/'.$this->id);
        $iframe = str_replace("'", "&#39;","<iframe src='$url' id='newsletterIframeModal' style='background:#fff;'></iframe>");
        return "<a onclick='$(&quot;$iframe&quot;).dialog()' href='#'>$text</a>";
    }
}
