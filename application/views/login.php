
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Login Siswa dan Guru</title>

  <link href="<?php echo base_url()."/assets/bootstrap/css/bootstrap.min.css"; ?>" rel="stylesheet" type="text/css"  />
  <style type="text/css">
.spasiAtas{
	margin-top:20px;
}
.nav-tabs > li > a {
	border: 0px solid transparent;
}
li#tab_siswa > a{
	background-color:#0085c1;
	color:#fff;
}
li#tab_guru > a{
	background-color:#e67f22;
	color:#fff;
}
li#tab_buatsiswa > a{
	background-color:#95a5a5;
	color:#fff;
}
li#tab_buatguru > a{
	background-color:#27ae61;
	color:#fff;
}
#siswa .panel-default{
	background:#0085c1;	
	border-color:#0085c1;
}
#guru .panel-default{
	background:#e67f22;	
	border-color:#e67f22;
}
#signup1 .panel-default{
	background:#95a5a5;	
	border-color:#95a5a5;
}
#signup2 .panel-default{
	background:#27ae61;	
	border-color:#27ae61;
}
.panel-body{
	background-color:rgba(255, 255, 255, 0.33);
	border:0px solid #000;

}
</style>
<script type="text/javascript" src="<?php echo base_url()."/assets/jquery-1.11.2.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."/assets/bootstrap/js/bootstrap.min.js"; ?>"></script>
<script type="text/javascript">
$(function(){
	$("#tabUtama a").click(function (e) {
		e.preventDefault();
		var x=$(this).attr("href");
		var warna='';
		switch(x){
			case "#guru":warna="#e67f22";break;
			case "#siswa":warna="#0085c1";break;
			case "#signup1":warna="#95a5a5";break;
			case "#signup2":warna="#27ae61";break;
		}
		$("body").css("background-color",warna);
		$("#status").html("");
		$(this).tab('show');
	});
});
</script>

</head>

