<?php
class Payroll extends CActiveRecord
{
    public static function model($className=__CLASS__){ return parent::model($className); }
    public function tableName(){ return 'payrolls'; }

    public function relations(){
        return array(
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
            'items' => array(self::HAS_MANY, 'PayrollItem', 'payroll_id', 'order' => 'sort_order ASC'),
        );
    }

    public function recalcTotals()
    {
        $earn = 0; $ded = 0;
        foreach($this->items as $it){
            if($it->type == 'earning') $earn += $it->amount;
            if($it->type == 'deduction') $ded += $it->amount;
        }
        $this->total_earnings = $earn;
        $this->total_deductions = $ded;
        $this->net_payable = $earn - $ded;
        $this->save(false);
    }
}
