<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')

    <div class="card card-info card-outline">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <h3>Data Kelas</h3>
          </div>
          <div class="col-6 text-right">
            <a href="{{ route('kelas.create') }}" type="button" class="btn btn-success">Tambah</a>
          </div>

        </div>
        
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-md table-hover">
            <thead>
              <tr class="table-primary">
                <th scope="col" class="text-center" style="width: 50px">No</th>
                <th scope="col">ID Kelas</th>
                <th scope="col">Nama Kelas</th>
                <th scope="col">Tingkatan</th>
                <th scope="col" class="col-2 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              @foreach($datas as $data)
              <tr>
                <td class="text-center">{{ $no }}</td>
                <td>{{ $data->id }}</td>
                <td>{{ $data->nama_kelas }}</td>
                <td>{{ $data->tingkatan }}</td>
                <td class="text-center">
                  <div class="row">
                    <div class="col-6">
                      <a href="{{ route('kelas.edit',$data->id) }}" class="btn btn-primary">Edit</a>
                    </div>
                    <div class="col-6">
                      <form action="{{ route('kelas.destroy',$data->id) }}" method="post" onsubmit="">
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
