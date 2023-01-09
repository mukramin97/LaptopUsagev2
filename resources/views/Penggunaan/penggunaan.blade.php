<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            Data Penggunaan
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <label for="filterKelas">Kelas</label>
                    <select name="filterKelas" id="filterKelas" class="custom-select filter">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelasDt as $data)
                            <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-md-2">
                    <label for="startDate">Tanggal Mulai</label>
                    <input type="date" id="startDate" name="startDate" class="form-control"
                        placeholder="Masukkan Tanggal Awal">
                </div>
                <div class="col-md-2">
                    <label for="startDate">Tanggal Selesai</label>
                    <input type="date" id="endDate" name="endDate" class="form-control"
                        placeholder="Masukkan Tanggal Akhir">
                </div>
                <div class="col-md-5">

                </div>
                <div class="col-md-1">
                    <label for="exportPenggunaan" style="visibility: hidden">Export</label>
                    <button id="exportPenggunaan" class="btn btn-primary" style="width: 100%">Export</button>
                </div>

            </div>
            <div class="divider"></div>
            <table class="table table-bordered example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Nama Kelas</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>

            </table>
        </div>
    </div>

    <script>
        $(function() {

            //FILTER KELAS
            let filterKelas = $("#filterKelas").val();
            let startDate = $("#startDate").val();
            let endDate = $("#endDate").val();

            //CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //DATATABLES
            var table = $(".example").DataTable({
                pageLength: 25,
                serverSide: true,
                processing: true,
                ajax: "{{ route('penggunaan.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'NISN',
                        name: 'NISN'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas'
                    },
                    {
                        data: 'tanggal_pinjam',
                        name: 'tanggal_pinjam'
                    },
                    {
                        data: 'tanggal_kembali',
                        name: 'tanggal_kembali'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return '<button class="btn btn-danger btn-sm custom-action-delete" data-id="' +
                                full.id + '">Delete</button>';
                        }
                    },
                ],
            });

            //AJAX ON CHANGE FILTER KELAS
            document.getElementById('filterKelas').addEventListener('change', function() {
                filterKelas = $("#filterKelas").val();
                // update the table data by making a new AJAX request with the updated parameters
                table.ajax.url("{{ route('penggunaan.index') }}?startDate=" + startDate + "&endDate=" +
                    endDate + "&filterKelas=" + filterKelas).load();
            });

            //AJAX ON CHANGE startDate
            document.getElementById('startDate').addEventListener('change', function() {
                startDate = $("#startDate").val();
                endDate = $("#endDate").val();
                // update the table data by making a new AJAX request with the updated parameters
                table.ajax.url("{{ route('penggunaan.index') }}?startDate=" + startDate + "&endDate=" +
                    endDate + "&filterKelas=" + filterKelas).load();
            });

            //AJAX ON CHANGE endDate
            document.getElementById('endDate').addEventListener('change', function() {
                startDate = $("#startDate").val();
                endDate = $("#endDate").val();
                // update the table data by making a new AJAX request with the updated parameters
                table.ajax.url("{{ route('penggunaan.index') }}?startDate=" + startDate + "&endDate=" +
                    endDate + "&filterKelas=" + filterKelas).load();
            });

            //AJAX Export Penggunaan
            $('#exportPenggunaan').click(function(e) {
                e.preventDefault();
                window.location = "{{ route('penggunaanExport') }}" + "?filterKelas=" + $("#filterKelas")
                    .val() + "&startDate=" + $("#startDate").val() + "&endDate=" + $("#endDate").val();
            });

            //AJAX BUTTON DELETE
            $(document).on('click', '.custom-action-delete', function() {
                var id = $(this).data('id');
                // make an AJAX request to execute the custom action based on the selected id
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('penggunaan.destroy', ':id') }}".replace(':id', id),
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data penggunaan berhasil dihapus!',
                            showConfirmButton: false,
                            timer: 1000,

                        });
                        $('#hasil-tindakan').html(data.message);
                        table.ajax.reload();
                    }

                });
            });


        });
    </script>
@endsection
