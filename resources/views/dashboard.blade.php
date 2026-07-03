<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dasbor Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <p class="text-sm font-medium text-slate-500 mb-1">Total Saldo Saat Ini</p>
                    <h3 class="text-3xl font-bold text-indigo-700">Rp {{ number_format($totalBalance, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <p class="text-sm font-medium text-slate-500 mb-1">Pemasukan Bulan Ini</p>
                    <h3 class="text-2xl font-semibold text-emerald-600">Rp {{ number_format($totalIncomeMonth, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <p class="text-sm font-medium text-slate-500 mb-1">Pengeluaran Bulan Ini</p>
                    <h3 class="text-2xl font-semibold text-rose-600">Rp {{ number_format($totalExpenseMonth, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-200 bg-slate-50/50">
                    <h3 class="text-lg font-semibold text-slate-800">Arus Kas Bulan Ini</h3>
                </div>
                <div class="p-6">
                    <div class="relative h-80 w-full">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('financeChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [
                        { label: 'Pemasukan (Rp)', data: {!! json_encode($chartIncome) !!}, borderColor: '#059669', backgroundColor: 'rgba(5, 150, 105, 0.1)', borderWidth: 2, fill: true, tension: 0.3 },
                        { label: 'Pengeluaran (Rp)', data: {!! json_encode($chartExpense) !!}, borderColor: '#e11d48', backgroundColor: 'rgba(225, 29, 72, 0.1)', borderWidth: 2, fill: true, tension: 0.3 }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
    </script>
</x-app-layout>