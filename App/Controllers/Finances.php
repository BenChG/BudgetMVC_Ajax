<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Transaction;
use \App\Auth;

/**
 * Profile controller
 *
 * PHP version 7.0
 */
class Finances extends  \Core\Controller
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
	
    /**
     *Show income page
     *
     * @return void
     */
    public function incomeAction()
    {
        View::renderTemplate('Finances/income.html', [
            'user' => $this->user
        ]);
	}
	
	/**
     *Show expense page
     *
     * @return void
     */
    public function expenseAction()
    {
        View::renderTemplate('Finances/expense.html', [
            'user' => $this->user
        ]);
	}
	
	    /**
     * Add a new income
     *
     * @return void
     */
    public function createIncomeAction()
    {
        $transaction = new Transaction($_POST);
		
        $transaction->addIncome();
		
		View::renderTemplate('Finances/newIncome.html');
	}
	
		    /**
     * Add a new expense
     *
     * @return void
     */
    public function createExpenseAction()
    {
        $transaction = new Transaction($_POST);
		
        $transaction->addExpense();
		
		View::renderTemplate('Finances/newExpense.html');
	}
	
 }