<body style="background-color:#0085c1;"> <!--background-image:url(images/pattern.png);-->
<div class="container-fluid">

	<div id="tabUtama" class="spasiAtas">
       <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" id="tab_siswa"><a href="#siswa" aria-controls="siswa" role="tab" data-toggle="tab">Siswa</a></li>
    <li role="presentation" id="tab_guru" ><a href="#guru" aria-controls="guru" role="tab" data-toggle="tab">Guru</a></li>
    <li role="presentation" id="tab_buatsiswa"><a href="#signup1" aria-controls="signup1" role="tab" data-toggle="tab">Buat Akun Siswa</a></li>
    <li role="presentation" id="tab_buatguru"><a href="#signup2" aria-controls="signup2" role="tab" data-toggle="tab">Buat Akun Guru</a></li>
  </ul>
  </div><!--end tabUtama-->



	<!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="siswa">
	<div class="row spasiAtas">
    <div class="col-lg-12">
      <div class="alert alert-info" role="alert"><strong>Silahkan Login sebagai SISWA</strong></div>
    </div>
  </div>
		 <div class="row">
    <div class="col-md-5">
      <div id="logo">
        <center><img src="<?php echo base_url()."/assets/images/logo-smk.png"; ?>"/></center><br><br>
        <!--<center><img src="<?php echo base_url()."/images/logo-sipanse.png"; ?>" /></center>-->
      </div>
    </div>
    <div class="col-md-5 col-md-offset-1">
	<div class="panel panel-default spasiAtas">
		<div class="panel-body">
      <div class="form-login">
        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url()."/login/cekloginSiswa"; ?>">
          <div class="form-group">
            <label for="username" class="col-sm-4 control-label">NIS</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="username" placeholder="NIS">
              </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-4 control-label">Password</label>
              <div class="col-sm-7">
                <input type="password" class="form-control" name="password" placeholder="Password">
              </div>
          </div>
          <div class="form-group">
              <div class="col-sm-offset-4 col-sm-7">
                <div class="checkbox">
                  <label>
                  <input type="checkbox"> Remember me
                  </label>
                </div>
              </div>
          </div>
          <div class="form-group">
              <div class="col-sm-offset-4 col-sm-10">
                <button type="submit" class="btn btn-default">Sign in</button>
              </div>
          </div>
        </form>
      </div>
	  </div></div>
    </div>
  </div> <!-- /div class="row" -->
	</div><!--end tab-pane-->
	<div role="tabpanel" class="tab-pane fade" id="guru">
	<div class="row spasiAtas">
    <div class="col-lg-12">
      <div class="alert alert-info" role="alert"><strong>Silahkan Login sebagai GURU</strong></div>
    </div>
  </div>
		 <div class="row">
    <div class="col-md-5">
      <div id="logo">
        <center><img src="<?php echo base_url()."/assets/images/logo-smk.png"; ?>"/></center><br><br>
        <!--<center><img src="<?php echo base_url()."/images/logo-sipanse.png"; ?>" /></center>-->
      </div>
    </div>
    <div class="col-md-5 col-md-offset-1">
	<div class="panel panel-default spasiAtas">
		<div class="panel-body">
      <div class="form-login">
        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url()."/login/cekloginGuru"; ?>">
          <div class="form-group">
            <label for="username" class="col-sm-4 control-label">Kode Guru/NIP</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="username" placeholder="Kode Guru/NIP">
              </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-4 control-label">Password</label>
              <div class="col-sm-7">
                <input type="password" class="form-control" name="password" placeholder="Password">
              </div>
          </div>
          <div class="form-group">
              <div class="col-sm-offset-4 col-sm-7">
                <div class="checkbox">
                  <label>
                  <input type="checkbox"> Remember me
                  </label>
                </div>
              </div>
          </div>
          <div class="form-group">
              <div class="col-sm-offset-4 col-sm-10">
                <button type="submit" class="btn btn-default">Sign in</button>
              </div>
          </div>
        </form>
      </div>
	  </div></div>
    </div>
  </div> <!-- /div class="row" -->
	</div><!--end tab-pane-->
	
	<div role="tabpanel" class="tab-pane fade" id="signup1">
	<div class="row spasiAtas">
    <div class="col-lg-12">
      <div class="alert alert-info" role="alert"><strong>Silahkan Buat Akun Baru</strong></div>
    </div>
  </div>
		 <div class="row">
    <div class="col-md-5">
      <div id="logo">
        <center><img src="<?php echo base_url()."/assets/images/logo-smk.png"; ?>"/></center><br><br>
        <!--<center><img src="<?php echo base_url()."/images/logo-sipanse.png"; ?>" /></center>-->
      </div>
    </div>
    <div class="col-md-5 col-md-offset-1">
	<div class="panel panel-default spasiAtas">
		<div class="panel-body">
      <div class="form-login">
      <form class="form-horizontal" method="post" role="form" action="<?php echo site_url("siswa/buatAkun"); ?>">
		          	<div class="form-group">
		            <label for="nis" class="col-sm-4 control-label">NIS</label>
		              	<div class="col-sm-7">
		                <input type="text" name="nis" class="form-control"  placeholder="NIS">
		              	</div>
		          	</div>
		          	<div class="form-group">
		          	<label for="nis" class="col-sm-4 control-label">Nama</label>
		              	<div class="col-sm-7">
		                <input type="text" name="nama" class="form-control"  placeholder="Nama Lengkap">
		              	</div>
		          	</div>
		          	<div class="form-group">
		            <label for="nama" class="col-sm-4 control-label">E-mail</label>
		            	<div class="col-sm-7">
		                <input type="email" name="email" class="form-control"  placeholder="E-mail">
		              	</div>
		          	</div>
		          	<div class="form-group">
		            <label for="nama" class="col-sm-4 control-label">Password</label>
		            	<div class="col-sm-7">
		                <input type="password" name="password" class="form-control"  placeholder="Password">
		              	</div>
		          	</div>
					<div class="form-group">
		            <label for="nama" class="col-sm-4 control-label">Ulangi Password</label>
		            	<div class="col-sm-7">
		                <input type="password" name="password2" class="form-control"  placeholder="Ulangi Password">
		              	</div>
		          	</div>
		          	<div class="form-group">
		            <label for="nis" class="col-sm-4 control-label">No. Telepon</label>
		              	<div class="col-sm-7">
		                <input type="text" name="no_telp" class="form-control"  placeholder="Nomor telepon / Hp">
		              	</div>
		          	</div>
		          	<div class="form-group">
		            	<div class="col-sm-offset-4 col-sm-10">
		                	<button type="submit" class="btn btn-default">Sign Up</button>
		              	</div>
		          	</div>
		        </form>
      </div>
	  </div></div>
    </div>
  </div> <!-- /div class="row" -->
	</div><!--end tab-pane-->
	
	<div role="tabpanel" class="tab-pane fade" id="signup2">
	<div class="row spasiAtas">
    <div class="col-lg-12">
      <div class="alert alert-info" role="alert"><strong>Silahkan Buat Akun Baru</strong></div>
    </div>
  </div>
		 <div class="row">
    <div class="col-md-5">
      <div id="logo">
        <center><img src="<?php echo base_url()."/assets/images/logo-smk.png"; ?>"/></center><br><br>
        <!--<center><img src="<?php echo base_url()."/images/logo-sipanse.png"; ?>" /></center>-->
      </div>
    </div>
    <div class="col-md-5 col-md-offset-1">
	<div class="panel panel-default spasiAtas">
		<div class="panel-body">
      <div class="form-login">
        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url("guru/buatAkun"); ?>">
		          	<div class="form-group">
		            <label for="nis" class="col-sm-4 control-label">Kode Guru/NIP</label>
		              	<div class="col-sm-7">
		                <input type="text" name="nip" class="form-control"  placeholder="Kode Guru/NIP">
		              	</div>
		          	</div>
		          	<div class="form-group">
		          	<label for="nis" class="col-sm-4 control-label">Nama</label>
		              	<div class="col-sm-7">
		                <input type="text" name="nama" class="form-control"  placeholder="Nama Lengkap">
		              	</div>
		          	</div>
		          	<div class="form-group">
		            <label for="nama" class="col-sm-4 control-label">E-mail</label>
		            	<div class="col-sm-7">
		                <input type="email" name="email" class="form-control"  placeholder="E-mail">
		              	</div>
		          	</div>
		          	<div class="form-group">
		            <label for="nama" class="col-sm-4 control-label">Password</label>
		            	<div class="col-sm-7">
		                <input type="password" name="password" class="form-control"  placeholder="Password">
		              	</div>
		          	</div>
					<div class="form-group">
		            <label for="nama" class="col-sm-4 control-label">Ulangi Password</label>
		            	<div class="col-sm-7">
		                <input type="password" name="password2" class="form-control"  placeholder="Ulangi Password">
		              	</div>
		          	</div>
		          	<div class="form-group">
		            <label for="nis" class="col-sm-4 control-label">No. Telepon</label>
		              	<div class="col-sm-7">
		                <input type="text" name="no_telp" class="form-control"  placeholder="Nomor telepon / Hp">
		              	</div>
		          	</div>
		          	<div class="form-group">
		            	<div class="col-sm-offset-4 col-sm-10">
		                	<button type="submit" class="btn btn-default">Sign Up</button>
		              	</div>
		          	</div>
		        </form>
      </div>
	  </div></div>
    </div>
  </div> <!-- /div class="row" -->
	</div><!--end tab-pane-->
	
	</div><!--end tab-content-->
 
  
  <div class="row">
    <div class="col-md-4 col-md-offset-6" id="status">
       <?php echo $status; ?>
    </div>
  </div>
</div>
<script type="text/javascript">
$("[href='<?php echo $tab; ?>']").tab('show');
$("body").css("background-color",'<?php echo $color; ?>');
</script>
</body>
</html>
