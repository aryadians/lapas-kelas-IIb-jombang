<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Daftar Pengikut Tersimpan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Berikut adalah daftar pengikut yang telah Anda simpan. Anda dapat menambah, mengubah, atau menghapusnya.') }}
        </p>
    </header>

    <!-- List of existing followers -->
    <div class="space-y-4">
        @forelse ($profil->pengikuts as $pengikut)
            <div class="flex items-center justify-between p-4 border rounded-lg">
                <div>
                    <p class="font-semibold">{{ $pengikut->nama }}</p>
                    <p class="text-sm text-gray-500">{{ $pengikut->hubungan }} - ID: {{ $pengikut->nik ?: 'Nihil' }}</p>
                </div>
                <form method="post" action="{{ route('profile.pengikut.destroy', $pengikut->id) }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Hapus') }}</button>
                </form>
            </div>
        @empty
            <p class="text-sm text-gray-500">{{ __('Anda belum memiliki pengikut tersimpan.') }}</p>
        @endforelse
    </div>

    <hr class="my-6">

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Tambah Pengikut Baru') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Isi formulir di bawah ini untuk menambahkan pengikut baru ke profil Anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.pengikut.store') }}" class="mt-6 space-y-6" x-data="{ identityType: 'nik' }">
        @csrf

        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">{{ __('Nama Lengkap') }}</label>
            <input id="nama" name="nama" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus />
        </div>

        <div>
            <label for="identitas_type" class="block text-sm font-medium text-gray-700">{{ __('Jenis Identitas') }}</label>
            <select id="identitas_type" name="identitas_type" x-model="identityType" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="nik">NIK (16 Digit)</option>
                <option value="lainnya">Lainnya (Paspor/SIM/dll)</option>
            </select>
        </div>

        <div>
            <label for="nik" class="block text-sm font-medium text-gray-700">
                <span x-text="identityType === 'nik' ? 'Nomor NIK' : 'Nomor Identitas (Opsional)'"></span>
            </label>
            <input id="nik" name="nik" :type="identityType === 'nik' ? 'number' : 'text'" 
                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                   :required="identityType === 'nik'"
                   :placeholder="identityType === 'nik' ? 'Wajib 16 digit' : 'Opsional'"
                   x-on:input="if(identityType === 'nik' && $el.value.length > 16) $el.value = $el.value.slice(0, 16)" />
        </div>

        <div>
            <label for="hubungan" class="block text-sm font-medium text-gray-700">{{ __('Hubungan') }}</label>
            <select id="hubungan" name="hubungan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="Istri/Suami">Istri/Suami</option>
                <option value="Anak">Anak</option>
                <option value="Saudara">Saudara</option>
                <option value="Orang Tua">Orang Tua</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">{{ __('Simpan Pengikut') }}</button>
        </div>
    </form>
</section>
