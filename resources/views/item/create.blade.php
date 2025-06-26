@extends('layout.main')


@section('breadcrumb')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Data Barang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Barang</li>
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
                <form action="{{ route('item.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                    <label>Qty</label>
                    <input type="number" name="qty" class="form-control" value="{{ old('qty',0) }}" min="0" required>
                    </div>
                    <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                    </div>
                    <button class="btn btn-success mt-2">Simpan</button>
                    <a href="{{ route('item.index') }}" class="btn btn-secondary mt-2">Batal</a>
                </form>

            </div>
        </div>
    </div>
  </div>
  
@endsection
