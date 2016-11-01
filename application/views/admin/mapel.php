<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");

function hapusMapel(kode_mapel){
	$("body").data("kode_mapel_forHapus",kode_mapel);
	$("#modalHapusBody").html("Hapus mapel dengan kode mapel '"+kode_mapel+"'?");
	$("#modalHapusJudul").html("Konfirmasi Hapus");
	$("#modalHapus").modal('show');
	return false;
}
function editMapel(kode_mapel){
	$("[name='kode_mapel_forEdit']").val(kode_mapel);
	$.ajax({
		url:'<?php echo site_url("admin/mapel/detailMapel"); ?>',
		type:'post',
		data:{kode_mapel:kode_mapel},
		dataType:'json'
	}).done(function(data){
		$("[name='kode_mapel']:eq(1)").val(data.kode_mapel);
		$("[name='nama_mapel']:eq(1)").val(data.nama_mapel);
		$("#modalEditMapel").modal("show");
	});
	return false;
}
$(function(){
	$("body").data("nipEdit",'');
	$("body").data("isRefresh",false);
	$("#konfirmHapus").click(function(){
		$.ajax({
			url:'<?php echo site_url("admin/mapel/hapusMapel"); ?>',
			type:'post',
			data:{kode_mapel_forHapus:$("body").data("kode_mapel_forHapus")},
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
	$("#frmEditMapel").ajaxForm({
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
	$("#frmTambahMapel").ajaxForm({
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
                            Data <small>Mapel</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Data Master</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Data Mapel
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php 
				if($hak_akses=="admin" || $hak_akses=="kurikulum"){ ?>
                <div class="row">
				<div class="col-lg-12">
						<button class="btn btn-primary" id="btnTambahMrkt" data-toggle="modal" data-target="#modalTambahMapel"><i class="fa fa-plus"></i> Tambah Mapel</button>
                    </div>
				</div>
				<hr>
				<?php } ?>
				<div class="row">
				<div class="col-lg-8">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/mapel/gantiPaging"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/mapel/index"); ?>">
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
                                        <th>Kode Mapel</th>
                                        <th>Nama Mapel</th>
                                   		<?php if($hak_akses=="admin" || $hak_akses=="kurikulum")echo "<th>Aksi</th>"; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									$a=($startPage)+1;
								   foreach($dataMapel as $data){
									  
									   echo "<tr><td>$a</td><td>".$data->kode_mapel."</td><td>".$data->nama_mapel."</td>";
									   	if($hak_akses=="admin" || $hak_akses=="kurikulum")echo "<td><a href=\"#\" onclick=\"return editMapel('".addslashes($data->kode_mapel)."')\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit</a> | <a href=\"#\" onclick=\"return hapusMapel('".addslashes($data->kode_mapel)."')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</a></td>";
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
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambahMapel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmTambahMapel" method="post" action="<?php echo site_url("admin/mapel/tambahMapel"); ?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Mapel</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label for="kodeguru">Kode Mapel</label>
    <input type="text" class="form-control" placeholder="Kode Mapel" name="kode_mapel">
  </div>
  <div class="form-group">
    <label for="kodeguru">Nama Mapel</label>
    <input type="text" class="form-control" placeholder="Nama Mapel" name="nama_mapel">
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



<div class="modal fade" tabindex="-1" role="dialog" id="modalEditMapel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmEditMapel" method="post" action="<?php echo site_url("admin/mapel/editMapel"); ?>">
		<input type="hidden" name="kode_mapel_forEdit" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Mapel</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label for="kodeguru">Kode Mapel</label>
    <input type="text" class="form-control" placeholder="Kode Mapel" name="kode_mapel">
  </div>
  <div class="form-group">
    <label for="kodeguru">Nama Mapel</label>
    <input type="text" class="form-control" placeholder="Nama Mapel" name="nama_mapel">
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