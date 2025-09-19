<div class="row align-items-center mb-4">
    {{-- Pilihan Customer --}}
    <div class="col-md-6 mb-3 mb-md-0">
        <label
            for="customerSelect"
            class="form-label fw-bold d-block text-md-start text-center"
            >Pilih Customer:</label
        >
        <div class="d-flex justify-content-center justify-content-md-start">
            <select
                class="form-select"
                id="customerSelect"
                style="max-width: 250px"
            >
                <option value="all">Semua Customer</option>
                <option value="HPM" {{ request()->get('customer') == 'HPM' ? 'selected' : '' }}> HPM</option>
                <option value="ADM" {{ request()->get('customer') == 'ADM' ? 'selected' : '' }}> ADM</option>
                <option value="HINO" {{ request()->get('customer') == 'HINO' ? 'selected' : '' }}>HINO</option>
                <option value="MMKI" {{ request()->get('customer') == 'MMKI' ? 'selected' : '' }}>MMKI</option>
                <option value="SUZUKI" {{ request()->get('customer') == 'SUZUKI' ? 'selected' : '' }}>SUZUKI</option>
                <option value="TMMIN" {{ request()->get('customer') == 'TMMIN' ? 'selected' : '' }}>TMMIN</option>
            </select>
        </div>
    </div>

    {{-- Pilihan Tanggal --}}
    <div class="col-md-6">
        <label
            for="dateFilter"
            class="form-label fw-bold d-block text-md-end text-center"
            >Pilih Tanggal:</label
        >
        <div class="d-flex justify-content-center justify-content-md-end">
            <input
                type="date"
                class="form-control"
                id="dateFilter"
                style="max-width: 250px"
                value="{{ request()->get('date') ?? date('Y-m-d') }}"
            />
        </div>
    </div>
</div>

<script>
    customerSelect.addEventListener("change", function () {
        applyFilter();
    });

    dateFilter.addEventListener("change", function () {
        applyFilter();
    });

    const today = new Date().toISOString().split('T')[0];
    dateFilterInput.value = today;


    function applyFilter() {
        const selectedCustomer = customerSelect.value;
        const selectedDate = dateFilter.value;

        // kirim data ke router masing2 card

        window.location.href = `{{ route('dashboard') }}?customer=${selectedCustomer}&date=${selectedDate}`;
    }
</script>
