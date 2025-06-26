@extends('layout.main')


@section('breadcrumb')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Data Pinjaman Barang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pinjaman</li>
              <li class="breadcrumb-item active">Tambah</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
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
                <form action="{{ route('item-return.store') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="loan_id">Pilih Data Peminjaman Barang</label>
                  <select name="loan_id" id="loan_id" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    @foreach($loans as $loan)
                      <option value="{{ $loan->id }}"
                        {{ old('loan_id') == $loan->id ? 'selected' : '' }}>
                        {{ $loan->item->name }} — dipinjam oleh {{ $loan->user->name }} (Dipinjam: {{ $loan->remaining_qty }} pcs)
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="qty">Jumlah Barang Dikembalikan</label>
                  <input type="number" name="qty" id="qty" class="form-control"
                        min="1" value="{{ old('qty',1) }}" required>
                </div>
                  
              
                <div class="row">
                  <div class="col-3">

                  <div class="form-group">
                    <label for="return_date">Tanggal Pengembalian</label>
                    <input type="date" name="return_date" id="return_date" class="form-control"
                          value="{{ old('return_date', date('Y-m-d')) }}" required>
                  </div>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">Proses Pengembalian</button>
              </form>

            </div>
        </div>
    </div>
  </div>
  
@endsection
