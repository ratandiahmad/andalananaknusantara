@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Input Profit</h2>

        <form action="{{ route('profits.storeInstansi') }}" method="POST">
            @csrf
            <input type="hidden" name="surat_pesanan_instansi_id" value="{{ $profit_sp->id }}">

            <!-- SP field (disabled, filled with total_per_object) -->
            <div class="form-group">
                <label for="sp">SP (Total Per Object)</label>
                <input type="number" step="0.01" class="form-control" id="sp" name="sp"
                    value="{{ $totalPerObject }}" readonly>
            </div>

            <div class="form-group">
                <label for="po_modal">PO Modal</label>
                <input type="number" step="0.01" class="form-control" id="po_modal" name="po_modal" required
                    oninput="calculateProfit()">
            </div>

            <div class="form-group">
                <label for="pembayaran_distri">Pembayaran Distributor</label>
                <input type="number" step="0.01" class="form-control" id="pembayaran_distri" name="pembayaran_distri"
                    required oninput="calculateProfit()">
            </div>

            <div class="form-group">
                <label for="cashback">Cashback</label>
                <input type="number" step="0.01" class="form-control" id="cashback" name="cashback" required
                    oninput="calculateProfit()">
            </div>

            <!-- Simple profit calculator output -->
            <div class="form-group">
                <label for="final_profit">Final Profit</label>
                <input type="number" step="0.01" class="form-control" id="final_profit" name="final_profit" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script>
        function calculateProfit() {
            const sp = parseFloat(document.getElementById('sp').value) || 0;
            const po_modal = parseFloat(document.getElementById('po_modal').value) || 0;
            const pembayaran_distri = parseFloat(document.getElementById('pembayaran_distri').value) || 0;
            const cashback = parseFloat(document.getElementById('cashback').value) || 0;

            // Kalkulasi hutang distributor
            const hutang_distri = po_modal - pembayaran_distri;

            // Kalkulasi piutang
            const piutang = sp - cashback;

            // Kalkulasi profit akhir
            const final_profit = piutang - hutang_distri - pembayaran_distri;

            // Update nilai final_profit ke field
            document.getElementById('final_profit').value = final_profit.toFixed(2);
        }
    </script>
@endsection
