<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Cicilan Umrah Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 md:p-8">


    <div x-data="{
            hargaPaket: 35000000,
            dp: 5000000,
            tenor: 12,
            marginRate: 1,
            formatRupiah(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(value);
            },
            get sisaPokok() {
                return Math.max(0, this.hargaPaket - this.dp);
            },
            get totalMargin() {
                return Math.max(0, this.sisaPokok * (this.marginRate / 100) * this.tenor);
            },
            get totalHutang() {
                return this.sisaPokok + this.totalMargin;
            },
            get cicilanPerBulan() {
                return this.tenor > 0 ? Math.round(this.totalHutang / this.tenor) : 0;
            }
         }"
         class="w-full max-w-5xl bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden grid grid-cols-1 lg:grid-cols-12">

        <div class="p-6 md:p-10 lg:col-span-7 space-y-6">
            <div>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full uppercase tracking-wider">Sales Tool</span>
                <h1 class="text-2xl font-bold text-slate-800 mt-2">Kalkulator Cicilan Umrah</h1>
                <p class="text-sm text-slate-500 mt-1">Simulasikan rencana pembayaran pembiayaan Umrah calon jemaah secara instan.</p>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Paket Umrah (Rp)</label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 font-medium">Rp</span>
                        </div>
                        <input type="number" x-model.number="hargaPaket"
                               class="block w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all font-medium text-slate-800"
                               placeholder="Contoh: 35000000">
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <button type="button" @click="hargaPaket = 28000000" class="px-3 py-1 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors font-medium">Promo (28jt)</button>
                        <button type="button" @click="hargaPaket = 35000000" class="px-3 py-1 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors font-medium">Reguler (35jt)</button>
                        <button type="button" @click="hargaPaket = 42000000" class="px-3 py-1 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors font-medium">VIP (42jt)</button>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-semibold text-slate-700">Uang Muka / Down Payment (DP)</label>
                        <span class="text-xs text-slate-500 font-medium" x-text="'Minimal 10%: ' + formatRupiah(hargaPaket * 0.1)"></span>
                    </div>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 font-medium">Rp</span>
                        </div>
                        <input type="number" x-model.number="dp"
                               :class="dp < (hargaPaket * 0.1) ? 'border-amber-400 focus:ring-amber-400' : 'border-slate-200 focus:ring-emerald-500'"
                               class="block w-full pl-12 pr-4 py-3 bg-slate-50 border rounded-xl focus:bg-white focus:ring-2 transition-all font-medium text-slate-800">
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <button type="button" @click="dp = Math.round(hargaPaket * 0.1)" class="px-3 py-1 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors font-medium">10% DP</button>
                        <button type="button" @click="dp = Math.round(hargaPaket * 0.2)" class="px-3 py-1 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors font-medium">20% DP</button>
                        <button type="button" @click="dp = Math.round(hargaPaket * 0.3)" class="px-3 py-1 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors font-medium">30% DP</button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tenor Cicilan (Bulan)</label>
                    <div class="grid grid-cols-4 gap-3">
                        <template x-for="t in [3, 6, 12, 24]">
                            <button type="button" @click="tenor = t"
                                    :class="tenor === t ? 'bg-emerald-600 text-white border-emerald-600 shadow-md shadow-emerald-100' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100'"
                                    class="py-3 px-4 rounded-xl border text-center font-semibold text-sm transition-all cursor-pointer"
                                    x-text="t + ' Bulan'">
                            </button>
                        </template>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Margin Layanan Flat (% / Bulan)</label>
                    <div class="relative rounded-xl shadow-xs">
                        <input type="number" step="0.1" x-model.number="marginRate"
                               class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all font-medium text-slate-800">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 font-semibold">%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 bg-gradient-to-br from-emerald-800 to-teal-950 p-6 md:p-10 text-white flex flex-col justify-between">
            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-semibold opacity-90">Simulasi Cicilan</h2>
                    <p class="text-xs opacity-75 mt-0.5">Estimasi pembayaran bulanan jemaah</p>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15">
                    <span class="text-xs font-medium uppercase tracking-wider opacity-80">Cicilan Per Bulan</span>
                    <div class="text-3xl md:text-4xl font-extrabold mt-1 tracking-tight" x-text="formatRupiah(cicilanPerBulan)"></div>
                    <div class="text-xs opacity-75 mt-2" x-text="'Tenor selama ' + tenor + ' bulan'"></div>
                </div>

                <div class="space-y-3 text-sm pt-2">
                    <div class="flex justify-between opacity-85">
                        <span>Harga Paket</span>
                        <span class="font-semibold" x-text="formatRupiah(hargaPaket)"></span>
                    </div>
                    <div class="flex justify-between opacity-85">
                        <span>Uang Muka (DP)</span>
                        <span class="font-semibold text-emerald-300" x-text="'- ' + formatRupiah(dp)"></span>
                    </div>
                    <div class="border-t border-white/20 my-2"></div>
                    <div class="flex justify-between opacity-90">
                        <span>Sisa Pokok Hutang</span>
                        <span class="font-semibold" x-text="formatRupiah(sisaPokok)"></span>
                    </div>
                    <div class="flex justify-between opacity-85">
                        <span x-text="'Total Margin Ujrah (' + marginRate + '%/bln)'"></span>
                        <span class="font-semibold" x-text="formatRupiah(totalMargin)"></span>
                    </div>
                    <div class="border-t border-white/20 my-2"></div>
                    <div class="flex justify-between text-base font-bold">
                        <span>Total Kewajiban</span>
                        <span class="text-yellow-300" x-text="formatRupiah(totalHutang)"></span>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-white/10 text-[11px] opacity-70 leading-relaxed">
                * Perhitungan di atas merupakan simulasi sementara. Persetujuan nilai cicilan final disesuaikan dengan syarat & ketentuan mitra pembiayaan syariah yang berlaku.
            </div>
        </div>

    </div>

</body>
</html>
