<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url()?>assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>assets/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?=base_url()?>assets/admin/index2.html"><b>CKA </b> POT</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silahkan Login</p>
      <?= $this->session->userdata('nama');?>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" id="user" class="form-control" placeholder="NIK" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="pswd" class="form-control" placeholder="Password" name="pswd">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <!-- <button type="" id="btn" class="btn btn-primary btn-block">Sign In</button> -->
          </div>
          <!-- /.col -->
        </div>
      </form>
      <button type="" id="btn" class="btn btn-primary btn-block">Sign In</button>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?=base_url()?>assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/admin/dist/js/adminlte.min.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<script type="text/javascript">
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
      $('#btn').on('click',function(){
        var user = $('#user').val();
        var pass = $('#pswd').val();
        $.ajax({
            type: "POST",
            url : "<?= base_url('login/dologin')?>",
            data: 'username='+user+'&pswd='+pass, 
            dataType: 'json',
            success: function(res){
                if (res.errorMsg){
                    Toast.fire({
                    type: 'error',
                    title: ''+res.errorMsg+'.'
                    })
                } else {
                    console.log('res', res.errorMsg)
                    Toast.fire({
                    type: 'success',
                    title: ''+res.message+'.'
                })
                window.setTimeout(function(){
                  window.location.href="<?= base_url('admin')?>";
                },1000);
                }
            // success: function(msg){
            //   var jsondata= JSON.parse(JSON.stringify(msg));
            //   var val = jsondata.data.map(function(e) {
            //      return e.value;
            //   });
            //   var message = jsondata.data.map(function(e) {
            //      return e.message;
            //   });
            //   if (val == 0){
            //     Toast.fire({
            //       type: 'error',
            //       title: ''+message+'.'
            //       })
            //   }else{
            //     Toast.fire({
            //       type: 'success',
            //       title: ''+message+'.'
            //     });
            //     window.setTimeout(function(){
                //   window.location.href="";
            //     },1000);
            //   }
            // }
            }
        },'json'); 
      });
    </script>
</body>
</html>
