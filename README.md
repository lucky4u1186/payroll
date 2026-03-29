Here is one salary structure row with all fields, including:
✔ Basic
✔ HRA
✔ Conveyance
✔ Special Allowance
✔ Other Allowance
✔ Mobile Allowance
✔ Transportation Allowance
✔ City Compensatory Allowance
✔ PF applicable
✔ ESI applicable
✔ PT State
✔ Tax Regime (old/new)

Make sure before generating payslips:

You ran protected/data/migrations.sql and tables exist.
Each employee has a salary_structure record.
PayrollHelper and controllers from the package are in protected/.
mPDF installed by composer in project root:
composer require mpdf/mpdf
and controller can require_once vendor/autoload (the provided controller attempts common paths).
You are logged-in (controllers use 'users'=>array('@') access rule) or adjusted accessRules for testing.

Create payroll (generate items + totals):

http://yourdomain.com/index.php?r=payroll/create&employee_id=1
The create action saves payroll row, auto-populates earnings/deductions via PayrollHelper::populateAndSavePayrollItems() and redirects to view.
After redirect you will be at:
http://yourdomain.com/index.php?r=payroll/view&id=PAYROLL_ID
