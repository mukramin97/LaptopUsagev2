<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')

    <div class="content">
      <div class="card card-info card-outline">

        <div class="card-header">
          <h3>Edit Siswa</h3>
        </div>

        <div class="card-body">
          <form action="{{ route('siswa.update',$editSiswa->id) }}" method="post"> {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group">
              <input type="text" id="NISN" name="NISN" class="form-control" placeholder="NISN" value="{{ $editSiswa->NISN }}">
            </div>
            <div class="form-group">
              <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Siswa" value="{{ $editSiswa->nama }}">
            </div>
            <div class="form-group">
              <select name="kelas" id="kelas" class="form-control">
                <option value="">Pilih Kelas</option>
                @foreach ($kelasDt as $data)
                    <option
                      @if ($data->id == $editSiswa->kelas->id)
                        selected
                      @endif
                    value="{{ $data->id }}">{{ $data->nama_kelas }}
                    </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <input type="text" id="merk" name="merk" class="form-control" placeholder="Merk" value="{{ $editSiswa->laptop->merk }}">
            </div>
            <div class="form-group">
              <input type="text" id="spesifikasi" name="spesifikasi" class="form-control" placeholder="Spesifikasi" value="{{ $editSiswa->laptop->spesifikasi }}">
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
