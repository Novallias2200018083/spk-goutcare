<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pengguna.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-slate-800">
                {{ __('Edit Data Pasien') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.pengguna.update', $pengguna) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $pengguna->name) }}" required autofocus
                                    class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                <x-input-error :messages="$errors->get('name')" class="mt-1" />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $pengguna->email) }}" required
                                    class="w-full text-sm p-2.5 rounded border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                <x-input-error :messages="$errors->get('email')" class="mt-1" />
                            </div>

                            <div class="p-5 bg-slate-50 rounded-lg border border-slate-100">
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                                    <i class="fas fa-key mr-2"></i> Keamanan (Opsional)
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Password Baru</label>
                                        <input id="password" type="password" name="password" placeholder="Biarkan kosong jika tidak diubah"
                                            class="w-full text-sm p-2.5 rounded border-slate-200 bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Password</label>
                                        <input id="password_confirmation" type="password" name="password_confirmation"
                                            class="w-full text-sm p-2.5 rounded border-slate-200 bg-white focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 gap-3">
                            <a href="{{ route('admin.pengguna.index') }}" class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded font-bold text-xs uppercase tracking-widest hover:bg-emerald-700 transition-colors">
                                {{ __('Perbarui Data') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
