<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')

    <div class="content">
      <div class="card card-info card-outline">

        <div class="card-header">
          <h3>Tambah Kelas</h3>
        </div>

        <div class="card-body">
          <form action="{{ route('kelas.update',$editKelas->id) }}" method="post"> {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group">
              <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" placeholder="Nama Kelas" value="{{ $editKelas->nama_kelas }}">
            </div>
            <div class="form-group">
              <select name="tingkatan" id="tingkatan" class="form-control">
                <option value="">Pilih Tingkatan</option>
                <option value="SMP" @if ($editKelas->tingkatan == 'SMP') selected @endif>SMP</option>
                <option value="SMA" @if ($editKelas->tingkatan == 'SMA') selected @endif>SMA</option>
                <option value="MA" @if ($editKelas->tingkatan == 'MA') selected @endif>MA</option>
              </select>
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
