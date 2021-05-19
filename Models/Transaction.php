<?php
	
	namespace App\Models;
	
	use PDO;
	use \Core\View;
	
	/**
		* User model
		*
		* PHP version 7.0
	*/
	class Transaction extends \Core\Model
	{
		
		/**
			* Error messages
			*
			* @var array
		*/
		public $errors = [];
		
		/**
			* Class constructor
			*
			* @param array $data  Initial property values (optional)
			*
			* @return void
		*/
		public function __construct($data = [])
		{
			foreach ($data as $key => $value) {
				$this->$key = $value;
			};
		}
		
		
		/**
			* Save the user model with the current property values
			*
			* @return boolean  True if the user was saved, false otherwise
		*/
		
		
		public static function findIncomeCategory($incomeCategory, $userId)
		{
			
			
			$sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE name = :incomeCategory and user_id= :userId'; 
			
		    $db = static::getDB();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':incomeCategory', $incomeCategory, PDO::PARAM_STR);
			$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
			
			$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
			$stmt->execute();
			return $stmt->fetch();
			
		}
		
	    /**
			* Save the user model with the current property values
			*
			* @return boolean  True if the user was saved, false otherwise
		*/
		
		public function addIncome()
		{
			//return empty($this->errors);
			
			$this->validateIncome();
			
			if (empty($this->errors)) {	
				
				$sql = 'INSERT INTO incomes (id, user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment)
				VALUES (:id, :userId, :incomeCategoryId, :incomeAmount, :incomeDate, :incomeComments)';
				
				$incomeCategory = $this->incomeCategory;
				$userId = $this->id; 
				
				$user_categories = static::findIncomeCategory($incomeCategory, $userId); 
				
				$incomeCategoryId = $user_categories->id;
				
				$db = static::getDB();
				
				$stmt = $db->prepare($sql);
				
				$stmt->bindValue(':id', NULL, PDO::PARAM_INT);
				$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
				$stmt->bindValue(':incomeCategoryId', $incomeCategoryId, PDO::PARAM_INT);
				$stmt->bindValue(':incomeAmount',  $this->incomeAmount, PDO::PARAM_STR);
				$stmt->bindValue(':incomeDate',  $this->incomeDate, PDO::PARAM_STR);
				$stmt->bindValue(':incomeComments',  $this->incomeComments, PDO::PARAM_STR);
				
				return $stmt->execute();
			}
			
			return false;
		}
		
		/**
			* Save the user model with the current property values
			*
			* @return boolean  True if the user was saved, false otherwise
		*/
		
		
		public static function findExpenseCategory($expenseCategory, $userId)
		{
			
			
			$sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE name = :expenseCategory and user_id= :userId'; 
			
		    $db = static::getDB();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':expenseCategory', $expenseCategory, PDO::PARAM_STR);
			$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
			
			$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
			$stmt->execute();
			return $stmt->fetch();
			
		}
		
		public static function findPaymentMethod($paymentMethod, $userId)
		{
			
			
			$sql = 'SELECT * FROM payment_methods_assigned_to_users WHERE name = :paymentMethod and user_id= :userId'; 
			
		    $db = static::getDB();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':paymentMethod', $paymentMethod, PDO::PARAM_STR);
			$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
			
			$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
			$stmt->execute();
			return $stmt->fetch();
			
		}
		
	    
		/** Save the user model with the current property values
			*
			* @return boolean  True if the user was saved, false otherwise
		*/
		
		public function addExpense()
		{
			//return empty($this->errors);
			
			$this->validateExpense();
			
			if (empty($this->errors)) {	
				
				$sql = 'INSERT INTO expenses (id, user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment)
				VALUES (:id, :userId, :expenseCategoryId, :paymentMethodId, :expenseAmount, :expenseDate, :expenseComments)';
				
				$expenseCategory = $this->expenseCategory;
				$paymentMethod = $this->paymentMethod;
				
				$userId = $this->id; 
				
				$user_categories = static::findExpenseCategory($expenseCategory, $userId); 
				$user_payment_methods = static::findPaymentMethod($paymentMethod, $userId); 
				
				$expenseCategoryId = $user_categories->id;
				$paymentMethodId = $user_payment_methods->id;
				
				$db = static::getDB();
				
				$stmt = $db->prepare($sql);
				
				$stmt->bindValue(':id', NULL, PDO::PARAM_INT);
				$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
				$stmt->bindValue(':expenseCategoryId', $expenseCategoryId, PDO::PARAM_INT);
				$stmt->bindValue(':paymentMethodId', $paymentMethodId, PDO::PARAM_INT);
				$stmt->bindValue(':expenseAmount',  $this->expenseAmount, PDO::PARAM_STR);
				$stmt->bindValue(':expenseDate',  $this->expenseDate, PDO::PARAM_STR);
				$stmt->bindValue(':expenseComments',  $this->expenseComments, PDO::PARAM_STR);
				
				return $stmt->execute();
			}
			
			return false;
		}
		
		/**	
			
			* Validate new income
			*
			* @return void
		*/   
		
		public function validateIncome()
		{
			/**
				// Amount
				if ($this->incomeAmount == 0) {
				$this->errors[] = 'Amount is required';
				}
				
				// Date
				if ($this->incomeDate == '') {
				$this->errors[] = 'Date is required';
				}
				
				// Category
				if ($this->incomeCategory == '') {
                $this->errors[] = 'Category is required';
				}
			*/
		}
		
		/**	  
			* Validate new expense 
			*
			* @return void
		*/
		
		public function validateExpense()
		{
			/**
				// Amount
				if ($this->expenseAmount == 0) {
				$this->errors[] = 'Amount is required';
				}
				
				// Date
				if ($this->expenseDate == '') {
				$this->errors[] = 'Date is required';
				}
				
				// Category
				if ($this->incomeCategory == '') {
				$this->errors[] = 'Category is required';
				}
				
				// Payment method
				if ($this->paymentMethod== '') {
				$this->errors[] = 'Payment method is required';
				}
			*/
		}
		
		
		/**
			* Find a user model by ID
			*
			* @param string $id The user ID
			*
			* @return mixed User object if found, false otherwise
		*/
		
		public static function findByID($id)
		{
			$sql = 'SELECT * FROM users WHERE id = :id';
			
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			
			$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
			
			$stmt->execute();
			
			return $stmt->fetch();
		}
		
		}
		