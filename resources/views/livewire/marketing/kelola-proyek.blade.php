<div class="p-6 text-[#003057]" style="font-family: 'Inter', sans-serif;">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
    </style>

    <!-- Header & Search -->
    @include('livewire.marketing.kelola-proyek.partials.table')

    <!-- Modal Form (Create & Edit) -->
    @if($isModalOpen)
        @include('livewire.marketing.kelola-proyek.partials.modal-form')
    @endif

    <!-- Detail Popup -->
    @if($isDetailOpen && $detailProyek)
        @include('livewire.marketing.kelola-proyek.partials.detail-popup')
    @endif
</div>