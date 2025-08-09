<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialForm;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class FinancialController extends Controller
{
    /**
     * Simpan data form keuangan dan hitung level keuangan.
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'savings' => 'required|numeric|min:0',
            'debt' => 'required|numeric|min:0',
            'monthly_income' => 'required|numeric|min:0',
            'house_expense' => 'required|numeric|min:0',
            'entertainment_expense' => 'required|numeric|min:0',
            'total_investment' => 'nullable|numeric|min:0',
            'investment_type' => 'nullable|string|max:255',
            'has_children' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Hitung level keuangan sederhana
        $level = $this->calculateLevel($data);

        // Simpan data form
        $financialForm = FinancialForm::updateOrCreate(
            ['user_id' => $data['user_id']],
            [
                'savings' => $data['savings'],
                'debt' => $data['debt'],
                'monthly_income' => $data['monthly_income'],
                'house_expense' => $data['house_expense'],
                'entertainment_expense' => $data['entertainment_expense'],
                'total_investment' => $data['total_investment'] ?? 0,
                'investment_type' => $data['investment_type'] ?? null,
                'has_children' => $data['has_children'],
                'calculated_level' => $level,
            ]
        );

        // Update level di tabel users
        $user = User::find($data['user_id']);
        $user->financial_level = $level;
        $user->save();

        return response()->json([
            'message' => 'Data keuangan berhasil disimpan',
            'level' => $level,
            'financial_form' => $financialForm,
        ]);
    }

    /**
     * Hitung level keuangan berdasarkan data.
     */
    private function calculateLevel(array $data): int
    {
        $savings = $data['savings'];
        $debt = $data['debt'];
        $monthlyIncome = $data['monthly_income'];
        $totalExpenses = $data['house_expense'] + $data['entertainment_expense'];

        if ($savings < 10000000) {
            return 0; // Belum mencapai level 1
        }
        if ($debt > 0) {
            return 1; // Level 1: Melunasi hutang kecil
        }
        if ($savings < $totalExpenses * 3) {
            return 2; // Level 2: Siapkan dana darurat
        }
        if ($monthlyIncome > 0 && ($monthlyIncome * 0.2) < 1000000) {
            return 3; // Level 3: Investasi minimal 20%
        }
        if (!empty($data['has_children']) && $data['has_children']) {
            return 4; // Level 4: Dana pendidikan anak
        }
        // Level 5 ke atas bisa dikembangkan lebih lanjut
        return 5;
    }
}
