<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            Data Siswa
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

                </div>
                <div class="col-md-5">

                </div>
                <div class="col-md-1">
                    <label for="importSiswa" style="visibility: hidden">Import</label>
                    <button id="importSiswa" class="btn btn-info" style="width: 100%" data-toggle="modal"
                        data-target="#exampleModal">Import</button>
                </div>
                <div class="col-md-1">
                    <label for="exportSiswa" style="visibility: hidden">Export</label>
                    <button id="exportSiswa" class="btn btn-primary" style="width: 100%">Export</button>
                </div>
                <div class="col-md-1">
                    <label for="tambahSiswa" style="visibility: hidden">Tambah</label>
                    <button id="tambahSiswa" class="btn btn-success" style="width: 100%">Tambah</button>
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
                        <th>Merk</th>
                        <th>Spesifikasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>

            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('siswaImport') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="file" name="file" required="required">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script>
        $(function() {

            //FILTER KELAS
            let filterKelas = $("#filterKelas").val();

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
                ajax: "{{ route('siswa.index') }}",
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
                        data: 'merk',
                        name: 'merk'
                    },
                    {
                        data: 'spesifikasi',
                        name: 'spesifikasi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return '<button class="btn btn-primary btn-sm custom-action-edit" data-id_edit="' +
                                full.id + '" onclick="window.location=\'siswa/' + full.id +
                                '/edit\';">Edit</button>' +
                                '<button class="btn btn-danger btn-sm custom-action-delete" data-id="' +
                                full.id + '">Delete</button>';
                        }
                    },
                ],
            });

            //AJAX ON CHANGE FILTER KELAS
            document.getElementById('filterKelas').addEventListener('change', function() {
                filterKelas = $("#filterKelas").val();
                // update the table data by making a new AJAX request with the updated parameters
                table.ajax.url("{{ route('siswa.index') }}?filterKelas=" + filterKelas).load();
            });

            //AJAX Export Siswa
            $('#exportSiswa').click(function(e) {
                e.preventDefault();
                window.location = "{{ route('siswaExport') }}";
            });

            //AJAX Tambah Siswa
            $('#tambahSiswa').click(function(e) {
                e.preventDefault();
                window.location = "{{ route('siswa.create') }}";
            });

            //AJAX BUTTON DELETE
            $(document).on('click', '.custom-action-delete', function() {
                var id = $(this).data('id');
                // make an AJAX request to execute the custom action based on the selected id
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('siswa.destroy', ':id') }}".replace(':id', id),
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data siswa berhasil dihapus!',
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
