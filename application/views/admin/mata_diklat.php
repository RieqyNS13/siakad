<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");

function hapusMataDiklat(kode,obj){
	var x=($('#'+obj).html());
	$("body").data("kode_forHapus",kode);
	$("#modalHapusBody").html("Hapus mata diklat '"+x+"'?");
	$("#modalHapusJudul").html("Konfirmasi Hapus");
	$("#modalHapus").modal('show');
	return false;
}
function editMataDiklat(kode){
	$("[name='kode_forEdit']").val(kode);
	$.ajax({
		url:'<?php echo site_url("admin/mata_diklat/detailMataDiklat"); ?>',
		type:'post',
		data:{kode_mata_diklat:kode},
		dataType:'json'
	}).done(function(data){
		$("[name='kode_mata_diklat']:eq(1)").val(data.kode_mata_diklat);
		$("[name='nama_mata_diklat']:eq(1)").val(data.nama_mata_diklat);
		$("#modalEditDiklat select").selectpicker('refresh');
		$("#modalEditDiklat").modal("show");
	});
	return false;
}
$(function(){
	$("body").data("nipEdit",'');
	$("body").data("isRefresh",false);
	$("#konfirmHapus").click(function(){
		$.ajax({
			url:'<?php echo site_url("admin/mata_diklat/hapusMataDiklat"); ?>',
			type:'post',
			data:{kode_forHapus:$("body").data("kode_forHapus")},
			dataType:'json'
		}).done(function(data){
			$("#modalHapus").modal("hide");
			if(data.sukses){
				window.location.reload();
			}else{
				$("body").data("isRefresh",false);
				$("#logJudul").html("Error");
				$("#logBody").html(data.error);
				$("#modalLog").modal('show');
			}
		});
	});
	$("#frmEditJurusan").ajaxForm({
		beforeSend:function(){
			$("button,input").prop("disabled",true);
		},
		//data:{kode_guruEdit: $("body").data("kode_guruforEdit")},
		dataType:'json',
		success:function(data){
			$("button,input").prop("disabled",false);
			if(data.sukses){
				$("#logBody").html(data.sukses);
				$("#logJudul").html("Sukses");
				$("body").data("isRefresh",true);
			}else if(data.error){
				$("#logBody").html(data.error);
				$("#logJudul").html("Error");
			}
			$("#modalLog").modal("show");
			$("button,input").prop("disabled",false);
		},
		error:function(xhr,error,er){
			$("button,input").prop("disabled",false);
			alert(error);
			
		}
	});
	$("#frmTambahDiklat").ajaxForm({
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
				$("#logJudul").html("Error");
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
                            Data <small>Mata Diklat</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Kurikulum</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Data Mata Diklat
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php 
				if($hak_akses=="admin" || $hak_akses=="kurikulum"){ ?>
                <div class="row">
				<div class="col-lg-12">
						<button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahDiklat"><i class="fa fa-plus"></i> Tambah Mata Diklat</button>
                    </div>
				</div>
				<hr>
				<?php } ?>
				<div class="row">
				<div class="col-lg-8">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/mata_diklat/gantiPaging"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/mata_diklat/index"); ?>">
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
                                       <th>Kode Mata Diklat</th>
                                   		<th>Nama Mata Diklat</th>
                                    	<?php if($hak_akses=="admin" || $hak_akses=="kurikulum")echo "<th>Aksi</th>"; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									$a=($startPage)+1;
								   foreach($dataMataDiklat as $data){
									  
									   echo "<tr><td>$a</td><td id=\"data".$a."\">".$data->kode_mata_diklat."</td><td>".$data->nama_mata_diklat."</td>";
									   if($hak_akses=="admin" || $hak_akses=="kurikulum")echo "<td><a href=\"#\" onclick=\"return editMataDiklat('".addslashes($data->kode_mata_diklat)."')\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit</a> | <a href=\"#\" onclick=\"return hapusMataDiklat('".addslashes($data->kode_mata_diklat)."','data".$a."')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</a></td>";
									   echo "</tr>";
									   $a++;
								   }
								   ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
					</div>
				<div class="row">
					<div class="col-lg-12">
					
					<?php echo $pagination; ?>
					</div>
				</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambahDiklat">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmTambahDiklat" method="post" action="<?php echo site_url("admin/mata_diklat/tambahMataDiklat"); ?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Mata Diklat</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label>Kode Diklat</label>
	<input type="text" class="form-control" name="kode_mata_diklat" placeholder="Kode Mata Diklat">
  </div>
  <div class="form-group">
    <label>Nama Diklat</label>
	<input type="text" class="form-control" name="nama_mata_diklat" placeholder="Nama Mata Diklat">
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



<div class="modal fade" tabindex="-1" role="dialog" id="modalEditDiklat">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmEditJurusan" method="post" action="<?php echo site_url("admin/mata_diklat/editMataDiklat"); ?>">
		<input type="hidden" name="kode_forEdit" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Jurusan</h4>
      </div>
      <div class="modal-body">
        <p>
 <div class="form-group">
    <label>Kode Diklat</label>
	<input type="text" class="form-control" name="kode_mata_diklat" placeholder="Kode Mata Diklat">
  </div>
  <div class="form-group">
    <label>Nama Diklat</label>
	<input type="text" class="form-control" name="nama_mata_diklat" placeholder="Nama Mata Diklat">
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