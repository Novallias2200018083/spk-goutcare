<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Makanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.makanan.update', $makanan) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <x-input-label for="nama_makanan" :value="__('Nama Makanan')" />
                            <x-text-input id="nama_makanan" class="block mt-1 w-full" type="text" name="nama_makanan" :value="old('nama_makanan', $makanan->nama_makanan)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_makanan')" class="mt-2" />
                        </div>

                        <div class="mb-5">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('deskripsi', $makanan->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <h3 class="font-semibold text-lg mt-8 mb-4 border-b pb-2">Nilai Kriteria Nutrisi:</h3>
                        <p class="text-sm text-gray-600 mb-4">Perbarui nilai nutrisi untuk setiap kriteria berikut. Perhatikan tipe kriteria (Benefit/Cost).</p>

                        @php
                            $currentNilaiKriteria = $makanan->nilaiKriteria->keyBy('kriteria_id');
                        @endphp

                        @foreach ($kriterias as $kriteria)
                            <div class="mb-5">
                                <x-input-label for="nilai_kriteria_{{ $kriteria->id }}">
                                    {{ $kriteria->nama_kriteria }}
                                    <span class="font-normal text-gray-500">({{ ucfirst($kriteria->tipe) }})</span>
                                </x-input-label>
                                <x-text-input id="nilai_kriteria_{{ $kriteria->id }}" class="block mt-1 w-full" type="number" step="0.01" name="nilai_kriteria[{{ $kriteria->id }}]" :value="old('nilai_kriteria.' . $kriteria->id, $currentNilaiKriteria[$kriteria->id]->nilai ?? '')" required />
                                <x-input-error :messages="$errors->get('nilai_kriteria.' . $kriteria->id)" class="mt-2" />
                            </div>
                        @endforeach

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button href="{{ route('admin.makanan.index') }}" class="me-3">
                                {{ __('Batal') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Perbarui Makanan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>