-- SQL migrations for Yii1 Payroll Project

-- employees
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `employee_id` varchar(50) DEFAULT NULL,
  `pan` varchar(20) DEFAULT NULL,
  `uan` varchar(50) DEFAULT NULL,
  `esic` varchar(50) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `monthly_ctc` decimal(12,2) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- salary structure
CREATE TABLE IF NOT EXISTS `salary_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `basic` decimal(12,2) DEFAULT 0,
  `hra` decimal(12,2) DEFAULT 0,
  `conveyance` decimal(12,2) DEFAULT 0,
  `special_allow` decimal(12,2) DEFAULT 0,
  `other_allow` decimal(12,2) DEFAULT 0,
  `pf_applicable` tinyint(1) DEFAULT 1,
  `esi_applicable` tinyint(1) DEFAULT 1,
  `pt_state` varchar(50) DEFAULT NULL,
  `regime` enum('old','new') DEFAULT 'old',
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`),
  CONSTRAINT `ss_emp_fk` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- tax declarations
CREATE TABLE IF NOT EXISTS `tax_declarations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `sec80c` decimal(12,2) DEFAULT 0,
  `sec80d` decimal(12,2) DEFAULT 0,
  `home_loan_interest` decimal(12,2) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`),
  CONSTRAINT `td_emp_fk` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- payrolls
CREATE TABLE IF NOT EXISTS `payrolls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `month_year` date NOT NULL,
  `total_working_days` int(11) DEFAULT 0,
  `total_earnings` decimal(12,2) DEFAULT 0,
  `total_deductions` decimal(12,2) DEFAULT 0,
  `net_payable` decimal(12,2) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `pay_emp_fk` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- payroll items
CREATE TABLE IF NOT EXISTS `payroll_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payroll_id` int(11) NOT NULL,
  `type` enum('earning','deduction','employer_contribution') NOT NULL,
  `label` varchar(255) NOT NULL,
  `amount` decimal(12,2) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `payroll_id` (`payroll_id`),
  CONSTRAINT `pi_pay_fk` FOREIGN KEY (`payroll_id`) REFERENCES `payrolls` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- tax slabs (old + new)
CREATE TABLE IF NOT EXISTS `tax_slabs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slab_from` decimal(12,2) NOT NULL,
  `slab_to` decimal(12,2) NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `regime` enum('old','new') DEFAULT 'old',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- insert sample slabs (old)
INSERT INTO tax_slabs (slab_from, slab_to, rate, regime) VALUES
(0,250000,0,'old'),
(250001,500000,5,'old'),
(500001,1000000,20,'old'),
(1000001,99999999,30,'old');

-- insert sample slabs (new)
INSERT INTO tax_slabs (slab_from, slab_to, rate, regime) VALUES
(0,300000,0,'new'),
(300001,700000,5,'new'),
(700001,1000000,10,'new'),
(1000001,1200000,15,'new'),
(1200001,1500000,20,'new'),
(1500001,99999999,30,'new');

-- seed an employee
INSERT INTO employees (name, employee_id, pan, uan, esic, designation, monthly_ctc) VALUES
('Laxman Dwivedi','EMP001','ABCDE1234F','123456789012','ESI001','Developer',60000.00);

-- salary structure for employee
INSERT INTO salary_structure (emp_id,basic, hra, conveyance, special_allow, other_allow, pf_applicable, esi_applicable, pt_state, regime)
VALUES (1,24000,12000,1600,4000,6000,1,1,'maharashtra','old');

-- tax declarations
INSERT INTO tax_declarations (emp_id, sec80c, sec80d, home_loan_interest) VALUES (1,120000,5000,0);
