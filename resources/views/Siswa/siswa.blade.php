<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')

    <div class="card card-info card-outline">
      <div class="card-header">
        <div class="row">
          <div class="col-9">
            <h3>Data Siswa</h3>
          </div>
          <div class="col-1 text-right">
            <a href="{{ route('siswaExport') }}" type="button" class="btn btn-primary">Export</a>
          </div>
          <div class="col-1 text-right">
            <a href="" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Import</a>
          </div>
          <div class="col-1 text-right">
            <a href="{{ route('siswa.create') }}" type="button" class="btn btn-success">Tambah</a>
          </div>

        </div>
        
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-md table-hover">
            <thead>
              <tr class="table-primary">
                <th scope="col" class="text-center" style="width: 50px">No</th>
                <th scope="col">NISN</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col">Kelas</th>
                <th scope="col">Laptop</th>
                <th scope="col" class="col-2 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              @foreach($siswaDt as $data)
              <tr>
                <td class="text-center">{{ $no }}</td>
                <td>{{ $data->NISN }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->kelas->nama_kelas }}</td>
                <td>{{ $data->laptop->merk }}</td>
                <td class="text-center">
                  <div class="row">
                    <div class="col-6">
                      <a href="{{ route('siswa.edit',$data->id) }}" class="btn btn-primary">Edit</a>
                    </div>
                    <div class="col-6">
                      <form action="{{ route('siswa.destroy',$data->id) }}" method="post" onsubmit="">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger delete-btn">Hapus</button>
                      </form>
                    </div>
                  </div>      
                </td>
              </tr>
              <?php $no++; ?>
              @endforeach
  
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
      $('.delete-btn').click(function(e) {
      e.preventDefault();
      var form = $(this).closest('form');
      Swal.fire({
        title: 'Apakah kamu yakin?',
        text: 'Menghapus kelas ini berarti menghapus seluruh data siswa dan data penggunaan yang terkait dengan kelas ini!',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Hapus',
        denyButtonText: `Batal`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          form.submit();
        } else if (result.isDenied) {
          Swal.fire('Batal menghapus', '', 'info')
        }
      })
    });
    </script>
@endsection
