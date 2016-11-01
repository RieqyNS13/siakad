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

	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style type="text/css">
	.dropdown-menu.menu{
		width:300px !important;
	}
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
	</style>
	<script src="<?php echo base_url()."assets/jquery-1.11.2.min.js"; ?>"></script>
		 <script src="<?php echo base_url()."assets/bootstrap/js/bootstrap.min.js"; ?>"></script>

		 <script src="<?php echo base_url()."assets/datepicker/js/bootstrap-datepicker.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url()."assets/datepicker/locales/bootstrap-datepicker.id.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url()."assets/jquery.form.min.js"; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url()."assets/jquery.bootpag.min.js"; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url()."assets/bootstrap-select/dist/js/bootstrap-select.min.js"; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url()."assets/chartjs/Chart.min.js"; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url()."assets/highcharts/js/highcharts.js"; ?>"></script>
	<script type="text/javascript">
	function readURL(input, selector) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                selector.attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
	$(function(){
		$("body").data("isRefresh",false);
		$("#modalLog2").on("hidden.bs.modal",function(e){
			if($("body").data("isRefresh")==true)window.location.reload();
		});
		$("#frmEditProfil, #frmEditAkun").ajaxForm({
			beforeSend:function(){
				$("button,input").prop("disabled",true);
			},
			dataType:'json',
			success:function(data){
				$("button,input").prop("disabled",false);
				if(data.sukses){
					$("#logBody2").html(data.sukses);
					$("#logJudul2").html("Sukses");
					$("body").data("isRefresh",true);
				}else if(data.error){
					$("#logBody2").html(data.error);
					$("#logJudul2").html("Error");
				}
				$("#modalLog2").modal("show");
				$("button,input").prop("disabled",false);
			},
			error:function(xhr,error,er){
				$("button,input").prop("disabled",false);
				alert(error);
			
			}
		});
		$("#profile").click(function(e){
			e.preventDefault();
			$.ajax({
				url:'<?php echo site_url('admin/home/getProfile'); ?>',
				type:'get',
				dataType:'json',
			}).done(function(data){
				$("#modalEditProfil [name='nama']").val(data.nama);
				$("#modalEditProfil [name='email']").val(data.email);
				$("#modalEditProfil [name='no_telp']").val(data.no_telp);
				$("#modalEditProfil").modal('show');
			}).fail(function(xhr){
				alert(xhr.responseText);
			});
		});
		$("#akun").click(function(e){
			e.preventDefault();
			$.ajax({
				url:'<?php echo site_url('admin/home/getProfile'); ?>',
				type:'get',
				dataType:'json',
			}).done(function(data){
				$("#modalEditAkun [name='username']").val(data.username);
				$("#modalEditAkun").modal('show');
			}).fail(function(xhr){
				alert(xhr.responseText);
			});
		});
		/*$("#listdatamaster > li > a.url").click(function(e){
			e.preventDefault();
			var url=$(this).attr("href");
			var url2='<?php echo site_url()."/admin/"; ?>'+url;
			$.ajax({
				url:url2,
				type:'get',
				headers:{'isAjax':'1'},
				beforeSend:function(data){
					$("#kontenUtama").html(loading());
				}
			}).done(function(data){
				$("#kontenUtama").html(data);
			}).fail(function(xhr,er,err){
				console.log(xhr.responseText);
			});
			window.history.pushState({},"",url2);
		});*/
		/*$("#menuList > li").click(function(e){
			e.preventDefault();
			$(this).addClass("active");
			$("#menuList > li").removeClass("active");
		});*/
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
                <a class="navbar-brand" href="<?php echo site_url('admin'); ?>">Siakad SMK N 8 Semarang</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu menu alert-dropdown">
					<?php 
					for($i=0; $i<5; $i++){
						echo '<li><a href="#"><span class="label label-default"><i class="icon-info"></i></span> '.$notif_log[$i]->log.'</a></li>';
					}
					?>
                       <!-- <li>
                            <a href="#">Alert Name <span class="label label-default"><i class="icon-info"></i> Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>-->
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $nama_user; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" id="profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#" id="akun"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo site_url("admin/home/logout"); ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav" id="menuList">
                    <li class="active">
                        <a href="<?php echo site_url("admin/index"); ?>" ><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li id="datasiswa">
                        <a href="#" data-toggle="collapse" data-target="#listdatasiswa"><i class="fa fa-fw fa-bar-chart-o"></i> Siswa <b class="caret"></b></a>
						 <ul id="listdatasiswa" class="collapse">
                            <li>
                                <a class="url" href="<?php echo site_url()."/admin/siswa"; ?>">Data Siswa</a>
                            </li>
							  <li>
                                <a class="url" href="<?php echo site_url()."/admin/ortusiswa"; ?>">Data Ortu Siswa</a>
                            </li>
							</ul>
                    </li>
					<li id="dataguru">
                        <a href="#" data-toggle="collapse" data-target="#listdataguru"><i class="fa fa-fw fa-bar-chart-o"></i> Guru <b class="caret"></b></a>
						 <ul id="listdataguru" class="collapse">
                            <li>
                                <a class="url" href="<?php echo site_url()."/admin/guru/index"; ?>">Data Guru</a>
                            </li>
                           <li>
                                <a class="url" href="<?php echo site_url()."/admin/mapel_guru/index"; ?>">Mapel Guru</a>
                            </li>
                        </ul>
                    </li>
					<li id="datakurikulum">
                        <a href="#" data-toggle="collapse" data-target="#listkurikulum"><i class="fa fa-fw fa-bar-chart-o"></i> Kurikulum <b class="caret"></b></a>
						 <ul id="listkurikulum" class="collapse">
                           <li>
								<a href="<?php echo site_url()."/admin/kelas/index"; ?>">Kelas</a>
							</li>
							<li>
								<a href="<?php echo site_url()."/admin/mata_diklat/index"; ?>">Mata Diklat</a>
							</li>
							<li>
								<a href="<?php echo site_url()."/admin/jurusan/index"; ?>">Jurusan</a>
							</li>
						
							 <li>
								<a href="<?php echo site_url()."/admin/mapel/index"; ?>">Mapel</a>
							</li>
							<li>
								<a href="<?php echo site_url()."/admin/bagi_mapel/index"; ?>">Pembagian Mapel</a>
							</li>
							<li>
								<a href="<?php echo site_url()."/admin/walikelas/index"; ?>"> Wali Kelas</a>
							</li>
                        </ul>
                    </li>
					<li id="datanilai">
                        <a href="#" data-toggle="collapse" data-target="#listnilai"><i class="fa fa-fw fa-bar-chart-o"></i> Nilai Pengetahuan <b class="caret"></b></a>
						 <ul id="listnilai" class="collapse">
                           <li>
								<a href="<?php echo site_url()."/admin/nilai_tugas/index"; ?>">Nilai Tugas</a>
							</li>
							<li>
								<a href="<?php echo site_url()."/admin/nilai_uts/index"; ?>">Nilai UTS</a>
							</li>
							<li>
								<a href="<?php echo site_url()."/admin/nilai_uas/index"; ?>">Nilai UAS</a>
							</li>
                        </ul>
                    </li>
					<li id="datanilai2">
                        <a href="#" data-toggle="collapse" data-target="#listnilai2"><i class="fa fa-fw fa-bar-chart-o"></i> Nilai Keterampilan <b class="caret"></b></a>
						 <ul id="listnilai2" class="collapse">
                           <li>
								<a href="<?php echo site_url()."/admin/nilai_praktik/index"; ?>">Nilai Praktek</a>
							</li>
							<li>
								<a href="<?php echo site_url()."/admin/nilai_proyek/index"; ?>">Nilai Proyek</a>
							</li>
							<li>
								<a href="<?php echo site_url()."/admin/nilai_portofolio/index"; ?>">Nilai Portofolio</a>
							</li>
                        </ul>
                    </li>
					<li id="datanilai3">
                        <a href="<?php echo site_url()."/admin/nilai_sikap/"; ?>"><i class="fa fa-fw fa-bar-chart-o"></i> Nilai Sikap</a>
                    </li>
					
					<li id="raport">
						<a href="#" data-toggle="collapse" data-target="#listraport"><i class="fa fa-fw fa-bar-chart-o"></i> Raport <b class="caret"></b></a>
						<ul id="listraport" class="collapse">
                           <li>
								<a href="<?php echo site_url()."/admin/raport/index"; ?>">Raport</a>
							</li>
							<?php if(!empty($walikelas->kelas) || $this->session->hak_akses=="admin"){ ?>
							<li>
								<a href="<?php echo site_url()."/admin/submit_raport/index"; ?>">Submit Raport</a>
							</li>
							<?php } ?>
							
                        </ul>
                    </li>
					<?php 
					if((isset($hak_akses) && $hak_akses=="admin") || (isset($hakAkses) && $hakAkses=="admin")){ ?>
					<li id="user">
						<a href="#" data-toggle="collapse" data-target="#listuser"><i class="glyphicon glyphicon-user"></i> User <b class="caret"></b></a>
						<ul id="listuser" class="collapse">
						 <li>
								<a href="<?php echo site_url()."/admin/user/show/admin"; ?>">Admin</a>
							</li>
							 <li>
								<a href="<?php echo site_url()."/admin/user/show/tatausaha"; ?>">Tata Usaha</a>
							</li>
                           <li>
								<a href="<?php echo site_url()."/admin/user/show/kurikulum"; ?>">Kurikulum</a>
							</li>
							<li>
								<a href="<?php echo site_url()."/admin/user/show/guru"; ?>">Guru</a>
							</li>
                        </ul>
                    </li>
					<?php 
					}
					if((isset($hak_akses) && $hak_akses=="admin") || (isset($hakAkses) && $hakAkses=="admin")){ ?>
					<li id="backup">
						<a href="<?php echo site_url()."/admin/backup"; ?>"><i class="fa fa-undo"></i></i> Backup DB </b></a>
                    </li>
					<?php } ?>
                   <!-- <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                        </ul>
                    </li>-->
                   
                    <!--<li>
                        <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
				 <div id="kontenUtama">
                <!-- Page Heading -->
               <?php echo $kontenUtama; ?>
                <!-- /.row -->
				</div><!--end kontenUtama-->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->

    <!-- Bootstrap Core JavaScript -->

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url()."assets/sb-admin/js/plugins/morris/raphael.min.js"; ?>"></script>
    <script src="<?php echo base_url()."assets/sb-admin/js/plugins/morris/morris.min.js"; ?>"></script>
    <!--<script src="<?php echo base_url()."js/plugins/morris/morris-data.js"; ?>"></script>-->
	
	<div class="modal fade" tabindex="-1" role="dialog" id="modalEditProfil">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmEditProfil" method="post" action="<?php echo site_url("admin/editProfil"); ?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Profil</h4>
      </div>
      <div class="modal-body">
        <p>
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
    <input type="text" class="form-control" placeholder="No. Telp" name="no_telp">
  </div>
</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


	<div class="modal fade" tabindex="-1" role="dialog" id="modalEditAkun">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmEditAkun" method="post" action="<?php echo site_url("admin/editAkun"); ?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Akun</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" placeholder="Username" name="username">
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" placeholder="Password" name="password[]">
  </div>
  <div class="form-group">
    <label>Ulangi Password</label>
    <input type="password" class="form-control" placeholder="Password" name="password[]">
  </div>
</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modalLog2">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="logJudul2">Judul</h4>
      </div>
	  <div class="modal-body" id="logBody2">
	  ...
	  </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
	
</body>

</html>
