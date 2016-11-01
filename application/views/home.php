<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $judulKonten; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url()."assets/bootstrap/css/bootstrap.min.css"; ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url()."assets/sb-admin/css/sb-admin.css"; ?>" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url()."assets/sb-admin/css/plugins/morris.css"; ?>"	rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url()."assets/fontawesome/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css">
	    <link href="<?php echo base_url()."assets/font-awesome/css/font-awesome.min.css";?>" rel="stylesheet" type="text/css">

	
    <link href="<?php echo base_url()."assets/datepicker/css/bootstrap-datepicker3.min.css";?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()."assets/bootstrap-select/dist/css/bootstrap-select.min.css";?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()."assets/style.css";?>" rel="stylesheet" type="text/css">
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style type="text/css">
	.spasiAtas{
		margin-top:20px;
	}
.btn-file {
    position: relative;
    overflow: hidden;
}
.modal{
	overflow:scroll;
}
.spasiBawah{
	margin-bottom:50px;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
.top-nav>li>a{
	color:#fff;
}
.navbar-inverse .dropdown-menu>li>a{
	color:#333333;
}
.navbar-inverse{
	background-color:#3498DB;
}
.navbar-inverse .dropdown-menu>li>a:hover{
	color:#fff;
}
	</style>
	<script src="<?php echo base_url()."assets/jquery-1.11.2.min.js"; ?>"></script>
		 <script src="<?php echo base_url()."assets/bootstrap/js/bootstrap.min.js"; ?>"></script>

		 <script src="<?php echo base_url()."assets/datepicker/js/bootstrap-datepicker.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url()."assets/datepicker/locales/bootstrap-datepicker.id.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url()."assets/jquery.form.min.js"; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url()."assets/jquery.bootpag.min.js"; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url()."assets/bootstrap-select/dist/js/bootstrap-select.min.js"; ?>"></script>
	<script type="text/javascript">
	$(function(){
		$("body").data("isRefresh",false);
		$("#setting").click(function(e){
			e.preventDefault();
			$.ajax({
				url:'<?php echo site_url('home/getAkun'); ?>',
				type:'get',
				dataType:'json'
			}).done(function(data){
				$("[name='username']").val(data.username);
				$("[name='nama']").val(data.nama);
				$("[name='email']").val(data.email);
				$("[name='no_telp']").val(data.no_telp);
				$("#modalEditAkun").modal('show');
			}).fail(function(xhr,err){
				alert(err);
			});
		});
		$("#modalLog").on("hidden.bs.modal",function(e){
			if($("body").data("isRefresh")==true)window.location.reload();
		});
		$("#frmEditAkun2,#frmEditAkun").ajaxForm({
			beforeSend:function(){
				$("button,input").prop("disabled",true);
			},
			dataType:'json',
			success:function(data){
				$("button,input").prop("disabled",false);
				if(data.sukses){
					$("#logJudul").html("Sukses");
					$("#logBody").html(data.sukses);
					$("body").data("isRefresh",true);
				}else if(data.error){
					$("#logJudul").html("Error");
					$("#logBody").html(data.error);
					$("body").data("isRefresh",false);
				}else{
					$("#logJudul").html("Error");
					$("#logBody").html("Error tidak diketahui");
					$("body").data("isRefresh",false);
				}
				$("#modalLog").modal('show');
				$("[name='username']").prop("disabled",true);
			},
			error:function(xhr,error){
				alert(error);
			}
		});
		$("#profile").click(function(e){
			e.preventDefault();
			$.ajax({
				url:'<?php echo site_url('home/getProfile'); ?>',
				type:'get',
				dataType:'json'
			}).done(function(data){
				if(data.nis){
					$("#dataNis").html(data.nis);
					$("#dataNisn").html(data.nisn);
					$("#dataNama").html(data.nama);
					$("#dataJenkel").html(data.jen_kel);
					$("#dataNoTelp").html(data.no_telp);
					$("#dataJurusan").html(data.nama_full);
					$("#dataKelas").html(data.prefix_kelas+" "+data.nama_jurusan+" "+data.nomor_kelas);
					$("#dataTmptTglLahir").html(data.tempat_lahir+", "+data.tgl_lahir);
					$("#dataAgama").html(data.agama);
					$("#dataAlamat").html(data.alamat);
					$("#dataAyah").html(data.nama_ayah);
					$("#dataIbu").html(data.nama_ibu);
					$("#dataPekerjaaAyah").html(data.pekerjaan_ayah);
					$("#dataPekerjaaIbu").html(data.pekerjaan_ibu);
					$("#dataAlamatOrtu").html(data.alamat_ortu);
					if(data.photo==null)$("#dataPhoto").hide();
					else{
						$("#dataPhoto").show();
						$("#dataPhoto").attr("src",'<?php echo base_url(); ?>/'+data.photo);
					}
					$("#modalDetail").modal('show');
				}else if(data.kode_guru){
					$("#dataKodeGuru").html(data.kode_guru);
					$("#dataNip").html(data.nip);
					$("#dataNama").html(data.nama);
					$("#dataNoTelp").html(data.telepon);
					$("#dataTmptTglLahir").html(data.tempat_lahir+', '+data.tgl_lahir);
					$("#dataAlamat").html(data.alamat);
					if(data.photo==null)$("#dataPhoto").hide();
					else{
						$("#dataPhoto").show();
						$("#dataPhoto").attr("src",'<?php echo base_url(); ?>/'+data.photo);
					}
					if(data.prefix_kelas!=null){
						$("#dataWalikelas").html(data.prefix_kelas+' '+data.nama_jurusan+' '+data.nomor_kelas);
					}
					$("#modalDetail").modal('show');
				}
			}).fail(function(xhr,err){
				alert(err);
			});
		});
	});
	
	</script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url(); ?>">E-Raport</a>
            </div>
            <!-- Top Menu Items -->
                    
				
            <ul class="nav navbar-right top-nav">
			<?php if($hak_akses=="siswa"){ ?>
			<li>
			                    <a href="<?php echo site_url("home/raport"); ?>"><strong><i class="glyphicon glyphicon-education"></i> Raport</strong></a>
</li>
			<?php  } ?>
				<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong>Informasi</strong> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
					     <li>
                            <a href="<?php echo site_url("home/pengumuman"); ?>">Pengumuman</a>
                        </li>
                   
                           
                    </ul>
				</li>
                <
              
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $nama_user; ?> ( <?php echo $user; ?> ) <b class="caret"></b></a>
                    <ul class="dropdown-menu">
						<?php 
						if($hak_akses=="guru"){
						echo '<li>
                            <a href="'.site_url('admin/index').'" id="dashboardguru"><i class="fa fa-tachometer"></i> Dashboard Guru</a>
                        </li>';	
						}
						?>
                        <li>
                            <a href="#" id="profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#" id="setting"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo site_url("home/logout"); ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->

    <!-- Bootstrap Core JavaScript -->

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url()."assets/sb-admin/js/plugins/morris/raphael.min.js"; ?>"></script>
    <script src="<?php echo base_url()."assets/sb-admin/js/plugins/morris/morris.min.js"; ?>"></script>
    <!--<script src="<?php echo base_url()."js/plugins/morris/morris-data.js"; ?>"></script>-->
	
</body>
<div id="headerUtama">
<?php echo $headerUtama;?>
</div>

<div id="kontenUtama">
<?php echo $kontenUtama; ?>

</div><!--end kontenUtama-->

<div id="footerwrap">
   		<div id="social">
			<div class="container">
				<div class="row centered">
					<div class="col-lg-3">
						<center><a href="#"><i class="fa fa-google-plus fa-5x"></i></a></center>
					</div>
					<div class="col-lg-3">
						<center><a href="https://www.facebook.com/groups/1258070230886242/"><i class="fa fa-facebook fa-5x"></i></a></center>
					</div>
					<div class="col-lg-3">
						<center><a href="#"><i class="fa fa-twitter fa-5x"></i></a></center>
					</div>
					<div class="col-lg-3">
						<center><a href="http://smkn8semarang.sch.id/ver7/"><i class="fa fa-globe fa-5x"></i></a></center>
					</div>
					</div> <!--/row -->
					<hr>
				</div>
			</div>	
				<div class="container">		
					<div class="row centered" style="margin-top: 5px;">
						<div class="col-lg-4">
							<p><center><img src="<?php echo base_url("assets/images/smk8.png"); ?>"></center></p>
						</div>
						<div class="col-lg-4">
							<address>
							  <strong>SMKN 8 Semarang</strong><br>
							  Jl. Pandanaran II/12<br>
							  Semarang<br>
							  Phone : (024) 831-2190 / Fax : (024) 844-0321 <br>
							  Email : smkn_8semarang@yahoo.co.id <br>
							  Web : http://smkn8semarang.sch.id <br> 
							</address>
						</div>
						<div class="col-lg-4">
							<div class="contactus">
								<form action="#" method="post">
								<h4> Contact Us </h4>
								<div class="form-group">
									<label for="nama" style=" color: #f39c12;">Nama</label>
									<input type="text" class="form-control" id="inputnama" placeholder="Masukkan Nama">
								</div>
								<div class="form-group">
									<label for="Email" style=" color: #f39c12;">Email</label>
									<input type="email" class="form-control" id="inputemail" placeholder="Masukkan Email">
								</div>
								<div class="form-group">
									<label for="pesan" style=" color: #f39c12;">Pesan</label>
									<textarea class="form-control" rows="3"></textarea>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-warning" value="Kirim">
								</div>
								</form>
							</div>
						</div>

					</div>
						<div class="row centered">
							<div class="col-lg-12">
							<center>&copy; E-Raport SMKN 8 Semarang. Developed by : <a href="#">Rieqy Muwachid Erysya</a>.</center>
							</div>
				</div>
			</div>
	</div><!--/footerwrap -->

	
	<div class="modal fade" tabindex="-1" role="dialog" id="modalDetail">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="detailJudul"><i class="fa fa-fw fa-user"></i> Profil Siswa</h4>
      </div>
      <div class="modal-body">
        <p>
		 <table class="table table-striped table-hover">
	<?php if($hak_akses=="siswa"){ ?>
 <tr><td>NIS</td><td>:</td><td id="dataNis">rieqyns13</td></tr>
 <tr><td>NISN</td><td>:</td><td id="dataNisn">rieqyns13</td></tr>
 <tr><td>Nama</td><td>:</td><td id="dataNama">rieqyns13</td></tr>
 <tr><td>Jen. Kel</td><td>:</td><td id="dataJenkel">rieqyns13</td></tr>
 <tr><td>No. Telp</td><td>:</td><td id="dataNoTelp">rieqyns13</td></tr>
 <tr><td>Jurusan</td><td>:</td><td id="dataJurusan">rieqyns13</td></tr>
 <tr><td>Kelas</td><td>:</td><td id="dataKelas">rieqyns13</td></tr>
 <tr><td>Tempat/Tgl Lahir</td><td>:</td><td id="dataTmptTglLahir">rieqyns13</td></tr>
 <tr><td>Agama</td><td>:</td><td id="dataAgama">rieqyns13</td></tr>
 <tr><td>Alamat</td><td>:</td><td id="dataAlamat">rieqyns13</td></tr>
 <tr><td>Nama Ayah</td><td>:</td><td id="dataAyah">rieqyns13</td></tr>
 <tr><td>Nama Ibu</td><td>:</td><td id="dataIbu">rieqyns13</td></tr>
 <tr><td>Pekerjaan Ayah</td><td>:</td><td id="dataPekerjaaAyah">rieqyns13</td></tr>
 <tr><td>Pekerjaan Ibu</td><td>:</td><td id="dataPekerjaaIbu">rieqyns13</td></tr>
 <tr><td>Alamat Orang Tua</td><td>:</td><td id="dataAlamatOrtu">rieqyns13</td></tr>
 <tr><td>Photo</td><td>:</td><td><img class="img-thumbnail" width="200px" height="200px" id="dataPhoto" src=""></td></tr>
	<?php }else if($hak_akses=="guru"){ ?>
 <tr><td>Kode Guru</td><td>:</td><td id="dataKodeGuru">rieqyns13</td></tr>
 <tr><td>NIP</td><td>:</td><td id="dataNip">rieqyns13</td></tr>
 <tr><td>Nama</td><td>:</td><td id="dataNama">rieqyns13</td></tr>
 <?php if($walikelas!=null)echo '<tr><td>Wali Kelas</td><td>:</td><td id="dataWalikelas">'.$walikelas.'</td></tr>'; ?>
 <tr><td>Telepon</td><td>:</td><td id="dataNoTelp">rieqyns13</td></tr>
 <tr><td>Tempat/Tgl Lahir</td><td>:</td><td id="dataTmptTglLahir">rieqyns13</td></tr>
 <tr><td>Alamat</td><td>:</td><td id="dataAlamat">rieqyns13</td></tr>
 <tr><td>Photo</td><td>:</td><td><img class="img-thumbnail" width="200px" height="200px" id="dataPhoto" src=""></td></tr>
	<?php } ?>
	</table>
</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	
	
	<div class="modal fade" tabindex="-1" role="dialog" id="modalEditAkun">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-fw fa-user"></i> Edit Akun</h4>
      </div>
      <div class="modal-body">
        <p>
		<h3>Identitas</h3>
	<form id="frmEditAkun" method="post" action="<?php echo site_url("home/editAkun"); ?>">
  <div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" placeholder="Username" name="username" disabled="disabled">
  </div>
  <div class="form-group">
    <label>Nama</label>
    <input type="text" class="form-control" placeholder="Nama" name="nama">
  </div>
  <div class="form-group">
    <label>Email</label>
    <input type="email" class="form-control" placeholder="Email" name="email">
  </div>
  <div class="form-group">
    <label>No. Telp</label>
    <input type="text" class="form-control" placeholder="Nomer Telepon" name="no_telp">
  </div>
    <button type="submit" class="btn btn-primary">Ganti</button>
  </form>
  <hr>
  <h3>Password</h3>
  <form id="frmEditAkun2" method="post" action="<?php echo site_url("home/editAkun"); ?>">
  <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" placeholder="Password" name="password[]">
  </div>
  <div class="form-group">
    <label>Ulangi Password</label>
    <input type="password" class="form-control" placeholder="Password" name="password[]">
  </div>
    <button type="submit" class="btn btn-primary">Ganti</button>
  </form>
</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal untuk Log -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalLog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="logJudul">Judul</h4>
      </div>
	  <div class="modal-body" id="logBody">
	  ...
	  </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</html>
