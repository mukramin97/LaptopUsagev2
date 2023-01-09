<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')
    <div class="content">

        <div class="card card-info card-outline">

            <div class="card-header">
                <h3>Tambah Siswa</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form action="{{ route('siswa.store') }}" method="post" id="create_siswa">
                            @csrf
                            <div class="form-group">
                                <label for="NISN">NISN</label>
                                <input type="text" class="form-control" id="NISN" name="NISN" placeholder="NISN">
                                <span class="text-danger error-text NISN_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama">
                                <span class="text-danger error-text nama_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <select name="kelas" id="kelas" class="custom-select">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelasDt as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text kelas_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="merk">Merk</label>
                                <input type="text" id="merk" name="merk" class="form-control"
                                    placeholder="Merk Laptop">
                                <span class="text-danger error-text merk_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="spesifikasi">Spesifikasi</label>
                                <textarea class="form-control" name="spesifikasi" id="spesifikasi" rows="2" placeholder="Spesifikasi Laptop"></textarea>
                                <span class="text-danger error-text spesifikasi_error"></span>

                            </div>
                            <button class="btn btn-success" type="submit">Simpan</button>
                        </form>

                    </div>
                </div>


            </div>
        </div>


    </div>

    <script>
        $('#create_siswa').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                    var listInput = ['#NISN', '#nama', '#kelas', '#merk', '#spesifikasi', ]
                    $.each(listInput, function(index, value) {
                        $(value).removeClass('is-invalid');
                    });
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('#' + prefix).addClass('is-invalid');
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        //Manual going to siswa page because the return is not working cause method on this ajax(probably)
                        window.location.href = '/siswa';
                    }
                }
            })
        })
    </script>
@endsection
