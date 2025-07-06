<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.kriteria.update', $kriteria) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <x-input-label for="nama_kriteria" :value="__('Nama Kriteria')" />
                            <x-text-input id="nama_kriteria" class="block mt-1 w-full" type="text" name="nama_kriteria" :value="old('nama_kriteria', $kriteria->nama_kriteria)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_kriteria')" class="mt-2" />
                        </div>

                        <div class="mb-5">
                            <x-input-label for="bobot" :value="__('Bobot (untuk SAW)')" />
                            <x-text-input id="bobot" class="block mt-1 w-full" type="number" step="0.01" min="0" max="1" name="bobot" :value="old('bobot', $kriteria->bobot)" required />
                            <p class="text-sm text-gray-500 mt-1">Rentang bobot antara 0.00 hingga 1.00. Total bobot semua kriteria SAW idealnya adalah 1.00.</p>
                            <x-input-error :messages="$errors->get('bobot')" class="mt-2" />
                        </div>

                        <div class="mb-5">
                            <x-input-label for="tipe" :value="__('Tipe Kriteria')" />
                            <select id="tipe" name="tipe" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Pilih Tipe</option>
                                <option value="benefit" {{ old('tipe', $kriteria->tipe) == 'benefit' ? 'selected' : '' }}>Benefit (Semakin Tinggi Semakin Baik)</option>
                                <option value="cost" {{ old('tipe', $kriteria->tipe) == 'cost' ? 'selected' : '' }}>Cost (Semakin Rendah Semakin Baik)</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipe')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button href="{{ route('admin.kriteria.index') }}" class="me-3">
                                {{ __('Batal') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Perbarui Kriteria') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>