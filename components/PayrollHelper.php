<?php
class PayrollHelper
{
    // PF 12% employee share
    public static function calculatePF($basic, $applicable=true){
        if(!$applicable) return 0;
        return round($basic * 0.12, 2);
    }

    // Employer PF (for employer contribution display)
    public static function calculateEmployerPF($basic, $applicable=true){
        if(!$applicable) return 0;
        return round($basic * 0.12, 2);
    }

    // ESIC: employee 0.75% if gross <= 21000 (example rate)
    public static function calculateESIC($gross, $applicable=true){
        if(!$applicable || $gross > 21000) return 0;
        return round($gross * 0.0075, 2);
    }

    // Employer ESIC contribution approx 3.25% (example)
    public static function calculateEmployerESIC($gross, $applicable=true){
        if(!$applicable || $gross > 21000) return 0;
        return round($gross * 0.0325, 2);
    }

    // Professional tax simplified example
    public static function professionalTax($state, $gross){
        $state = strtolower(trim($state));
        $pt = 0;
        switch($state){
            case 'maharashtra':
                if($gross <= 7500) $pt=0; elseif($gross<=10000) $pt=200; else $pt=300; break;
            case 'west bengal':
                if($gross <= 10000) $pt=0; else $pt=200; break;
            default:
                $pt = 0;
        }
        return $pt;
    }

    // Calculate annual tax based on slabs and declarations, return monthly TDS
    public static function calculateTDS($gross_monthly, $emp_id, $regime='old'){
        $yearly = $gross_monthly * 12.0;

        // Standard deduction for old regime
        if($regime == 'old'){
            $yearly -= 50000;
        }

        // Load declarations
        $dec = TaxDeclarations::model()->findByAttributes(array('emp_id'=>$emp_id));
        $totalDec = 0;
        if($dec && $regime == 'old'){
            $totalDec += min((float)$dec->sec80c, 150000);
            $totalDec += (float)$dec->sec80d;
            $totalDec += (float)$dec->home_loan_interest;
        }

        $taxable = max(0, $yearly - $totalDec);

        // Sum tax from slabs
        $slabs = TaxSlab::model()->findAll('regime=:r ORDER BY slab_from ASC', array(':r'=>$regime));
        $tax = 0;
        foreach($slabs as $slab){
            $from = (float)$slab->slab_from;
            $to = (float)$slab->slab_to;
            $rate = (float)$slab->rate;
            if($taxable > $from){
                $amount = min($taxable, $to) - $from;
                $tax += ($amount * ($rate/100.0));
            }
        }

        // You may add cess calculation (e.g., 4%) here if needed
        // $tax *= 1.04;

        return round($tax/12.0, 2);
    }

    // Populate default payroll items and save
    public static function populateAndSavePayrollItems(Payroll $p){
        $emp = $p->employee;
        $sal = $emp->salary;
        if(!$sal) return false;

        $basic = (float)$sal->basic;
        $hra   = (float)$sal->hra;
        $convey = (float)$sal->conveyance;
        $special = (float)$sal->special_allow;
        $other = (float)$sal->other_allow;

        $gross = $basic + $hra + $convey + $special + $other;

        // compute deductions
        $pf_emp = self::calculatePF($basic, $sal->pf_applicable);
        $esi_emp = self::calculateESIC($gross, $sal->esi_applicable);
        $pt = self::professionalTax($sal->pt_state, $gross);
        $tds = self::calculateTDS($gross, $emp->id, $sal->regime);

        // employer contributions
        $pf_employer = self::calculateEmployerPF($basic, $sal->pf_applicable);
        $esi_employer = self::calculateEmployerESIC($gross, $sal->esi_applicable);

        $items = array(
            // Earnings
            array('type'=>'earning','label'=>'Basic','amount'=>$basic),
            array('type'=>'earning','label'=>'HRA','amount'=>$hra),
            array('type'=>'earning','label'=>'Conveyance','amount'=>$convey),
            array('type'=>'earning','label'=>'Special Allowance','amount'=>$special),
            array('type'=>'earning','label'=>'Other Allowance','amount'=>$other),

            // Deductions
            array('type'=>'deduction','label'=>'Provident Fund (Employee)','amount'=>$pf_emp),
            array('type'=>'deduction','label'=>'E.S.I. (Employee)','amount'=>$esi_emp),
            array('type'=>'deduction','label'=>'Professional Tax','amount'=>$pt),
            array('type'=>'deduction','label'=>'TDS (Auto)','amount'=>$tds),

            // Employer contributions
            array('type'=>'employer_contribution','label'=>'EPF (Employer)','amount'=>$pf_employer),
            array('type'=>'employer_contribution','label'=>'ESI (Employer)','amount'=>$esi_employer),
        );

        $order=1;
        foreach($items as $it){
            $pi = new PayrollItem();
            $pi->payroll_id = $p->id;
            $pi->type = $it['type'];
            $pi->label = $it['label'];
            $pi->amount = $it['amount'];
            $pi->sort_order = $order++;
            $pi->save(false);
        }

        $p->refresh();
        $p->recalcTotals();
        return true;
    }
}
