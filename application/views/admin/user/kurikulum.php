<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");

function hapusMapel(id_user,username){
	$("body").data("id_user_forHapus",id_user);
	$("#modalHapusBody").html("Hapus akun kurikulum dengan username '"+username+"'?");
	$("#modalHapusJudul").html("Konfirmasi Hapus");
	$("#modalHapus").modal('show');
	return false;
}
function editUser(id_user){
	$("[name='id_user_forEdit']").val(id_user);
	//$("body").data("id_user_forEdit",id_user);
	$.ajax({
		url:'<?php echo site_url("admin/user/getUser/kurikulum"); ?>',
		type:'post',
		data:{id_user:id_user},
		dataType:'json'
	}).done(function(data){
		//alert(data);
		$("[name='username']:eq(1)").val(data.username);
		$("[name='nama']:eq(1)").val(data.nama);
		$("[name='email']:eq(1)").val(data.email);
		$("[name='no_telp']:eq(1)").val(data.no_telp);
		$("#modaleditUser").modal("show");
	});
	return false;
}
$(function(){
	$("body").data("nipEdit",'');
	$("body").data("isRefresh",false);
	
	$("#konfirmHapus").click(function(){
		$.ajax({
			url:'<?php echo site_url("admin/user/hapusAkun/kurikulum"); ?>',
			type:'post',
			data:{id_user:$("body").data("id_user_forHapus")},
			dataType:'json'
		}).done(function(data){
			$("#modalHapus").modal("hide");
			if(data.sukses){
				window.location.reload();
			}else{
				$("body").data("isRefresh",false);
				$("#logJudul").html("Warning");
				$("#logBody").html(data.error);
				$("#modalLog").modal('show');
			}
		});
	});
	$("#frmEdit,#frmEdit2,#frmEdit3").ajaxForm({
		beforeSend:function(){
			$("button,input").prop("disabled",true);
		},
		//data:{kode_guruEdit: $("body").data("kode_guruforEdit")},
		dataType:'json',
		data:{id_user_forEdit:($("body").data("id_user_forEdit"))},
		success:function(data){
			$("button,input").prop("disabled",false);
			if(data.sukses){
				$("#logBody").html(data.sukses);
				$("#logJudul").html("Sukses");
				$("body").data("isRefresh",true);
			}else if(data.error){
				$("#logBody").html(data.error);
				$("#logJudul").html("Warning");
			}
			$("#modalLog").modal("show");
			$("button,input").prop("disabled",false);
		},
		error:function(xhr,error,er){
			$("button,input").prop("disabled",false);
			alert(error);
			
		}
	});
	$("#frmTambah [name='password2']").focusout(function(){
		var p1=$("#frmTambah [name='password']").val().trim();
		var p2=$("#frmTambah [name='password2']").val().trim();
		if(p1===p2){
			$("#pwd2").removeClass("has-error");
			$("#pwd2").addClass("has-success");
		}
		else{
			$("#pwd2").addClass("has-success");
			$("#pwd2").addClass("has-error");
		}
	});
	$("#frmEdit3 [name='password2']").focusout(function(){
		var p1=$("#frmEdit3 [name='password']").val().trim();
		var p2=$("#frmEdit3 [name='password2']").val().trim();
		if(p1===p2){
			$("#pwd3").removeClass("has-error");
			$("#pwd3").addClass("has-success");
		}
		else{
			$("#pwd3").addClass("has-success");
			$("#pwd3").addClass("has-error");
		}
	});
	$("#frmTambah").ajaxForm({
		beforeSend:function(){
			$("button,input").prop("disabled",true);
		},
		dataType:'json',
		success:function(data){
			$("button,input").prop("disabled",false);
			if(data.sukses){
				$("#logBody").html(data.sukses);
				$("#logJudul").html("Sukses");
				$("body").data("isRefresh",true);
			}else if(data.error){
				$("#logBody").html(data.error);
				$("#logJudul").html("Warning");
			}
			$("#modalLog").modal("show");
			$("button,input").prop("disabled",false);
		},
		error:function(xhr,error,er){
			$("button,input").prop("disabled",false);
			alert(error);
			
		}
	});
	$("#modalLog").on("hidden.bs.modal",function(e){
		if($("body").data("isRefresh")==true)window.location.reload();
	});
	
});
</script>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            User <small>Kurikulum</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">User</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Kurikulum
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php 
				if($hak_akses=="admin"){ ?>
                <div class="row">
				<div class="col-lg-12">
						<button class="btn btn-primary" id="btnTambah" data-toggle="modal" data-target="#modalTambah"><i class="fa fa-plus"></i> Tambah User</button>
                    </div>
				</div>
				<hr>
				<?php } ?>
				<div class="row">
				<div class="col-lg-8">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/user/gantiPaging/kurikulum"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/user/show/kurikulum"); ?>">
			 <div class="col-lg-4">
    <div class="input-group">
      <input type="text" id="txtCari" class="form-control" placeholder="Search for..." name="q">
      <span class="input-group-btn">
        <button id="btnCari" class="btn btn-default" type="submit">Cari!</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  </form>
				</div>
				<div class="row">
				<?php echo $caristatus; ?>
				</div>
				<div class="row">
                    <div class="col-lg-12 spasiAtas">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No. Telp</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									$a=($startPage)+1;
								   foreach($dataUser as $data){
									  
									    echo "<tr><td>$a</td><td>".htmlentities($data->username)."</td><td>".htmlentities($data->nama)."</td><td>".htmlentities($data->email)."</td><td>".htmlentities($data->no_telp)."</td>";
									   	echo "<td><a href=\"#\" onclick=\"return editUser('".addslashes($data->id_user)."')\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit</a> | <a href=\"#\" onclick=\"return hapusMapel('".addslashes($data->id_user)."','".addslashes(htmlentities(htmlentities($data->username)))."')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</a></td>";
										echo "</tr>";
									   $a++;
								   }
								   //print_r($dataUser);
								   ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
					</div>
				<div class="row">
					<div class="col-lg-12">
					<?php 
					echo $pagination; 
					?>
					</div>
				</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmTambah" method="post" action="<?php echo site_url("admin/user/tambahUser/kurikulum"); ?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah User</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" placeholder="Username" name="username">
  </div>
  <div class="form-group">
    <label >Password</label>
    <input type="password" class="form-control" placeholder="Password" name="password">
  </div>
    <div class="form-group" id="pwd2">
    <label >Ulangi Password	</label>
    <input type="password" class="form-control" placeholder="Ulangi Password" name="password2">
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
    <input type="text" class="form-control" placeholder="No. Telp" name="no_telp">
  </div>
