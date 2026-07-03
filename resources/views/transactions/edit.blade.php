<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Ubah Data Transaksi') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-200 bg-slate-50/50">
                    <h3 class="text-lg font-semibold text-slate-800">Detail Transaksi</h3>
                </div>
                
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-md">
                            <ul class="list-disc list-inside text-rose-700 text-sm font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Transaksi</label>
                                <select name="type" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="pemasukan" {{ $transaction->type === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                    <option value="pengeluaran" {{ $transaction->type === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Transaksi</label>
                                <input type="date" name="transaction_date" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ $transaction->transaction_date }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nominal (Rp)</label>
                                <input type="number" name="amount" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ intval($transaction->amount) }}" min="1" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                                <input type="text" name="category" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ $transaction->category }}" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="note" rows="3" class="w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $transaction->note }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-slate-100">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-md text-sm font-medium transition-colors shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>