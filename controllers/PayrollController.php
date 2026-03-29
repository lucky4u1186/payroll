<?php
class PayrollController extends Controller
{
    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('create','view','pdf','dashboard','runAll'),
                'users'=>array('@'),
            ),
            array('deny','users'=>array('*')),
        );
    }

    protected function getMonthKey($month=null) {
        if(!$month) $month = date('Y-m');
        return date('Y-m-01', strtotime($month));
    }

    public function actionCreate($employee_id){
        $emp = Employee::model()->findByPk($employee_id);
        if(!$emp) throw new CHttpException(404,'Employee not found');

        $payroll = new Payroll();
        $payroll->employee_id = $employee_id;
        $payroll->month_year = date('Y-m-01');

        if(isset($_POST['Payroll'])){
            $payroll->attributes = $_POST['Payroll'];
            if($payroll->save()){
                // populate items automatically
                PayrollHelper::populateAndSavePayrollItems($payroll);
                $this->redirect(array('view','id'=>$payroll->id));
            }
        }

        $this->render('create',array('employee'=>$emp,'model'=>$payroll));
    }

    public function actionView($id){
        $payroll = Payroll::model()->findByPk($id);
        if(!$payroll) throw new CHttpException(404,'Payroll not found');
        $this->render('view',array('model'=>$payroll));
    }

    public function actionPdf($id){
        $payroll = Payroll::model()->findByPk($id);
        if(!$payroll) throw new CHttpException(404,'Payroll not found');

        $html = $this->renderPartial('_payslip',array('model'=>$payroll),true);

        // Using mPDF - ensure you've installed it via composer `composer require mpdf/mpdf`
        $vendorAutoload = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
        if(file_exists($vendorAutoload)){
            require_once($vendorAutoload);
        } else {
            // try project vendor
            if(defined('YII_PATH')){
                $try = dirname(YII_PATH).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
                if(file_exists($try)) require_once($try);
            }
        }

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('payslip_'.$payroll->id.'.pdf','D');
    }

    public function actionDashboard($month=null)
    {
        $monthKey = $this->getMonthKey($month);
        $employees = Employee::model()->with('salary')->findAll();

        $rows = array();
        $totals = array('gross'=>0,'deductions'=>0,'net'=>0);

        foreach($employees as $emp) {
            $sal = $emp->salary;
            if(!$sal) continue;

            $basic = (float)$sal->basic;
            $hra = (float)$sal->hra;
            $convey = (float)$sal->conveyance;
            $special = (float)$sal->special_allow;
            $other = (float)$sal->other_allow;
            $gross = $basic + $hra + $convey + $special + $other;

            $exists = Payroll::model()->findByAttributes(array('employee_id'=>$emp->id,'month_year'=>$monthKey));
            $status = $exists ? 'Generated' : 'Pending';

            $rows[] = array(
                'employee'=>$emp,
                'gross'=>$gross,
                'status'=>$status,
                'payroll'=>$exists,
            );

            $totals['gross'] += $gross;
            if($exists){
                $totals['deductions'] += (float)$exists->total_deductions;
                $totals['net'] += (float)$exists->net_payable;
            }
        }

        $this->render('dashboard', array('month'=>$monthKey,'rows'=>$rows,'totals'=>$totals));
    }

    public function actionRunAll($month=null)
    {
        $monthKey = $this->getMonthKey($month);
        $employees = Employee::model()->with('salary')->findAll();

        $created = 0;
        foreach($employees as $emp){
            if(!$emp->salary) continue;
            $exists = Payroll::model()->findByAttributes(array('employee_id'=>$emp->id,'month_year'=>$monthKey));
            if($exists) continue;

            $p = new Payroll();
            $p->employee_id = $emp->id;
            $p->month_year = $monthKey;
            $p->total_working_days = 0;
            if($p->save()){
                PayrollHelper::populateAndSavePayrollItems($p);
                $created++;
            }
        }

        Yii::app()->user->setFlash('success', "$created payroll(s) created for ".date('F Y', strtotime($monthKey)));
        $this->redirect(array('dashboard','month'=>$monthKey));
    }
}