</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" tabindex="-1" role="dialog" id="modaleditUser">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit User</h4>
      </div>
      <div class="modal-body">
        <p>
  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist" id="tabEdit">
    <li role="presentation" class="active"><a href="#profile2" aria-controls="profile2" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
    <li role="presentation"><a href="#akun2" aria-controls="akun2" role="tab" data-toggle="tab"><span class="icon-cog"></span> Akun</a></li>
  </ul>
   <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="profile2">
	<form id="frmEdit" method="post" action="<?php echo site_url("admin/user/editProfil/kurikulum"); ?>">
  <input type="hidden" name="id_user_forEdit">
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
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
	</div>
    <div role="tabpanel" class="tab-pane" id="akun2">
	<form id="frmEdit2" method="post" action="<?php echo site_url("admin/user/editAkun/kurikulum_1"); ?>">
	  <input type="hidden" name="id_user_forEdit">

	<div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" placeholder="Username" name="username">
  </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
  <hr>
  <form id="frmEdit3" method="post" action="<?php echo site_url("admin/user/editAkun/kurikulum_2"); ?>">
	  <input type="hidden" name="id_user_forEdit">
   <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" placeholder="Password" name="password">
  </div>
    <div class="form-group" id="pwd3">
    <label >Ulangi Password	</label>
    <input type="password" class="form-control" placeholder="Ulangi Password" name="password2">
  </div>
      <button type="submit" class="btn btn-primary">Simpan</button>

  </form>
	</div><!--end tab-akun-->
  </div>
</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal untuk hapus -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalHapus">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalHapusJudul">Judul</h4>
      </div>
	  <div class="modal-body" id="modalHapusBody">
	  ...
	  </div>
	  <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" id="konfirmHapus">Hapus</button>
      </div>
      </div>
    </div>
  </div>
</div>

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