<div class="max-w-4xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        Profil Perusahaan
    </h1>

    @if(session()->has('sukses'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('sukses') }}
        </div>
    @endif

    <div class="grid grid-cols-2 gap-4">

        <input wire:model="nama_perusahaan"
               class="border p-3 rounded"
               placeholder="Nama Perusahaan">

        <input wire:model="telepon"
               class="border p-3 rounded"
               placeholder="Telepon">

        <input wire:model="email"
               class="border p-3 rounded"
               placeholder="Email">

        <input wire:model="website"
               class="border p-3 rounded"
               placeholder="Website">

        <input wire:model="npwp"
               class="border p-3 rounded col-span-2"
               placeholder="NPWP">

        <input wire:model="direktur"
               class="border p-3 rounded"
               placeholder="Nama Direktur">

        <input wire:model="jabatan_penandatangan"
               class="border p-3 rounded"
               placeholder="Jabatan">

        <textarea wire:model="alamat"
                  class="border p-3 rounded col-span-2"
                  rows="4"
                  placeholder="Alamat Perusahaan"></textarea>

    </div>

    <button wire:click="simpan"
            class="mt-6 px-6 py-3 bg-black text-white rounded">
        Simpan Profil
    </button>

</div>