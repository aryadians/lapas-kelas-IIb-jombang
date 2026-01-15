<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Name -->
    <div>
        <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Produk</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
    </div>

    <!-- WBP Creator -->
    <div>
        <label for="wbp_creator_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Dibuat oleh (WBP)</label>
        <select name="wbp_creator_id" id="wbp_creator_id"
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="">Tidak ada</option>
            @foreach($wbps as $wbp)
                <option value="{{ $wbp->id }}" @selected(old('wbp_creator_id', $product->wbp_creator_id ?? '') == $wbp->id)>
                    {{ $wbp->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Price -->
    <div>
        <label for="price" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga</label>
        <input type="number" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" required
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
    </div>

    <!-- Stock -->
    <div>
        <label for="stock" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Stok</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? 1) }}" required
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
    </div>
    
    <!-- Status -->
    <div>
        <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Status</label>
        <select name="status" id="status"
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="tersedia" @selected(old('status', $product->status ?? 'tersedia') == 'tersedia')>Tersedia</option>
            <option value="terjual" @selected(old('status', $product->status ?? '') == 'terjual')>Terjual</option>
        </select>
    </div>

    <!-- Image -->
    <div class="md:col-span-2">
        <label for="image" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Gambar Produk</label>
        <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-full file:border-0
            file:text-sm file:font-semibold
            file:bg-blue-50 file:text-blue-700
            hover:file:bg-blue-100
        "/>
        @if(isset($product) && $product->image)
            <div class="mt-4">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-40 h-40 object-cover rounded-md shadow-md">
                <p class="text-xs text-gray-500 mt-2">Gambar saat ini</p>
            </div>
        @endif
    </div>

    <!-- Description -->
    <div class="md:col-span-2">
        <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Deskripsi</label>
        <textarea name="description" id="description" rows="6"
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>

<div class="flex items-center justify-end mt-8">
    <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white mr-6">
        Batal
    </a>
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
        {{ isset($product) ? 'Update Produk' : 'Simpan Produk' }}
    </button>
</div>
