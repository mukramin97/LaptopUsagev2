<!-- kelas.blade.php -->
@extends('.template.layout')

@section('content')
  <div class="card">
    <div class="card-header">
      Data Kelas
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-2">
          <div class="form-group">
            <label for="filterTingkatan">Tingkatan</label>
            <select name="filterTingkatan" id="filterTingkatan" class="custom-select">
              <option value="">Pilih Tingkatan</option>
              <option value="SMP">SMP</option>
              <option value="SMA">SMA</option>
              <option value="MA">MA</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          
        </div>
        <div class="col-md-5">
          
        </div>
        <div class="col-md-1">
          <label for="importKelas" style="visibility: hidden">Import</label>
          <button id="importKelas" class="btn btn-info" style="width: 100%" data-toggle="modal" data-target="#exampleModal">Import</button>
        </div>
        <div class="col-md-1">
          <label for="exportKelas" style="visibility: hidden">Export</label>
          <button id="exportKelas" class="btn btn-primary" style="width: 100%">Export</button>
        </div>
        <div class="col-md-1">
          <label for="tambahKelas" style="visibility: hidden">Tambah</label>
          <button id="tambahKelas" class="btn btn-success" style="width: 100%">Tambah</button>
        </div>

      </div>
    <div class="divider"></div>
    <table class="table table-bordered example">
      <thead>
          <tr>
              <th>No</th>
              <th>ID Kelas</th>
              <th>Nama Kelas</th>
              <th>Tingkatan</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
      </tbody>

    </table>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Kelas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('kelasImport') }}" method="POST" enctype="multipart/form-data">
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
  $(function(){

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
        ajax: "{{ route('kelas.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'id', name: 'id'},
            { data: 'nama_kelas', name: 'nama_kelas'},
            { data: 'tingkatan', name: 'tingkatan'},
            { data: 'action', name: 'action', orderable: false, searchable: false,
                render: function(data, type, full, meta){
                    return  '<button class="btn btn-primary btn-sm custom-action-edit" data-id_edit="'+full.id+'" onclick="window.location=\'kelas/'+full.id+'/edit\';">Edit</button>' + 
                            '<button class="btn btn-danger btn-sm custom-action-delete" data-id="'+full.id+'">Delete</button>';
            }},
        ],
    });

    //AJAX ON CHANGE FILTER TINGKATAN
    document.getElementById('filterTingkatan').addEventListener('change', function() {
        filterTingkatan = $("#filterTingkatan").val();
        // update the table data by making a new AJAX request with the updated parameters
        table.ajax.url("{{ route('kelas.index') }}?filterTingkatan=" + filterTingkatan).load();
    });

    //AJAX Export Siswa
    $('#exportKelas').click(function(e) {
        e.preventDefault();
        window.location = "{{ route('kelasExport') }}";
    });

    //AJAX Tambah Siswa
    $('#tambahKelas').click(function(e) {
        e.preventDefault();
        window.location = "{{ route('kelas.create') }}";
    });

    //AJAX BUTTON DELETE
    $(document).on('click', '.custom-action-delete', function() {
          var id = $(this).data('id');
          // make an AJAX request to execute the custom action based on the selected id
          $.ajax({
              type: 'DELETE',
              url: "{{ route('kelas.destroy', ':id') }}".replace(':id', id),
              data: {
              '_token': "{{ csrf_token() }}",
              },
              success: function(data) {
                  Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Data kelas berhasil dihapus!',
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
