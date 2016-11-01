<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");

function hapusOrtuSiswa(nis){
	$("body").data("nis_forHapus",nis);
	$("#modalHapusBody").html("Hapus data ortu di siswa dengan nis '"+nis+"'?");
	$("#modalHapusJudul").html("Konfirmasi Hapus");
	$("#modalHapus").modal('show');
	return false;
}
function lihatDetail(nis){
	$.ajax({
		url:'<?php echo site_url("admin/ortusiswa/detailOrtuSiswa/true"); ?>',
		type:'post',
		data:{nis:encodeURIComponent(nis)},
		dataType:'json'
	}).done(function(data){
		$("#dataNis").html(data.nis);
		$("#dataNamaAnak").html(data.nama);
		$("#dataAyah").html(data.nama_ayah);
		$("#dataIbu").html(data.nama_ibu);
		$("#dataPekerjaanAyah").html(data.pekerjaan_ayah);
		$("#dataPekerjaanIbu").html(data.pekerjaan_ibu);
		$("#dataAlamat").html(data.alamat_ortu);
		$("#detailJudul").html("Detail Orang Tua Siswa NIS '"+nis+"'");
		$("#modalDetail").modal('show');
	});
	return false;
}
function editOrtuSiswa(nis){
	$("[name='nis_forEdit']").val(nis);
	$.ajax({
		url:'<?php echo site_url("admin/ortusiswa/detailOrtuSiswa/"); ?>',
		type:'post',
		data:{nis:nis},
		dataType:'json'
	}).done(function(data){
		$("[name='nis']:eq(1)").val(data.nis);
		$("[name='nama_ayah']:eq(1)").val(data.nama_ayah);
		$("[name='nama_ibu']:eq(1)").val(data.nama_ibu);
		$("[name='pekerjaan_ayah']:eq(1)").val(data.pekerjaan_ayah);
		$("[name='pekerjaan_ibu']:eq(1)").val(data.pekerjaan_ibu);
		$("[name='alamat_ortu']:eq(1)").val(data.alamat_ortu);
		$("#modalEditOrtuSiswa select").selectpicker('refresh');
		$("#modalEditOrtuSiswa").modal("show");
		
	});
	return false;
}
$(function(){
	$("body").data("nipEdit",'');
	$("body").data("isRefresh",false);
	$("#konfirmHapus").click(function(){
		$.ajax({
			url:'<?php echo site_url("admin/ortusiswa/hapusOrtuSiswa"); ?>',
			type:'post',
			data:{nis_forHapus:$("body").data("nis_forHapus")},
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
	$("#frmEditOrtu").ajaxForm({
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
	$("#frmTambahOrtu").ajaxForm({
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
			
		}	});

	$("#modalLog").on("hidden.bs.modal",function(e){
		if($("body").data("isRefresh")==true)window.location.reload();
	});
	
});
</script>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Data <small>Orang Tua Siswa</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Siswa</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Data Ortu Siswa
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php
				if($hak_akses==="admin" || $hak_akses==="tatausaha"){
					?>
                <div class="row">
				<div class="col-lg-12">
						<button class="btn btn-primary" id="btnTambahMrkt" data-toggle="modal" data-target="#modalTambahOrtuSiswa"><i class="fa fa-plus"></i> Tambah Ortu Siswa</button>
                    </div>
				</div>
				<hr>
				<?php } ?>
				<div class="row">
				<div class="col-lg-8">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/ortusiswa/gantiPaging"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/ortusiswa/index"); ?>">
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
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Nama Ayah</th>
                                   		<th>Nama Ibu</th>
                                   		<th>Pekerjaan Ayah</th>
                                   		<th>Pekerjaan Ibu</th>
                                   		<th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									$a=($startPage)+1;
								   foreach($dataOrtu as $data){
			
									   echo "<tr><td>$a</td><td>".$data->nis."</td><td>".htmlentities($data->nama)."</td><td>".htmlentities($data->nama_ayah)."</td><td>".htmlentities($data->nama_ibu)."</td><td>".htmlentities($data->pekerjaan_ayah)."</td><td>".htmlentities($data->pekerjaan_ibu)."</td><td>";
									   if($hak_akses==="admin" || $hak_akses==="tatausaha")echo "<a href=\"#\" onclick=\"return editOrtuSiswa('".addslashes($data->nis)."')\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit</a> | <a href=\"#\" onclick=\"return hapusOrtuSiswa('".addslashes($data->nis)."')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</a> | ";
									   echo "<a href=\"#\" onclick=\"return lihatDetail('".addslashes($data->nis)."')\"><span class=\"glyphicon glyphicon-eye-open\"></span> Detail</a></td></tr>";
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
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambahOrtuSiswa">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmTambahOrtu" method="post" action="<?php echo site_url("admin/ortusiswa/tambahOrtuSiswa"); ?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Ortu Siswa</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label>NIS</label>
     <select name="nis" class="form-control selectpicker" data-live-search="true">
	 <?php echo $siswaData; ?>
	 </select>
  </div>
  <div class="form-group">
    <label>Nama Ayah</label>
    <input type="text" class="form-control" placeholder="Nama Ayah" name="nama_ayah">
  </div>
  <div class="form-group">
    <label>Nama Ibu</label>
    <input type="text" class="form-control" placeholder="Nama Ibu" name="nama_ibu">
  </div>
   <div class="form-group">
    <label>Pekerjaan Ayah</label>
    <input type="text" class="form-control" placeholder="Pekerjaan Ayah" name="pekerjaan_ayah">
  </div>
   <div class="form-group">
    <label>Nama Ibu</label>
    <input type="text" class="form-control" placeholder="Pekerjaan Ibu" name="pekerjaan_ibu">
  </div>
  <div class="form-group">
    <label>Alamat</label>
    <textarea class="form-control" placeholder="Alamat" name="alamat_ortu"></textarea>
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



<div class="modal fade" tabindex="-1" role="dialog" id="modalEditOrtuSiswa">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmEditOrtu" method="post" action="<?php echo site_url("admin/ortusiswa/editOrtuSiswa"); ?>">
		<input type="hidden" name="nis_forEdit" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Ortu Siswa</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label>NIS</label>
     <select name="nis" class="form-control selectpicker" data-live-search="true">
	 <?php echo $siswaData; ?>
	 </select>
  </div>
  <div class="form-group">
    <label>Nama Ayah</label>
    <input type="text" class="form-control" placeholder="Nama Ayah" name="nama_ayah">
  </div>
  <div class="form-group">
    <label>Nama Ibu</label>
    <input type="text" class="form-control" placeholder="Nama Ibu" name="nama_ibu">
  </div>
   <div class="form-group">
    <label>Pekerjaan Ayah</label>
    <input type="text" class="form-control" placeholder="Pekerjaan Ayah" name="pekerjaan_ayah">
  </div>
   <div class="form-group">
    <label>Nama Ibu</label>
    <input type="text" class="form-control" placeholder="Pekerjaan Ibu" name="pekerjaan_ibu">
  </div>
  <div class="form-group">
    <label>Alamat</label>
    <textarea class="form-control" placeholder="Alamat" name="alamat_ortu"></textarea>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modalDetail">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="detailJudul">...</h4>
      </div>
      <div class="modal-body">
        <p>
 <table class="table table-striped table-hover">
 <tr><td>NIS Anak</td><td>:</td><td id="dataNis">fff</td></tr>
 <tr><td>Nama Anak</td><td>:</td><td id="dataNamaAnak">fff</td></tr>
 <tr><td>Nama Ayah</td><td>:</td><td id="dataAyah">fff</td></tr>
 <tr><td>Nama Ibu</td><td>:</td><td id="dataIbu">fff</td></tr>
 <tr><td>Pekerjaan Ayah</td><td>:</td><td id="dataPekerjaanAyah">fff</td></tr>
 <tr><td>Pekerjaan Ibu</td><td>:</td><td id="dataPekerjaanIbu">fff</td></tr>
 <tr><td>Alamat Orang Tua</td><td>:</td><td id="dataAlamat">fff</td></tr>
</table>
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