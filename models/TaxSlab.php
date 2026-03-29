<?php
class TaxSlab extends CActiveRecord
{
    public static function model($className=__CLASS__){ return parent::model($className); }
    public function tableName(){ return 'tax_slabs'; }

    public function rules(){
        return array(
            array('regime, slab_from, slab_to, rate', 'required'),
            array('slab_from, slab_to, rate', 'numerical'),
            array('regime', 'in', 'range'=>array('old','new')),
        );
    }

    public function attributeLabels(){
        return array(
            'regime' => 'Tax Regime',
            'slab_from' => 'Income From',
            'slab_to' => 'Income To',
            'rate' => 'Tax Rate (%)'
        );
    }
}
