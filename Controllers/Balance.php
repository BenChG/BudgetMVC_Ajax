<?php
	
	namespace App\Controllers;
	
	use \Core\View;
	use \App\Models\BalanceSheet;
	use \App\Auth;
	
	/**
		* Profile controller
		*
		* PHP version 7.0
	*/
	class Balance extends  \Core\Controller
	{
		
	    /**
			* Before filter - called before each action method
			*
			* @return void
		*/
		protected function before()
		{
			parent::before();
			
			$this->user = Auth::getUser();
		}
		
		public function previousMonthAction()
		{
			$start = date("Y-m-d");
			$start = date('Y-m-01', strtotime($start. ' - 1 month')); 
			
			$end = date("Y-m-d");
			$end =date('Y-m-t', strtotime($end. ' - 1 month')); 
			
			$balanceSheet = new BalanceSheet($_POST);
			$balanceSheet->showBalance($start, $end);
			
			View::renderTemplate('Finances/showBalance.html', ['user' => $this->user]);
		}
		
		public function currentMonthAction()
		{
			$start= date("Y-m-01");
			$end = date("Y-m-t");
			
			$balanceSheet = new BalanceSheet($_POST);
			$balanceSheet->showBalance($start, $end);
			
			View::renderTemplate('Finances/showBalance.html', ['user' => $this->user]);
		}
		
		public function currentYearAction()
		{
			$start = date("Y-01-01");
			$end = date("Y-12-31");
			
			$balanceSheet = new BalanceSheet($_POST);
			$balanceSheet->showBalance($start, $end);
			
			View::renderTemplate('Finances/showBalance.html', [
			'user' => $this->user
			]);
		}
		
	}
	
