-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2016 at 08:28 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `easybenefits`
--

-- --------------------------------------------------------

--
-- Table structure for table `anthem`
--

CREATE TABLE IF NOT EXISTS `anthem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `claims_benefit_coverage` varchar(255) DEFAULT NULL,
  `claims_deductible_for` varchar(255) DEFAULT NULL,
  `BM_benefit_coverage_period` varchar(255) DEFAULT NULL,
  `BM_benefit_deductible_for` varchar(255) DEFAULT NULL,
  `BM_plan` varchar(255) DEFAULT NULL,
  `BM_primary_care_physian` varchar(255) DEFAULT NULL,
  `BM_member_id` varchar(255) DEFAULT NULL,
  `BM_group_name` varchar(255) DEFAULT NULL,
  `CD_deductible_in_net_family_limit` varchar(255) DEFAULT NULL,
  `CD_deductible_in_net_family_accumulate` varchar(255) DEFAULT NULL,
  `CD_deductible_in_net_remaining` varchar(255) DEFAULT NULL,
  `CD_deductible_out_net_family_limit` varchar(255) DEFAULT NULL,
  `CD_deductible_out_net_family_accumulate` varchar(255) DEFAULT NULL,
  `CD_deductible_out_net_family_remaining` varchar(255) DEFAULT NULL,
  `CD_out_pocket_in_net_family_limit` varchar(255) DEFAULT NULL,
  `CD_out_pocket_in_net_family_accumulate` varchar(255) DEFAULT NULL,
  `CD_out_pocket_in_net_family_remaining` varchar(255) DEFAULT NULL,
  `CD_out_pocket_out_net_family_limit` varchar(255) DEFAULT NULL,
  `CD_out_pocket_out_net_family_accumulate` varchar(255) DEFAULT NULL,
  `CD_out_pocket_out_net_family_remaining` varchar(255) DEFAULT NULL,
  `HP_primary_care_physician` varchar(255) DEFAULT NULL,
  `BV_plan_name` varchar(255) DEFAULT NULL,
  `BV_eligibility_benefit_for` varchar(255) DEFAULT NULL,
  `BV_vision_member_id` varchar(255) DEFAULT NULL,
  `CD_claims_benefit_coverage` varchar(255) DEFAULT NULL,
  `CD_claims_benefit_deductible_for` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `anthem_claim_overview`
--

CREATE TABLE IF NOT EXISTS `anthem_claim_overview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `for` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `doctor_facility` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `member_responsibility` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=265 ;

-- --------------------------------------------------------

--
-- Table structure for table `cigna_claim`
--

CREATE TABLE IF NOT EXISTS `cigna_claim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `service_date` date DEFAULT NULL,
  `provided_by` varchar(255) DEFAULT NULL,
  `for` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `amount_billed` varchar(255) DEFAULT NULL,
  `what_your_plan_paid` varchar(255) DEFAULT NULL,
  `my_account_paid` varchar(255) DEFAULT NULL,
  `what_i_owe` varchar(255) DEFAULT NULL,
  `claim_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cigna_claim-not in use`
--

CREATE TABLE IF NOT EXISTS `cigna_claim-not in use` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `service_date` date DEFAULT NULL,
  `provided_by` varchar(255) DEFAULT NULL,
  `for` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `amount_billed` varchar(255) DEFAULT NULL,
  `what_your_plan_paid` varchar(255) DEFAULT NULL,
  `my_account_paid` varchar(255) DEFAULT NULL,
  `what_i_owe` varchar(255) DEFAULT NULL,
  `claim_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cigna_claim_details`
--

CREATE TABLE IF NOT EXISTS `cigna_claim_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `claim_number` varchar(255) DEFAULT NULL,
  `provided_by_details` varchar(255) DEFAULT NULL,
  `for` varchar(255) DEFAULT NULL,
  `claim_processed_on` varchar(255) DEFAULT NULL,
  `service_date_type` varchar(255) DEFAULT NULL,
  `service_amount_billed` varchar(255) DEFAULT NULL,
  `service_discount` varchar(255) DEFAULT NULL,
  `service_covered_amount` varchar(255) DEFAULT NULL,
  `service_copay_deductible` varchar(255) DEFAULT NULL,
  `service_what_your_plan_paid` varchar(255) DEFAULT NULL,
  `service_coinsurance` varchar(255) DEFAULT NULL,
  `service_what_i_owe` varchar(255) DEFAULT NULL,
  `service_see_notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=327 ;

-- --------------------------------------------------------

--
-- Table structure for table `cigna_deductible`
--

CREATE TABLE IF NOT EXISTS `cigna_deductible` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `deductible_amt` varchar(255) DEFAULT NULL,
  `deductible_met` varchar(255) DEFAULT NULL,
  `deductible_remaining` varchar(255) DEFAULT NULL,
  `out_of_pocket_amt` varchar(255) DEFAULT NULL,
  `out_of_pocket_met` varchar(255) DEFAULT NULL,
  `out_of_pocket_remaining` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `cigna_medical`
--

CREATE TABLE IF NOT EXISTS `cigna_medical` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `whos_covered` varchar(255) DEFAULT NULL,
  `date_of_birth` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `coverage_from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `primary_care_physician` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=206 ;

-- --------------------------------------------------------

--
-- Table structure for table `guardian_benefit`
--

