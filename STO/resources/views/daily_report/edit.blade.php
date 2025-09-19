@extends('layouts.app_user')

@section('contents')
    <div class="container">
        <div class="card mt-4 shadow-lg">
            <div class="card-body p-4">
                {{-- <h4><strong>PT Kyoraku Blowmolding Indonesia</strong></h4> --}}
                {{-- <p class="text-sm"><strong>PPIC Department / Warehouse Section</strong></p> --}}
                <div class="text-center mb-4">
                    <h4>Edit STO Report</h4>
                </div>

                <form method="POST" action="{{ route('sto.updateLog', $log->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Part info -->
                    <div class="mb-3">
                        <label class="form-label">Inventory Code</label>
                        <input type="text" class="form-control" value="{{ $log->part->Inv_id?? '-' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Part Name</label>
                        <input type="text" class="form-control" value="{{ $log->part->Part_name ?? '-' }}"disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Part Number</label>
                        <input type="text" class="form-control" value="{{ $log->part->Part_number ?? '-' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" class="form-control" value="{{ $log->part->category->name ?? '-' }}" disabled>
                    </div>
                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach ($statuses as $s)
                                <option value="{{ $s }}" {{ $log->status == $s ? 'selected' : '' }}>
                                    {{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity Inputs -->
                    <div class="mb-3 p-3 border rounded">
                        <h5 class="mb-3 text-center"><strong>QUANTITY INPUT</strong></h5>
                        <h6 class="col-12"><strong>ITEM COMPLETE </strong></h6>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Qty/Box</label>
                                <input type="number" name="qty_per_box" id="qty_per_box" class="form-control"
                                    value="{{ old('qty_per_box', $log->boxComplete->qty_per_box ?? '') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Qty Box</label>
                                <input type="number" name="qty_box" id="qty_box" class="form-control"
                                    value="{{ old('qty_box', $log->boxComplete->qty_box ?? '') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Total</label>
                                <input type="number" id="total" class="form-control" readonly
                                    value="{{ old('total', $log->boxComplete->total ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Grand Total</label>
                                <input type="number" id="grand_total" class="form-control" readonly
                                    value="{{ old('grand_total', $log->Total_qty ?? '') }}">
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary mt-3 col-md-12"
                            onclick="toggleOptionalQuantityInputs()">
                            SHOW UNCOMPLETE ITEM
                        </button>

                        <div id="optionalQuantityInputs" class="row mt-3"
                            style="display: {{ $log->boxUncomplete ? 'block' : 'none' }};">
                            <h6 class="col-12"><strong>ITEM UNCOMPLETE</strong></h6>
                            <div class="col-md-3">
                                <label>Qty/Box</label>
                                <input type="number" name="qty_per_box_2" id="qty_per_box_2" class="form-control"
                                    value="{{ old('qty_per_box_2', $log->boxUncomplete->qty_per_box ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Qty Box</label>
                                <input type="number" name="qty_box_2" id="qty_box_2" class="form-control"
                                    value="{{ old('qty_box_2', $log->boxUncomplete->qty_box ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Total</label>
                                <input type="number" id="total_2" class="form-control" readonly
                                    value="{{ old('total_2', $log->boxUncomplete->total ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <input type="hidden" name="prepared_by" value="{{ auth()->id() }}">
                    <input type="hidden" name="issued_date" value="{{ date('Y-m-d') }}">

                    <button type="submit" class="btn btn-success w-100">Update STO</button>
                    <a href="{{ route('dailyreport.index') }}" class="btn btn-info mt-3 col-12">Back</a>
                </form>
            </div>
        </div>
    </div>

    @push('sscripts')
        {{-- js --}}
        <script>
            document.getElementById('inv_id').addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                document.getElementById('part_name').value = selected.dataset.part || '';
                document.getElementById('part_number').value = selected.dataset.number || '';
                document.getElementById('category').value = selected.dataset.category || '';
                document.getElementById('plant').value = selected.dataset.plant || '';
                document.getElementById('area').value = selected.dataset.area || '';
            });
        </script>
    @endpush


    {{-- js box --}}
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                function calculateTotals() {
                    let QtyPerBox2 = parseFloat(document.getElementById("qty_per_box_2").value) || 0;
                    let QtyBox2 = parseFloat(document.getElementById("qty_box_2").value) || 0;
                    let qtyPerBox = parseFloat(document.getElementById("qty_per_box").value) || 0;
                    let qtyBox = parseFloat(document.getElementById("qty_box").value) || 0;

                    // Calculate totals
                    let Total2 = QtyPerBox2 * QtyBox2;
                    let total = qtyPerBox * qtyBox;
                    let grandTotal = Total2 + total;

                    // Update the input fields
                    document.getElementById("total_2").value = Total2;
                    document.getElementById("total").value = total;
                    document.getElementById("grand_total").value = grandTotal;
                }

                // Attach event listeners to inputs
                let inputs = document.querySelectorAll("#qty_per_box_2, #qty_box_2, #qty_per_box, #qty_box");
                inputs.forEach(input => {
                    input.addEventListener("input", calculateTotals);
                });
            });

            function toggleOptionalQuantityInputs() {
                $('#optionalQuantityInputs').toggle();
            }
        </script>
    @endpush
@endsection
