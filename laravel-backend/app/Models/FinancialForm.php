<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialForm extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'savings',
        'debt',
        'monthly_income',
        'house_expense',
        'entertainment_expense',
        'food_expense',
        'transportation_expense',
        'healthcare_expense',
        'education_expense',
        'child_expense',
        'has_children',
        'total_investment',
        'investment_type',
        'financial_goals',
        'risk_tolerance',
        'calculated_level',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'savings' => 'decimal:2',
        'debt' => 'decimal:2',
        'monthly_income' => 'decimal:2',
        'house_expense' => 'decimal:2',
        'entertainment_expense' => 'decimal:2',
        'food_expense' => 'decimal:2',
        'transportation_expense' => 'decimal:2',
        'healthcare_expense' => 'decimal:2',
        'education_expense' => 'decimal:2',
        'child_expense' => 'decimal:2',
        'total_investment' => 'decimal:2',
        'has_children' => 'boolean',
    ];

    /**
     * Get the user that owns the financial form.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total monthly expenses.
     */
    public function getTotalMonthlyExpensesAttribute()
    {
        return $this->house_expense + 
               $this->entertainment_expense + 
               ($this->food_expense ?? 0) + 
               ($this->transportation_expense ?? 0) + 
               ($this->healthcare_expense ?? 0) + 
               ($this->education_expense ?? 0) + 
               ($this->child_expense ?? 0);
    }

    /**
     * Calculate monthly surplus.
     */
    public function getMonthlySurplusAttribute()
    {
        return $this->monthly_income - $this->total_monthly_expenses;
    }

    /**
     * Calculate emergency fund requirement (3-6 months expenses).
     */
    public function getEmergencyFundRequirementAttribute()
    {
        return $this->total_monthly_expenses * 3; // Minimum 3 months
    }

    /**
     * Check if user has sufficient emergency fund.
     */
    public function getHasEmergencyFundAttribute()
    {
        return $this->savings >= $this->emergency_fund_requirement;
    }

    /**
     * Calculate investment percentage of income.
     */
    public function getInvestmentPercentageAttribute()
    {
        if ($this->monthly_income <= 0) return 0;
        return ($this->total_investment ?? 0) / $this->monthly_income * 100;
    }
}
