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
                    <label for="modeInput">Mode Input</label>
                    <select name="modeInput" id="modeInput" class="custom-select filter">
                        <option value="modePinjam" selected>Mode Pinjam</option>
                        <option value="modeKembali">Mode Kembali</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filterNISN">Input Peminjaman</label>
                    <input type="text" id="filterNISN" name="filterNISN" class="form-control"
                        placeholder="Masukkan NISN Siswa">
                </div>
                <div class="col-md-4">
                    <label for="filterNISNKembali">Input Pengembalian</label>
                    <input type="text" id="filterNISNKembali" name="filterNISNKembali" class="form-control"
                        placeholder="Masukkan NISN Siswa" disabled>
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

    <script type="text/javascript">
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
                ajax: "{{ route('dashboard.index') }}",
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
                            if (full.tanggal_pinjam != null && full.tanggal_kembali == null) {
                                return '<button class="btn btn-success btn-sm custom-action-kembalikan" data-id_penggunaan="' +
                                    full.id_penggunaan + '">Kembalikan</button>';
                            } else {
                                return '<button class="btn btn-primary btn-sm custom-action-pinjam" data-id="' +
                                    full.id + '">Pinjam</button>';
                            }

                        }
                    },

                ]
            });

            //AJAX ON CHANGE FILTER KELAS
            document.getElementById('filterKelas').addEventListener('change', function() {
                filterKelas = $("#filterKelas").val();
                // update the table data by making a new AJAX request with the updated parameters
                table.ajax.url("{{ route('dashboard.index') }}?filterKelas=" + this.value).load();
            });

            //AJAX INPUT PEMINJAMAN
            $('#filterNISN').focus();
            $('#filterNISN').on('keypress', function(e) {
                var filterNISN = $('#filterNISN').val();

                if (e.which == 13) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('storeByNISN') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'filterNISN': filterNISN
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'info',
                                    title: 'Laptop Siswa Berhasil Dipinjam!',
                                    showConfirmButton: false,
                                    timer: 1000,
                                });
                                $('#hasil-tindakan').html(data.message);
                                $('#filterNISN').val('');
                                table.ajax.reload();
                            } else if (data.status == 'laptop masih digunakan') {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Laptop masih digunakan, kembalikan laptop terlebih dahulu!',
                                    showConfirmButton: false,
                                    timer: 1000,
                                });
                                $('#filterNISN').val('');
                            } else {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Siswa tidak ditemukan!',
                                    showConfirmButton: false,
                                    timer: 1000,
                                });
                                $('#filterNISN').val('');
                            }

                        }
                    });
                }
            });

            //AJAX INPUT PENGEMBALIAN
            $('#filterNISNKembali').on('keypress', function(e) {
                var filterNISNKembali = $('#filterNISNKembali').val();

                if (e.which == 13) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('updateByNISN') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'filterNISNKembali': filterNISNKembali
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Laptop Siswa Berhasil Dikembalikan!',
                                    showConfirmButton: false,
                                    timer: 1000,
                                });
                                $('#hasil-tindakan').html(data.message);
                                $('#filterNISNKembali').val('');
                                table.ajax.reload();
                            } else if (data.status == 'laptop belum dipinjam') {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Laptop belum dipinjam, pinjam laptop terlebih dahulu!',
                                    showConfirmButton: false,
                                    timer: 1000,
                                });
                                $('#filterNISNKembali').val('');
                            } else {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Siswa tidak ditemukan!',
                                    showConfirmButton: false,
                                    timer: 1000,
                                });
                                $('#filterNISNKembali').val('');
                            }

                        }
                    });
                }
            });

            //AJAX BUTTON PINJAM
            $(document).on('click', '.custom-action-pinjam', function() {
                var id = $(this).data('id');
                // make an AJAX request to execute the custom action based on the selected id
                $.ajax({
                    type: 'POST',
                    url: "{{ route('penggunaan.store') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'siswa_id': id
                    },
                    success: function(data) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: 'Laptop Siswa Berhasil Dipinjam!',
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        $('#hasil-tindakan').html(data.message);
                        table.ajax.reload();
                    }
                });
            });

            //AJAX BUTTON PENGEMBALIAN
            $(document).on('click', '.custom-action-kembalikan', function() {
                var id_penggunaan = $(this).data('id_penggunaan');
                // make an AJAX request to execute the custom action based on the selected id
                $.ajax({
                    type: 'PUT',
                    url: "{{ route('penggunaan.update', ':id') }}".replace(':id', id_penggunaan),
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id_penggunaan
                    },
                    success: function(data) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Laptop Siswa Berhasil Dikembalikan!',
                            showConfirmButton: false,
                            timer: 1000,

                        });
                        $('#hasil-tindakan').html(data.message);
                        table.ajax.reload();
                    }

                });
            });

            //GANTI MODE INPUT
            $('#modeInput').on('change', function() {
                if (this.value == 'modePinjam') {
                    $('#filterNISN').prop('disabled', false);
                    $('#filterNISNKembali').prop('disabled', true);
                    $('#filterNISN').focus();
                } else if (this.value == 'modeKembali') {

                    $('#filterNISN').prop('disabled', true);
                    $('#filterNISNKembali').prop('disabled', false);
                    $('#filterNISNKembali').focus();
                }
            });


        });
    </script>
@endsection
