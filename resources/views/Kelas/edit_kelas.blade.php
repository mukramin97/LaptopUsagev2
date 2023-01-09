<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')
    <div class="content">
        <div class="card card-info card-outline">

            <div class="card-header">
                <h3>Tambah Kelas</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('kelas.update', $editKelas->id) }}" method="post" id="edit_kelas">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" placeholder="Nama Kelas"
                            value="{{ $editKelas->nama_kelas }}">
                        <span class="text-danger error-text nama_kelas_error"></span>
                    </div>

                    <div class="form-group">
                        <select name="tingkatan" id="tingkatan" class="custom-select">
                            <option value="">Pilih Tingkatan</option>
                            <option value="SMP" @if ($editKelas->tingkatan == 'SMP') selected @endif>SMP</option>
                            <option value="SMA" @if ($editKelas->tingkatan == 'SMA') selected @endif>SMA</option>
                            <option value="MA" @if ($editKelas->tingkatan == 'MA') selected @endif>MA</option>
                        </select>
                        <span class="text-danger error-text tingkatan_error"></span>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>


    </div>

    <script>
        $('#edit_kelas').on('submit', function(e) {
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
                    var listInput = ['#nama_kelas', '#tingkatan']
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
                        window.location.href = '/kelas';
                    }
                }
            })
        })
    </script>
@endsection
