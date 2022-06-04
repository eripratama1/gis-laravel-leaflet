@extends('layouts.app')

@section('style-css')
    {{-- load jquery datatable untuk menggunakannya --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Set Centre Point') }}</div>
                    <div class="card-body">
                        <a href="{{ route('centre-point.create') }}" class="btn btn-info btn-sm float-end mb-2">Tambah Data</a>
                        
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table" id="dataCentrePoint">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Titik Koordinat</th>
                                    <th>Opsi</th>
                                </tr>
                            <tbody></tbody>
                            </thead>
                        </table>
                        
                        {{-- tag form di gunakan untuk melakukan hapus data centrepoint yang di pilih
                        jadi ketika button yang ada pada view action.blade di klik akan menjalankan
                        fungsi javascript sweet alert2  --}}
                        <form action="" method="POST" id="deleteForm">
                            @csrf
                            @method("DELETE")
                            <input type="submit" value="Hapus" style="display: none">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    {{-- load jquery dan jquery datatable --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    <script>
    // ajaxserver side  datatable untuk menampilkan data centrepoint
        $(function() {
            $('#dataCentrePoint').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                ajax: '{{ route('centre-point.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'location'
                    },
                    {
                        data: 'action'
                    }
                ]
            })
        })
    </script>
@endpush
