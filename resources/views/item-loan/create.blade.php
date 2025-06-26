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
                <form action="{{ route('item-loan.store') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label>Barang</label>
                  <select name="item_id" class="form-control" required>
                    <option value="">– Pilih Barang –</option>
                    @foreach($items as $i)
                      <option value="{{ $i->id }}">
                        {{ $i->name }} (stok: {{ $i->qty }})
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                <label>Peminjam</label>
                <select name="user_id" class="form-control" required>
                  <option value="">– Pilih Peminjam –</option>
                  @foreach($users as $u)
                    <option value="{{ $u->id }}"
                      {{ old('user_id') == $u->id ? 'selected' : '' }}>
                      {{ $u->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              
                <div class="form-group">
                  <label>Qty</label>
                  <input type="number" name="qty" class="form-control" min="1" required value="{{ old('qty') }}">
                </div>

                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label>Tanggal Mulai</label>
                      <input type="date" name="start_date" class="form-control" required value="{{ old('start_date') }}">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Tanggal Selesai</label>
                      <input type="date" name="end_date" class="form-control" required value="{{ old('end_date') }}">
                    </div>
                  </div>
                </div>
                
                <button class="btn btn-success mt-2">Simpan</button>
                <a href="{{ route('item-loan.index') }}" class="btn btn-secondary mt-2">Batal</a>
              </form>

            </div>
        </div>
    </div>
  </div>
  
@endsection
