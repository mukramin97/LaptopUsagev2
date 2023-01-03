<!-- layout.blade.php -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">


    
    {{-- <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}" > --}}

    {{-- CDN Bootstrap
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}

    <style type="text/css">
      .divider{
        width: 100%;
        height: 1px;
        background: #BBB;
        margin: 1rem 0;
      }
    </style>

    <title>Aplikasi</title>
</head>
  <body class="login-page" style="min-height: 496.781px;">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>LaptopUsage</b>v2</a>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>      
          <form action="{{ route('loginProcess') }}" method="post">
            {{ csrf_field() }}
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Email" name="email" autofocus autocomplete="email">
              <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="current-password">
              <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                
              </div>

              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>

            </div>
          </form>
        </div>

      </div>
    </div>


    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>


  </body>
</html>
