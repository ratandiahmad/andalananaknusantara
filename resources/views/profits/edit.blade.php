@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Profit</h2>

        <form action="{{ route('profits.update', $profit->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="sp">SP</label>
                <input type="number" step="0.01" class="form-control" id="sp" name="sp"
                    value="{{ $profit->sp }}" required>
            </div>

            <div class="form-group">
                <label for="po_modal">PO Modal</label>
                <input type="number" step="0.01" class="form-control" id="po_modal" name="po_modal"
                    value="{{ $profit->po_modal }}" required>
            </div>

            <div class="form-group">
                <label for="pembayaran_distri">Pembayaran Distributor</label>
                <input type="number" step="0.01" class="form-control" id="pembayaran_distri" name="pembayaran_distri"
                    value="{{ $profit->pembayaran_distri }}" required>
            </div>

            <div class="form-group">
                <label for="cashback">Cashback</label>
                <input type="number" step="0.01" class="form-control" id="cashback" name="cashback"
                    value="{{ $profit->cashback }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
