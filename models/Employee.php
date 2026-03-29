<?php
class Employee extends CActiveRecord
{
    public static function model($className=__CLASS__){ return parent::model($className); }
    public function tableName(){ return 'employees'; }
    public function relations(){
        return array(
            'salary' => array(self::HAS_ONE, 'SalaryStructure', 'emp_id'),
            'declarations' => array(self::HAS_ONE, 'TaxDeclarations', 'emp_id'),
            'payrolls' => array(self::HAS_MANY, 'Payroll', 'employee_id'),
        );
    }
}
