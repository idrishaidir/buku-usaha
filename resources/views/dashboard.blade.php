<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-md">
                    <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

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

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 mb-8 overflow-hidden">
                <div class="p-6 border-b border-slate-200 bg-slate-50/50">
                    <h3 class="text-lg font-semibold text-slate-800">Arus Kas Bulan Ini</h3>
                </div>
                <div class="p-6">
                    <div class="relative h-80 w-full">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 mb-8 overflow-hidden">
                <div class="p-6 border-b border-slate-200 bg-slate-50/50">
                    <h3 class="text-lg font-semibold text-slate-800">Catat Transaksi Baru</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('transactions.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="md:col-span-2 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-md">
                                <ul class="text-sm text-rose-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Transaksi</label>
                            <select name="type" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nominal (Rp)</label>
                            <input type="number" name="amount" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Contoh: 50000" min="1" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                            <input type="text" name="category" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Contoh: Penjualan Produk, Bahan Baku" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Catatan (Opsional)</label>
                            <textarea name="note" rows="2" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tambahkan keterangan singkat..."></textarea>
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-md text-sm font-medium transition-colors shadow-sm">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-semibold text-slate-800">Riwayat Transaksi</h3>
                    
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" required>
                        <span class="text-slate-500">-</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" required>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Cari
                        </button>
                        @if(request('start_date'))
                            <a href="{{ route('dashboard') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 text-sm border-b border-slate-200">
                                <th class="px-6 py-3 font-medium">Tanggal</th>
                                <th class="px-6 py-3 font-medium">Kategori</th>
                                <th class="px-6 py-3 font-medium">Catatan</th>
                                <th class="px-6 py-3 font-medium text-right">Nominal</th>
                                <th class="px-6 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-medium border border-slate-200">
                                            {{ $transaction->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">{{ $transaction->note ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-right {{ $transaction->type === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $transaction->type === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-3">
                                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                            Ubah
                                        </a>
    
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-900 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                        Belum ada data transaksi pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                    // Data label tanggal dari Controller
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [
                        {
                            label: 'Pemasukan (Rp)',
                            data: {!! json_encode($chartIncome) !!},
                            borderColor: '#059669', // emerald-600
                            backgroundColor: 'rgba(5, 150, 105, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointBackgroundColor: '#059669'
                        },
                        {
                            label: 'Pengeluaran (Rp)',
                            data: {!! json_encode($chartExpense) !!},
                            borderColor: '#e11d48', // rose-600
                            backgroundColor: 'rgba(225, 29, 72, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointBackgroundColor: '#e11d48'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    family: "'Nunito', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', sans-serif"
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    if (value >= 1000000) {
                                        return (value / 1000000) + ' Jt';
                                    } else if (value >= 1000) {
                                        return (value / 1000) + ' Rb';
                                    }
                                    return value;
                                }
                            },
                            grid: {
                                borderDash: [4, 4]
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>