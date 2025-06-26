@extends('layout.main')


@section('breadcrumb')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
 {{-- bagian content: alert dengan tombol “×” --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  
  <div class="row">
    {{-- Box: Jumlah jenis barang --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $items->count() }}</h3>
          <p>Jenis Barang</p>
        </div>
        <div class="icon"><i class="fas fa-boxes"></i></div>
        <a href="{{ route('item.index') }}" class="small-box-footer">
          Lihat Semua <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    {{-- Box: Total Dipinjam --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $items->sum('total_loaned') }}</h3>
          <p>Total Barang Dipinjam</p>
        </div>
        <div class="icon"><i class="fas fa-arrow-circle-up"></i></div>
        <a href="{{ route('item-loan.index') }}" class="small-box-footer">
          Detail Peminjaman <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    {{-- Box: Total Dikembalikan --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $items->sum('total_returned') }}</h3>
          <p>Total Barang Dikembalikan</p>
        </div>
        <div class="icon"><i class="fas fa-arrow-circle-down"></i></div>
        <a href="{{ route('item-return.index') }}" class="small-box-footer">
          Detail Pengembalian <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    {{-- Box: Total Sisa --}}
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>
            {{ $items->sum(fn($i) => $i->total_loaned - $i->total_returned) }}
          </h3>
          <p>Total Barang Belum Dikembalikan</p>
        </div>
        <div class="icon"><i class="fas fa-box"></i></div>
        <a href="{{ route('item.index') }}" class="small-box-footer">
          Kelola Stok <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
  </div>

  {{-- Tabel detail stok & transaksi --}}
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Detail Stok & Transaksi</h3>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th class="text-center">Stok Sekarang</th>
            <th class="text-center">Total Dipinjam</th>
            <th class="text-center">Total Dikembalikan</th>
            <th class="text-center">Belum Dikembalikan</th>
          </tr>
        </thead>
        <tbody>
          @foreach($items as $no => $item)
            <tr>
              <td>{{ $no + 1 }}</td>
              <td>{{ $item->name }}</td>
              <td class="text-center">{{ $item->qty }}</td>
              <td class="text-center">{{ $item->total_loaned }}</td>
              <td class="text-center">{{ $item->total_returned }}</td>
              <td class="text-center">
                {{ $item->total_loaned - $item->total_returned }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('js')
<script>
  $(function () {
    // auto close alert after 5 seconds
    setTimeout(() => {
      $('.alert').alert('close');
    }, 5000);
  });
</script>
@endsection
