@extends('layout.main')

@section('breadcrumb')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Data Peminjaman Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('item-loan.index') }}">Peminjaman</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
      <div class="card"> 
        <div class="card-body">
          <form action="{{ route('item-return.update', $item_return) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="form-group mb-3">
            <label for="loan_id">Pilih Peminjaman</label>
            <select name="loan_id" id="loan_id" class="form-control" required>
              <option value="">-- Pilih --</option>
              @foreach($loans as $loan)
                @php
                  $returned = $loan->returns()->sum('qty');
                  $remaining = $loan->qty - $returned + ($loan->id === $item_return->loan_id ? $item_return->qty : 0);
                @endphp
                <option value="{{ $loan->id }}"
                  {{ old('loan_id', $item_return->loan_id) == $loan->id ? 'selected' : '' }}>
                  {{ $loan->item->name }}
                  — dipinjam oleh {{ $loan->user->name }}
                  (sisa: {{ $remaining }} pcs)
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="qty">Qty Dikembalikan</label>
            <input type="number" name="qty" id="qty" class="form-control"
                  min="1"
                  value="{{ old('qty', $item_return->qty) }}"
                  required>
          </div>

          <div class="form-group mb-4">
            <label for="return_date">Tanggal Pengembalian</label>
            <input type="date" name="return_date" id="return_date" class="form-control"
                  value="{{ old('return_date', $item_return->return_date->format('Y-m-d')) }}"
                  required>
          </div>

          <button type="submit" class="btn btn-primary">Update</button>
          <a href="{{ route('item-return.index') }}" class="btn btn-secondary">Batal</a>
        </form>
        </div>
      </div>
    </div>
  </div>
@endsection
