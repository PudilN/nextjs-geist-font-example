<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birth_date',
        'gender',
        'address',
        'occupation',
        'monthly_income',
        'financial_level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'monthly_income' => 'decimal:2',
        'password' => 'hashed',
    ];

    /**
     * Get the financial forms for the user.
     */
    public function financialForms()
    {
        return $this->hasMany(FinancialForm::class);
    }

    /**
     * Get the latest financial form for the user.
     */
    public function latestFinancialForm()
    {
        return $this->hasOne(FinancialForm::class)->latest();
    }

    /**
     * Get the AI advices for the user.
     */
    public function aiAdvices()
    {
        return $this->hasMany(AIAdvice::class);
    }

    /**
     * Get the latest AI advice for the user.
     */
    public function latestAIAdvice()
    {
        return $this->hasOne(AIAdvice::class)->latest();
    }

    /**
     * Get the transactions for the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the financial goals for the user.
     */
    public function financialGoals()
    {
        return $this->hasMany(FinancialGoal::class);
    }
}