CREATE TABLE IF NOT EXISTS `guardian_benefit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `coverage` varchar(255) DEFAULT NULL,
  `original_effective_date` date DEFAULT NULL,
  `amounts` varchar(255) DEFAULT NULL,
  `monthly_cost` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=180 ;

-- --------------------------------------------------------

--
-- Table structure for table `guardian_claim`
--

CREATE TABLE IF NOT EXISTS `guardian_claim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `patient` varchar(255) DEFAULT NULL,
  `coverage_type` varchar(255) DEFAULT NULL,
  `claim_number` varchar(255) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `date_of_service` date DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `check_number` varchar(255) DEFAULT NULL,
  `provider_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `submitted_charges` varchar(255) DEFAULT NULL,
  `amount_paid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=273 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_user`
--

CREATE TABLE IF NOT EXISTS `job_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `api_token` varchar(100) NOT NULL,
  `api_updated` varchar(50) NOT NULL,
  `medical_site` varchar(255) DEFAULT NULL,
  `dental_site` varchar(255) DEFAULT NULL,
  `vision_site` varchar(255) DEFAULT NULL,
  `funds_site` varchar(255) DEFAULT NULL,
  `cigna_user_id` varchar(255) NOT NULL,
  `cigna_password` varchar(255) NOT NULL,
  `cigna_medical_exeid` varchar(255) DEFAULT NULL,
  `cigna_deductible_claim_exeid` varchar(255) DEFAULT NULL,
  `cigna_claim_details_exeid` varchar(255) DEFAULT NULL,
  `guardian_user_id` varchar(255) DEFAULT NULL,
  `guardian_password` varchar(255) DEFAULT NULL,
  `guardian_benefit_exeid` varchar(255) DEFAULT NULL,
  `guardian_claim_exeid` varchar(255) DEFAULT NULL,
  `anthem_user_id` varchar(255) DEFAULT NULL,
  `anthem_password` varchar(255) DEFAULT NULL,
  `anthem_exeid` varchar(255) DEFAULT NULL,
  `anthem_claim_overview_exeid` varchar(255) DEFAULT NULL,
  `navia_user_id` varchar(255) DEFAULT NULL,
  `navia_password` varchar(255) DEFAULT NULL,
  `navia_statements_exeid` varchar(255) DEFAULT NULL,
  `navia_day_care_exeid` varchar(255) DEFAULT NULL,
  `navia_health_care_exeid` varchar(255) DEFAULT NULL,
  `navia_health_savings_exeid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username_u` (`username`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122 ;

-- --------------------------------------------------------

--
-- Table structure for table `navia_day_care`
--

CREATE TABLE IF NOT EXISTS `navia_day_care` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `claim` varchar(255) DEFAULT NULL,
  `annual_election` varchar(255) DEFAULT NULL,
  `reimbursed_to_date` varchar(255) DEFAULT NULL,
  `date_posted` date DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `claim_amount` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=922 ;

-- --------------------------------------------------------

--
-- Table structure for table `navia_health_care`
--

CREATE TABLE IF NOT EXISTS `navia_health_care` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `annual_election` varchar(255) DEFAULT NULL,
  `reimbursed_to_date` varchar(255) DEFAULT NULL,
  `date_posted` date DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `claim_amount` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=536 ;

-- --------------------------------------------------------

--
-- Table structure for table `navia_health_savings`
--

CREATE TABLE IF NOT EXISTS `navia_health_savings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `portfolio_balance` varchar(255) DEFAULT NULL,
  `total_balance` varchar(255) DEFAULT NULL,
  `contributions_YTD` varchar(255) DEFAULT NULL,
  `employer_contributions_YTD` varchar(255) DEFAULT NULL,
  `total_contributions_YTD` varchar(255) DEFAULT NULL,
  `employer_per_pay_amount` varchar(255) DEFAULT NULL,
  `employee_per_pay_amount` varchar(255) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `transaction_amt` varchar(255) DEFAULT NULL,
  `HSA_transaction_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=465 ;

-- --------------------------------------------------------

--
-- Table structure for table `navia_statements`
--

CREATE TABLE IF NOT EXISTS `navia_statements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(11) DEFAULT NULL,
  `DC_from_date` date DEFAULT NULL,
  `DC_to_date` date DEFAULT NULL,
  `DC_claim` varchar(255) DEFAULT NULL,
  `DC_annual_election` varchar(255) DEFAULT NULL,
  `DC_last_day_incur_exp` date DEFAULT NULL,
  `DC_submit_claims` date DEFAULT NULL,
  `HC_date_from` date DEFAULT NULL,
  `HC_date_to` date DEFAULT NULL,
  `HC_balance` varchar(255) DEFAULT NULL,
  `HC_annual_election` varchar(255) DEFAULT NULL,
  `HC_last_day_incur_exp` date DEFAULT NULL,
  `HC_last_day_submit_claims` date DEFAULT NULL,
  `HS_balance` varchar(255) DEFAULT NULL,
  `HS_distributions` varchar(255) DEFAULT NULL,
  `HS_employee_contributions` varchar(255) DEFAULT NULL,
  `HS_employer_contributions` varchar(255) DEFAULT NULL,
  `TB_balance` varchar(255) DEFAULT NULL,
  `TB_last_day_submit` date DEFAULT NULL,
  `PB_balance` varchar(255) DEFAULT NULL,
  `PB_last_day_submit` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `provider_list`
--

CREATE TABLE IF NOT EXISTS `provider_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_type` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `scrapper_script_path` varchar(255) DEFAULT NULL,
  `default` tinyint(255) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_provider`
--

CREATE TABLE IF NOT EXISTS `user_provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `provider_user_id` varchar(255) DEFAULT NULL,
  `provider_password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_provider_exe`
--

CREATE TABLE IF NOT EXISTS `user_provider_exe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_provider_table_id` int(11) DEFAULT NULL,
  `run_name` varchar(255) DEFAULT NULL,
  `exe_id` varchar(255) DEFAULT NULL,
  `failed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=171 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
