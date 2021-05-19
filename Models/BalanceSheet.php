<?php
	
	namespace App\Models;
	
	use PDO;
	use \Core\View;
	
	/**
		* User model
		*
		* PHP version 7.0
	*/
	class BalanceSheet extends \Core\Model
	{
		
			public function __construct($data = [])
		{
			foreach ($data as $key => $value) {
				$this->$key = $value;
			};
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
		
		public function showBalance($start, $end)
		{
			global $SumOfIncomes;
			global $SumOfExpenses;	
			
			$userId = $this->id; 
			
			if (empty($this->errors)) {	
				
				$sql = 'SELECT * FROM incomes WHERE user_id=:userId AND date_of_income BETWEEN :start AND :end';
				
				echo "<div class='tile_icon_balance'><a href='/profile/show' class='link' title='Go back to Main Page'><i class='icon-home2'></i></a></div>";
				echo "<div class='header'> Personal budget </div>";
				echo "<div class='header_income' style='margin-bottom:10px;'> List of incomes:"."</div>"; 
				echo "<table>
				<tr>
				<th>Id</th>
				<th>Date</th>	
				<th>Amount</th>			
				<th>Category</th>
				<th>Comments</th>
				</tr>";
				
				$db = static::getDB();
				
				$stmt = $db->prepare($sql);
				
				$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
				$stmt->bindValue(':start', $start, PDO::PARAM_STR);
				$stmt->bindValue(':end', $end, PDO::PARAM_STR);
				
				$stmt->execute();
				
				foreach ($stmt as $row)
				{
					$sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE id=:categoryId'; 
					
					$db = static::getDB();
					$stmt = $db->prepare($sql);
					
					$categoryId = $row['income_category_assigned_to_user_id'];
					$stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
					
					$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
					
					$stmt->execute();
					$incomeCategory=$stmt->fetch()->name;
					
					
					echo "<tr>";
					echo "<td>" . $row ['id'] . "</td>";
					echo "<td>" . $row['date_of_income'] . "</td>";		
					echo "<td>" . $row['amount'] . " $</td>";				
					echo "<td>" . "$incomeCategory". "</td>";
					echo "<td>" . $row['income_comment'] . "</td>";
					echo "</tr>";	
				    $SumOfIncomes = $SumOfIncomes + $row['amount'];
				}
				
				echo "<tr>".'<td colspan="5"><div class="sumOf">Sum of incomes: '.number_format($SumOfIncomes,2)." $</div></td></tr>";
				echo "</table><div style='margin-top: 10px;'</div>";
			    echo "</table>";}
			
			if (empty($this->errors)) {	
				
				$sql = 'SELECT * FROM expenses WHERE user_id=:userId AND date_of_expense BETWEEN :start AND :end';
				echo "<div style='margin-bottom:10px;'></div>"; 
				echo "<div class='header_expense style='margin-bottom:5px;'> List of expenses:"."</div>"; 
				echo "<table>
				<tr>
				<th>Id</th>
				<th>Date</th>	
				<th>Amount</th>			
				<th>Category</th>
				<th>Comments</th>
				</tr>";
				
				$db = static::getDB();
				
				$stmt = $db->prepare($sql);
				
				$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
				$stmt->bindValue(':start', $start, PDO::PARAM_STR);
				$stmt->bindValue(':end', $end, PDO::PARAM_STR);
				
				$stmt->execute();
				
				foreach ($stmt as $row)
				{
					$sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE id=:categoryId'; 
					
					$db = static::getDB();
					$stmt = $db->prepare($sql);
					
					$categoryId = $row['expense_category_assigned_to_user_id'];
					$stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
					
					$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
					
					$stmt->execute();
					$expenseCategory=$stmt->fetch()->name;		
					
					echo "<tr>";
					echo "<td>" . $row ['id'] . "</td>";
					echo "<td>" . $row['date_of_expense'] . "</td>";		
					echo "<td>" . $row['amount'] . " $</td>";				
					echo "<td>" . "$expenseCategory". "</td>";
					echo "<td>" . $row['expense_comment'] . "</td>";
					echo "</tr>";		
					$SumOfExpenses = $SumOfExpenses + $row['amount'];
				}
				echo "<tr>".'<td colspan="6"><div class="sumOf">Sum of expenses: '.number_format($SumOfExpenses,2)." $</div></td></tr>";
				echo "</table>";	
				
				$Balance = $SumOfIncomes-$SumOfExpenses;
				
				echo "<div class='total_balance'>Total balance: ".number_format($Balance,2)." $ </div>";
				
				echo "</table>";	
			}
			
		}
		
	}		