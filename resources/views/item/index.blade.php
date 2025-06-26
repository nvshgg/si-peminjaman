@extends('layout.main')

@section('css')

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

@endsection

@section('breadcrumb')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daftar Barang</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Barang</li>
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


  <a href="{{ route('item.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <table id="contoh" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Nama Barang</th>
              <th>Qty</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          @foreach($items as $no => $item)
            <tr>
              <td class="text-center">{{ $no + 1 }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->qty }}</td>
              <td>{{ ucfirst($item->status) }}</td>
              <td>
                <a href="{{ route('item.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('item.destroy', $item) }}" method="POST" style="display:inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger"
                          onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(document).ready(function() {
    $('#contoh').dataTable()
  })
</script>
<script>
  $(function () {
    if ( ! $.fn.DataTable.isDataTable('#contoh') ) {
      $('#contoh').DataTable({
        responsive: true,
        autoWidth: false,
        buttons: ['copy','csv','excel','pdf','print','colvis']
      }).buttons().container()
        .appendTo('#contoh_wrapper .col-md-6:eq(0)');
    }
  });
</script>
<script>
  $(function () {
    // auto close alert after 5 seconds
    setTimeout(() => {
      $('.alert').alert('close');
    }, 5000);
  });
</script>
@endsection
