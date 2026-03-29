<?php
class PayrollItem extends CActiveRecord
{
    public static function model($className=__CLASS__){ return parent::model($className); }
    public function tableName(){ return 'payroll_items'; }
    public function rules(){ return array(array('label, amount, type', 'required'), array('amount', 'numerical')); }
    public function relations(){ return array('payroll'=>array(self::BELONGS_TO,'Payroll','payroll_id')); }
}
