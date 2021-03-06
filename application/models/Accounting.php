<?php
	class Accounting extends ActiveRecord\Model {
		public static $table_name = 'accounting_stat';

		function add_entry($date, $price, $client_id, $spot_id, $year, $month) {
			Accounting::create(array(
				'Y'			=>  $year,
				'M'			=>  $month,
				'date'		=>  $date,
				'price'		=>	$price,
				'client_id'	=>	$client_id,
				'spot_id'	=>  $spot_id
			));
		}

		function get_profit_for_today() {
				$entrys = Accounting::find_by_sql("SELECT SUM(price) as total_price, DATE(date) as date1 
														FROM accounting_stat  
														GROUP BY date1");
				$today_profit = 0;
				$today_date = date('Y-m-d');
				foreach ($entrys as $profit) {

					if($profit->date1 == $today_date) {
						$today_profit += $profit-> total_price;
					}
				}
				return $today_profit;
		}

		function get_profit_for_this_monts() {
				$entrys = Accounting::find_by_sql("SELECT YEAR(date) as year, m, SUM(price) as total_price, DATE(date) as date1 
													FROM accounting_stat  
													GROUP BY date1 
													ORDER BY date1");
				$today_profit = 0;
				$today_year = date('Y');
				$today_month = date('m');

				foreach ($entrys as $profit) {

					if($profit->year == $today_year && $profit->m == $today_month) {
						$today_profit += $profit-> total_price;
					}
				}
				return $today_profit;
		}

		function get_statistic_for_today() {
				return $entrys = Accounting::find_by_sql("SELECT HOUR(date) as hour, price as total_price, DATE(date) as date1 
														FROM accounting_stat
														GROUP BY date1,hour
														ORDER BY date1,hour");
		}

		function get_statistic_for_months() {
			return $entrys = Accounting::find_by_sql("SELECT y as year, MONTH(date) as month, SUM(price) as total_price, DATE(date) as date1 
														FROM accounting_stat  
														GROUP BY date1 , month  
														ORDER BY date1");
		}

		function get_statistic_for_years() {
			return $entrys = Accounting::find_by_sql("SELECT YEAR(date) as year, SUM(price) as total_price 
														FROM accounting_stat 
														GROUP BY year");
		}

		function years_months_data_price() {
			return $entrys = Accounting::find_by_sql("SELECT Y, M, DATE(date) as date1, SUM(price) as total_price 
														FROM accounting_stat 
														GROUP BY date1 
														ORDER BY date1");
		}
			
		function years() {
			return $entrys = Accounting::find_by_sql("SELECT YEAR(date) as year 
														FROM accounting_stat 
														GROUP BY year 
														ORDER BY year");
		}

		function months() {
			return $entrys = Accounting::find_by_sql("SELECT MONTH(date) as month 
														FROM accounting_stat 
														GROUP BY month
														ORDER BY month");
		}
	}