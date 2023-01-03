<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')

    <div class="content">
      <div class="card card-info card-outline">

        <div class="card-header">
          <h3>Tambah Siswa</h3>
        </div>

        <div class="card-body">
          <form action="{{ route('siswa.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
              <input type="text" id="NISN" name="NISN" class="form-control" placeholder="NISN">
            </div>
            <div class="form-group">
              <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Siswa">
            </div>

            <div class="form-group">
              <select name="kelas" id="kelas" class="form-control">
                <option value="">Pilih Kelas</option>
                @foreach ($kelasDt as $data)
                    <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <input type="text" id="merk" name="merk" class="form-control" placeholder="Merk Laptop">
            </div>
            <div class="form-group">
              <input type="text" id="spesifikasi" name="spesifikasi" class="form-control" placeholder="Spesifikasi Laptop">
            </div>

        </div>

        <div class="card-footer">
          <div class="text-right">
            <div class="form-group">
              <button class="btn btn-success" type="submit">Simpan</button>
            </div>
          </form>
          </div>
        </div>
      </div>
      

    </div>
@endsection
