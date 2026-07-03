<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalIncomeMonth = Transaction::where('user_id', $user->id)
            ->where('type', 'pemasukan')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $totalExpenseMonth = Transaction::where('user_id', $user->id)
            ->where('type', 'pengeluaran')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $allIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'pemasukan')
            ->sum('amount');

        $allExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'pengeluaran')
            ->sum('amount');
        
        $totalBalance = $allIncome - $allExpense;

        $daysInMonth = Carbon::now()->daysInMonth;
        $chartLabels = [];
        $chartIncome = [];
        $chartExpense = [];

        for ($i = 1; $i <= $daysInMonth; $i++){
            $chartLabels[] = $i;
            $dateString = Carbon::now()->startOfMonth()->addDays($i - 1)->format('Y-m-d');

            $chartIncome[] = Transaction::where('user_id', $user->id)
                ->where('transaction_date', $dateString)
                ->where('type', 'pemasukan')
                ->sum('amount');

            $chartExpense[] = Transaction::where('user_id', $user->id)
                ->where('transaction_date', $dateString)
                ->where('type', 'pengeluaran')
                ->sum('amount');
        }

        return view('dashboard', compact(
            'totalBalance',
            'totalIncomeMonth',
            'totalExpenseMonth',
            'chartLabels',
            'chartIncome',
            'chartExpense'
        ));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Transaction::where('user_id', $user->id);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }
    
    public function store(Request $request)
    {
        // Validasi Input Pengguna
        // dd($request->all());

        $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran',
            'amount' => 'required|numeric|min:1',
            'category' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string'
        ]);

        // Menyimpan Transaksi ke Database
        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'category' => $request->category,
            'transaction_date' => $request->transaction_date,
            'note' => $request->note,
        ]);
        return redirect()->route('dashboard')->with('Success!!!', 'Transaksi Berhasil Dicatat');
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, "Anda Tidak Memiliki Akses Untuk Mengedit Transaksi Ini");
        }
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, "Anda Tidak Memiliki Akses Untuk Mengedit Transaksi Ini");
        }

        $request->validate([
            "type" => "required|in:pemasukan,pengeluaran",
            "amount" => "required|numeric|min:1",
            "category" => "required|string|max:255",
            "transaction_date" => "required|date",
            "note" => "nullable|string"
        ]);

        $transaction->update([
            'type' => $request->type,
            'amount' => $request->amount,
            'category' => $request->category,
            'transaction_date' => $request->transaction_date,
            'note' => $request->note,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi Berhasil Diperbarui'
        );
    }

    public function destroy(Transaction $transaction)
    {
        if($transaction->user_id !== Auth::id()){
            abort(403, "Anda Tidak Memiliki Akses Untuk Menghapus Transaksi Ini");
        }
        $transaction->delete();
        return redirect()->route('dashboard')->with('success', 'Transaksi Berhasil Dihapus');
    }
}
