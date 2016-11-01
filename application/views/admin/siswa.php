<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
.col-sm-2#tambahSiswa {
	width: 13.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");

function hapusSiswa(nis){
	$("body").data("nis_forEdit",nis);
	$("#modalHapusBody").html("Hapus siswa dengan nis '"+nis+"'?");
	$("#modalHapusJudul").html("Konfirmasi Hapus");
	$("#modalHapus").modal('show');
	return false;
}
function lihatDetail(nis){
	$.ajax({
		url:'<?php echo site_url("admin/siswa/detailSiswa/true"); ?>',
		type:'post',
		data:{nis:encodeURIComponent(nis)},
		dataType:'json'
	}).done(function(data){
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
		if(data.photo.length>0){
			$("#dataPhoto").attr("src",'<?php echo base_url(); ?>'+'/'+data.photo);
			 $("#dataPhoto").show();
		}else $("#dataPhoto").hide();
		$("#detailJudul").html("Detail Siswa NIS '"+nis+"'");
		$("#modalDetail").modal('show');
	});
	return false;
}
function editSiswa(nis){
	$("[name='nis_forEdit']").val(nis);
	$.ajax({
		url:'<?php echo site_url("admin/siswa/detailSiswa"); ?>',
		type:'post',
		data:{nis:nis},
		dataType:'json'
	}).done(function(data){
		$(".imgPreviewEdit").hide();
		$("[name='nis']").eq(1).val(data.nis);
		$("[name='nisn']").eq(1).val(data.nisn);
		$("[name='nama']").eq(1).val(data.nama);
		$("[name='jen_kel']").eq(1).val(data.jen_kel);
		$("[name='no_telp']").eq(1).val(data.no_telp);
		$("[name='kd_jurusan']").eq(1).val(data.kd_jurusan);
		$("[name='tgl_lahir']").eq(1).val(data.tgl_lahir);
		$("[name='tempat_lahir']").eq(1).val(data.tempat_lahir);
		$("[name='kd_agama']").eq(1).val(data.kd_agama);
		var kelas='';
		for(var i=0; i<data.pilih_kelas.length; i++)kelas+="<option value='"+data.pilih_kelas[i].id_kelas+"'>"+data.pilih_kelas[i].prefix_kelas+" "+data.pilih_kelas[i].nama_jurusan+" "+data.pilih_kelas[i].nomor_kelas+"</option>";
		$("select[name='kd_kelas']").eq(1).html(kelas);
		$("[name='kd_kelas']").eq(1).val(data.kd_kelas);
		if(data.photo){$(".imgPreviewEdit").attr("src",'<?php echo base_url()."/"; ?>'+data.photo);
		$(".imgPreviewEdit").show();}
		$("#modalEditSiswa").modal("show");
		$("#modalEditSiswa select").selectpicker('refresh');
	});
	return false;
}
$(function(){
	$("body").data("nipEdit",'');
	$("body").data("isRefresh",false);
	$("select[name='tampil']").change(function(){
		console.log('rieqyns13');
		$("form#gantiPaging").submit();
	});
	$("#konfirmHapus").click(function(){
		$.ajax({
			url:'<?php echo site_url("admin/siswa/hapusSiswa"); ?>',
			type:'post',
			data:{nis_forEdit:$("body").data("nis_forEdit")},
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
	$("#dp3,#dp2").datepicker({ 
		format: 'yyyy-mm-dd',
		autoclose:true,
		todayBtn:true,
	});
	$(".fotoSiswa:file").change(function(){
		var id=$(this).attr("id");
		var mbuh=$("[name='photo']").index(this);
		var x=this.files[0];
		var ext = this.value.match(/\.(.+)$/)[1];
		 ext=ext.toLowerCase();
		 var arr=["gif","png","jpg","jpeg","bmp"];
		 var index=$.inArray(ext, arr);
		var pilih;
		var imgpre;
		if(mbuh==0){
			imgpre=".imgPreview";
			pilih="#pilihfile";
		}else{
			imgpre=".imgPreviewEdit";
			pilih="#pilihfileEdit";
		}
		if(index==-1){
			 $(pilih).html("");
			 $(imgpre).hide();
			$("body").data("isRefresh",false);
			$("#logJudul").text("Error");
			$("#logBody").text("Format gambar salah :p");
			$("#modalLog").modal({backdrop: 'static', keyboard: false});
			return false;
		}
		$(pilih).html(x.name+" ("+Math.round(x.size/1027)+" KB)");
		$(imgpre).show();
		var select=$(imgpre);
		readURL(this, select);
	});
	$(".punyaNipBtn").click(function(){
		var x=$(this).find("input").val();
		if(x=='1')$("#inputNip").html("");
		else $("#inputNip").html('<input type="text" class="form-control" placeholder="Masukkan NIP" name="nip">');
	});
	$(".punyaNipBtn2").click(function(){
		var x=$(this).find("input").val();
		if(x=='1')$("#inputNip2").html("");
		else $("#inputNip2").html('<input type="text" class="form-control" value="'+$("body").data("nipEdit")+'" placeholder="Masukkan NIP" name="nip2">');
	});
	$("#frmEditSiswa").ajaxForm({
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
	$("#frmTambahSiswa").ajaxForm({
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
	//////
	$("select[name='kd_kelas']").eq(0).prop("disabled",true);
	$("select[name='kd_kelas']").eq(0).selectpicker('refresh');
	$("select[name='kd_jurusan']").change(function(){
		if($(this).val()=='0')return false;
		var mbuh=$("select[name='kd_jurusan']");
		var index=mbuh.index(this);
		$.ajax({
			url:'<?php echo site_url("admin/siswa/getKelas"); ?>',
			type:'get',
			data:{'id_jurusan':$(this).val()},
			beforeSend:function(){
				$("select[name='kd_kelas'], #modalTambahSiswa button[type='submit']").prop("disabled",true);
			}
		}).done(function(data){
			$("select[name='kd_kelas'], #modalTambahSiswa button[type='submit']").prop("disabled",false);
			$("select[name='kd_kelas']:eq("+index+")").html(data);
			$("select[name='kd_kelas']").selectpicker('refresh');
		}).fail(function(xhr){
			alert(xhr.responseText);
		});
	});
	$(".importFile").change(function(){
		var x=this.files[0];
		if(x!=null){
			$(".namefilecsv").val(x.name);
			$("#Importcsv").show();
		}else $("#Importcsv").hide();
	});
	$("#btnImport").click(function(){
		var file=document.getElementById("importFile");
		var data=file.files[0];
		//alert(data);
		var cok=new FormData();
		cok.append("filexls",data);
		$.ajax({
			url:'<?php echo site_url('admin/siswa/importFile'); ?>',
			type:'post',
			//contentType:'multipart/form-data',
			contentType:false,
			processData:false,
			cache:false,
			data:cok,
			dataType:'json',
			beforeSend:function(){
				$("#btnImport").prop("disabled",true);
				$("#importFile").prop("disabled",true);
			}
		}).done(function(data){
			if(data.error){
				$("#logBody").html(data.error);
				$("#logJudul").html("Error");
			}else if(data.sukses){
				$("#logBody").html(data.sukses);
				$("#logJudul").html("Sukses");
				$("body").data("isRefresh",true);
			}
			$("#modalLog").modal('show');
			$("#btnImport").prop("disabled",false);
			$("#importFile").prop("disabled",false);
		}).fail(function(x){
			alert(x.responseText);
			$("#btnImport").prop("disabled",false);
			$("#importFile").prop("disabled",false);
		});
	});
	
});
</script>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Data <small>Siswa</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Siswa</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Data Siswa
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

				<?php 
				if($hak_akses==="admin" || $hak_akses==="tatausaha"){
					?>
                <div class="row">
				<div class="col-sm-2" id="tambahSiswa">
						<button class="btn btn-primary" id="btnTambahMrkt" data-toggle="modal" data-target="#modalTambahSiswa"><i class="fa fa-plus"></i> Tambah Siswa</button>
                    </div>
						<div class="col-sm-2">
    
	<span class="btn btn-primary btn-file">
   <i class="fa fa-upload" aria-hidden="true"></i> Import File XLS<input type="file" id="importFile" class="importFile" name="importFile">
</span>
	
				</div><!--end col-sm-2-->
				<div class="col-sm-3">
				 <div class="input-group" id="Importcsv" style="display:none">
      <input type="text" class="form-control namefilecsv" disabled style="background:white" >
      <span class="input-group-btn" id="btnImport">
        <button class="btn btn-default" type="button"><i class="fa fa-upload"></i> Upload</button>
      </span>
    </div><!-- /input-group -->
				</div>
				</div>
				<?php } ?>
				<hr>
				<div class="row">
				<div class="col-lg-8">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/siswa/gantiPaging"); ?>">
			<div class="form-group">
			 <div class="form-group">
			<label>Tampil berdasarkan</label>
			<select class="selectpicker" data-live-search="true" name="tampil">
			<option value="0">Semua kelas</option>
			<?php 
			//if($tampil==0)
			foreach($kelas as $key=>$mbuh){
				 echo "<optgroup label=\"".$key."\">";
				 foreach($mbuh as $key=>$mbuh2)echo "<option value=\"".$key."\"".($key==$tampil?"selected":null).">".$mbuh2."</option>";
				 echo "</optgroup>";
			}
			?>
			</select>
			<script type="text/javascript">
			$("[name='tampil']").selectpicker('refresh');
			</script>
			</div>
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/siswa/index"); ?>">
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
                                        <th>Nama</th>
                                        <th>Jen.Kel</th>
                                        <th>No.Telp</th>
										<th>Kelas</th>
										<th>Tempat Lahir</th>
										<th>Tgl Lahir</th>
										<th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									$a=($startPage)+1;
								   foreach($dataSiswa as $data){
									  
									   echo "<tr><td>$a</td><td>".$data->nis."</td><td>".htmlentities($data->nama)."</td><td>".$data->jen_kel."</td><td>".htmlentities($data->no_telp)."</td>";
									   echo "<td>".$data->prefix_kelas." ".$data->nama_jurusan." ".$data->nomor_kelas."</td><td>".htmlentities($data->tempat_lahir)."</td><td>".htmlentities($data->tgl_lahir)."</td><td>";
									   if($hak_akses==="admin" || $hak_akses==="tatausaha" )echo "<a href=\"#\" onclick=\"return editSiswa('".addslashes($data->nis)."')\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit</a> | <a href=\"#\" onclick=\"return hapusSiswa('".addslashes($data->nis)."')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</a> | ";
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
				
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambahSiswa">
  <div class="modal-dialog">
    <div class="modal-content">
	
	<form id="frmTambahSiswa" method="post" action="<?php echo site_url("admin/siswa/tambahSiswa"); ?>" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Siswa</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label for="kodeguru">NIS</label>
    <input type="text" class="form-control" placeholder="NIS" name="nis">
  </div>
  <div class="form-group">
    <label for="nip">NISN</label><br>
	<input type="text" class="form-control" placeholder="NISN" name="nisn">
  </div>
  <div class="form-group">
    <label for="nama">Nama</label>
    <input type="text" class="form-control" placeholder="Nama Siswa" name="nama">
  </div>
  <div class="form-group">
    <label for="nama">Jenis Kelamin</label>
    <select name="jen_kel" class="form-control selectpicker">
	<option value="L">Laki-Laki</option>
	<option value="P">Perempuan</option>
	</select>
  </div>
  <div class="form-group">
    <label for="nama">Telepon</label>
    <input type="text" class="form-control" placeholder="Telepon" name="no_telp">
  </div>
  <div class="form-group">
    <label>Jurusan</label>
	<select name="kd_jurusan" class="form-control selectpicker">
		<option value="0">Pilih jurusan</option>

	<?php echo $jurusan; ?>
	</select>
  </div>
  <div class="form-group">
    <label>Kelas</label>
	<select name="kd_kelas" class="form-control selectpicker">
	</select>
  </div>
  <div class="form-group">
    <label for="nama">Tanggal Lahir</label>
	<div class="input-group date" id="dp3">
    <input type="text" class="form-control" name="tgl_lahir" placeholder="Pilih Tanggal Lahir">
	  <span class="input-group-addon"><span  class="glyphicon glyphicon-calendar"></span></span>
	</div>
  </div>
  <div class="form-group">
    <label>Tempat Lahir</label>
    <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir">
  </div>
  <div class="form-group">
    <label>Alamat</label>
    <textarea class="form-control" name="alamat" placeholder="Alamat"></textarea>
  </div>
  <div class="form-group">
    <label>Agama</label>
    <select name="kd_agama" class="form-control selectpicker">
    <?php echo $agama; ?>
	</select>
  </div>
   <div class="form-group">
    <label for="nama">Photo</label>
    <div class="row">
    <div class="col-lg-2"><span class="btn btn-default btn-file">
    Browse.. <input type="file" class="fotoSiswa" name="photo">
</span></div>
<div class="col-lg-3"><img class="img-thumbnail imgPreview" src="" alt="your image" style="display: none;"></div>
<div class="col-lg-3"><label id="pilihfile"></label></div>
	
    </div>
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



<div class="modal fade" tabindex="-1" role="dialog" id="modalEditSiswa">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmEditSiswa" method="post" action="<?php echo site_url("admin/siswa/editSiswa"); ?>" enctype="multipart/form-data">
		<input type="hidden" name="nis_forEdit" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Siswa</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label for="kodeguru">NIS</label>
    <input type="text" class="form-control" placeholder="NIS" name="nis">
  </div>
  <div class="form-group">
    <label for="nip">NISN</label><br>
	<input type="text" class="form-control" placeholder="NISN" name="nisn">
  </div>
  <div class="form-group">
    <label for="nama">Nama</label>
    <input type="text" class="form-control" placeholder="Nama Siswa" name="nama">
  </div>
  <div class="form-group">
    <label for="nama">Jenis Kelamin</label>
    <select name="jen_kel" class="form-control selectpicker">
	<option value="L">Laki-Laki</option>
	<option value="P">Perempuan</option>
	</select>
  </div>
  <div class="form-group">
    <label for="nama">Telepon</label>
    <input type="text" class="form-control" placeholder="Telepon" name="no_telp">
  </div>
  <div class="form-group">
    <label>Jurusan</label>
	<select name="kd_jurusan" class="form-control selectpicker">
		<option value="0">Pilih jurusan</option>

	<?php echo $jurusan; ?>
	</select>
  </div>
  <div class="form-group">
    <label>Kelas</label>
	<select name="kd_kelas" class="form-control selectpicker">
	</select>
  </div>
  <div class="form-group">
    <label for="nama">Tanggal Lahir</label>
	<div class="input-group date" id="dp3">
    <input type="text" class="form-control" name="tgl_lahir" placeholder="Pilih Tanggal Lahir">
	  <span class="input-group-addon"><span  class="glyphicon glyphicon-calendar"></span></span>
	</div>
  </div>
  <div class="form-group">
    <label>Tempat Lahir</label>
    <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir">
  </div>
  <div class="form-group">
    <label>Alamat</label>
    <textarea class="form-control" name="alamat" placeholder="Alamat"></textarea>
  </div>
  <div class="form-group">
    <label>Agama</label>
    <select name="kd_agama" class="form-control selectpicker">
    <?php echo $agama; ?>
	</select>
  </div>
   <div class="form-group">
    <label for="nama">Photo</label>
    <div class="row">
    <div class="col-lg-2"><span class="btn btn-default btn-file">
    Browse.. <input type="file" class="fotoSiswa" name="photo">
</span></div>
<div class="col-lg-3"><img class="img-thumbnail imgPreviewEdit" src="" alt="your image" style="display: none;"></div>
<div class="col-lg-3"><label id="pilihfileEdit"></label></div>
	
    </div>
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
 <tr><td>NIS</td><td>:</td><td id="dataNis">fff</td></tr>
 <tr><td>NISN</td><td>:</td><td id="dataNisn">fff</td></tr>
 <tr><td>Nama</td><td>:</td><td id="dataNama">fff</td></tr>
 <tr><td>Jen. Kel</td><td>:</td><td id="dataJenkel">fff</td></tr>
 <tr><td>No. Telp</td><td>:</td><td id="dataNoTelp">fff</td></tr>
 <tr><td>Jurusan</td><td>:</td><td id="dataJurusan">fff</td></tr>
 <tr><td>Kelas</td><td>:</td><td id="dataKelas">fff</td></tr>
 <tr><td>Tempat/Tgl Lahir</td><td>:</td><td id="dataTmptTglLahir">fff</td></tr>
 <tr><td>Agama</td><td>:</td><td id="dataAgama">fff</td></tr>
 <tr><td>Alamat</td><td>:</td><td id="dataAlamat">fff</td></tr>
 <tr><td>Photo</td><td>:</td><td><img class="img-thumbnail" width="200px" height="200px" id="dataPhoto" src=""></td></tr>
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