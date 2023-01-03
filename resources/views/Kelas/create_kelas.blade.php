<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')

    <div class="content">
      <div class="card card-info card-outline">

        <div class="card-header">
          <h3>Tambah Kelas</h3>
        </div>

        <div class="card-body">
          <form action="{{ route('kelas.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
              <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" placeholder="Nama Kelas">
            </div>
            <div class="form-group">
              <select name="tingkatan" id="tingkatan" class="form-control">
                <option value="">Pilih Tingkatan</option>
                <option value="SMP">SMP</option>
                <option value="SMA">SMA</option>
                <option value="MA">MA</option>
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
