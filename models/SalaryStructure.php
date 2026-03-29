<?php
class SalaryStructure extends CActiveRecord
{
    public $search;
    public static function model($className=__CLASS__){ return parent::model($className); }
    public function tableName(){ return 'salary_structure'; }
    public function rules(){
        return array(
            array('emp_id','required'),
            array('basic,hra,conveyance,special_allow,other_allow','numerical'),
            array('pf_applicable,esi_applicable','safe'),
            array('pt_state,regime','safe'),
        );
    }
    public function relations(){
        return array('employee'=>array(self::BELONGS_TO,'Employee','emp_id'));
    }
    public function attributeLabels(){
        return array(
            'emp_id'=>'Employee',
            'basic'=>'Basic',
            'hra'=>'HRA',
            'conveyance'=>'Conveyance',
            'special_allow'=>'Special Allow',
            'other_allow'=>'Other Allow',
            'pf_applicable'=>'PF Applicable',
            'esi_applicable'=>'ESI Applicable',
            'pt_state'=>'PT State',
            'regime'=>'Tax Regime',
        );
    }
}
