<!-- Page Heading -->
<style type="text/css">
.col-sm-2#tambahGuru {
	width: 12.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");

function hapusGuru(kode_guru){
	$("body").data("kode_guruforHapus",kode_guru);
	$("#modalHapusBody").html("Hapus guru dengan kode_guru '"+kode_guru+"'?");
	$("#modalHapusJudul").html("Konfirmasi Hapus");
	$("#modalHapus").modal('show');
	return false;
}
function lihatDetail(kode){
	$.ajax({
		url:'<?php echo site_url("admin/guru/lihatDetailGuru"); ?>',
		type:'post',
		data:{kode_guru:kode},
		dataType:'json'
	}).done(function(data){
		$("#dataKodeGuru").html(data.kode_guru);
		$("#dataNip").html(data.nip);
		$("#dataNamaGuru").html(data.nama);
		$("#dataNoTelpon").html(data.telepon);
		$("#dataTmptTglLahir").html(data.tempat_lahir+", "+data.tgl_lahir);
		$("#dataAlamat").html(data.alamat);
		if(data.photo.length>0){
			$("#dataPhoto").attr("src",'<?php echo base_url(); ?>'+'/'+data.photo);
			$("#dataPhoto").show();
		}else $("#dataPhoto").hide();
		$("#detailJudul").html("Detail Guru Kode '"+kode+"'");
		$("#modalDetail").modal('show');
	});
	return false;
}
function editGuru(kode_guru){
	$("[name='kode_guruforEdit']").val(kode_guru);
	$.ajax({
		url:'<?php echo site_url("admin/guru/lihatDetailGuru"); ?>',
		type:'post',
		data:'kode_guru='+encodeURIComponent(kode_guru),
		dataType:'json'
	}).done(function(data){
		$(".imgPreviewEdit").hide();
		$("[name='kode_guru2']").val(data.kode_guru);
		var x=$(".punyaNipBtn2");
		var z=$("[name='options2']");
		if(data.nip){
			$("#inputNip2").html('<input type="text" class="form-control" placeholder="Masukkan NIP" name="nip2">');
			$("[name='nip2']").val(data.nip);
			$("body").data("nipEdit",data.nip);
			x.removeClass("active");
			x.eq(1).addClass("active");
			z.eq(1).prop("checked", true);
		}else {
			$("#inputNip2").html("");
			x.removeClass("active");
			x.eq(0).addClass("active");
			z.eq(0).prop("checked", true);
		}
		$("[name='nama2']").val(data.nama);
		$("[name='telepon2']").val(data.telepon);
		$("[name='tempat_lahir2']").val(data.tempat_lahir);
		$("[name='tgl_lahir2']").val(data.tgl_lahir);
		$("[name='alamat2']").val(data.alamat);
		if(data.photo){$(".imgPreviewEdit").attr("src",'<?php echo base_url()."/"; ?>'+data.photo);
		$(".imgPreviewEdit").show();}
		$("#modalEditGuru").modal("show");
	});
	return false;
}
$(function(){
	$("body").data("nipEdit",'');
	$("body").data("isRefresh",false);
	$("#konfirmHapus").click(function(){
		$.ajax({
			url:'<?php echo site_url("admin/guru/hapusGuru"); ?>',
			type:'post',
			data:{kode_guruforHapus:$("body").data("kode_guruforHapus")},
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
	$(".fotoGuru:file").change(function(){
		var id=$(this).attr("id");
		var name=$(this).attr("name");
		var x=this.files[0];
		var ext = this.value.match(/\.(.+)$/)[1];
		 ext=ext.toLowerCase();
		 var arr=["gif","png","jpg","jpeg","bmp"];
		 var index=$.inArray(ext, arr);
		var pilih;
		var imgpre;
		if(name=="photo"){
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
	$("#frmEditGuru").ajaxForm({
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
	$("#frmTambahGuru").ajaxForm({
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
		cok.append("filecsv",data);
		$.ajax({
			url:'<?php echo site_url('admin/guru/importFile'); ?>',
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
                            Data <small>Guru</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Guru</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Data Guru
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php 
				if($hak_akses==="admin" || $hak_akses==="tatausaha"){
				?>
                <div class="row">
				<div class="col-sm-2" id="tambahGuru">
						<button class="btn btn-primary" id="btnTambahGuru" data-toggle="modal" data-target="#modalTambahGuru"><i class="fa fa-plus"></i> Tambah Guru</button>
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
				</div><!--end row-->
				<hr>
				<?php } ?>
				<div class="row">
				<div class="col-lg-8">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/guru/gantiPagingGuru"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/guru/index"); ?>">
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
                                        <th>Kode Guru</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Telepon</th>
										<th>Tempat Tahir</th>
										<th>Tgl Tahir</th>
										<th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									$a=($startPage)+1;
								   foreach($dataGuru as $data){
									  
									   echo "<tr><td>$a</td><td>".$data->kode_guru."</td><td>".$data->nip."</td><td>".$data->nama."</td><td>".$data->telepon."</td><td>".$data->tempat_lahir."</td>";
									   echo "<td>".$data->tgl_lahir."</td><td>";
									   if($hak_akses==="admin" || $hak_akses==="tatausaha")echo "<a href=\"#\" onclick=\"return editGuru('".addslashes($data->kode_guru)."')\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit</a> | <a href=\"#\" onclick=\"return hapusGuru('".addslashes($data->kode_guru)."')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</a> | ";
									   echo "<a href=\"#\" onclick=\"return lihatDetail('".addslashes($data->kode_guru)."')\"><span class=\"glyphicon glyphicon-eye-open\"></span> Detail</a></td></tr>";
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
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambahGuru">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmTambahGuru" method="post" action="<?php echo site_url("admin/guru/submitGuru"); ?>" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Guru</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label for="kodeguru">Kode Guru</label>
    <input type="text" class="form-control" placeholder="Kode Guru" name="kode_guru">
  </div>
  <div class="form-group">
    <label for="nip">NIP</label><br>
	<div class="row">
	<div class="col-sm-6 punyaNip" >
	<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-default active punyaNipBtn">
    <input type="radio" name="options" id="option1" value="1" autocomplete="off" checked> Tidak Punya
  </label>
  <label class="btn btn-default punyaNipBtn">
    <input type="radio" name="options" id="option2" value="2" autocomplete="off"> Punya
  </label>
</div>
</div>

</div>
<div class="row">
<div class="col-sm-12 spasiAtas" id="inputNip">
</div>
</div>
  </div>
  <div class="form-group">
    <label for="nama">Nama</label>
    <input type="text" class="form-control" placeholder="Nama Guru" name="nama">
  </div>
  <div class="form-group">
    <label for="nama">Telepon</label>
    <input type="text" class="form-control" placeholder="Telepon" name="telepon">
  </div>
  <div class="form-group">
    <label for="nama">Tempat Lahir</label>
    <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir">
  </div>
  <div class="form-group">
    <label for="nama">Tanggal Lahir</label>
	<div class="input-group date" id="dp3">
    <input type="text" class="form-control" name="tgl_lahir" placeholder="Pilih Tanggal Lahir">
	  <span class="input-group-addon"><span  class="glyphicon glyphicon-calendar"></span></span>
	</div>
  </div>
  <div class="form-group">
    <label for="nama">Alamat</label>
    <textarea class="form-control" name="alamat" placeholder="Alamat"></textarea>
  </div>
   <div class="form-group">
    <label for="nama">Photo</label>
    <div class="row">
    <div class="col-lg-2"><span class="btn btn-default btn-file">
    Browse.. <input type="file" class="fotoGuru" name="photo">
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



<div class="modal fade" tabindex="-1" role="dialog" id="modalEditGuru">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmEditGuru" method="post" action="<?php echo site_url("admin/guru/editGuru"); ?>" enctype="multipart/form-data">
		<input type="hidden" name="kode_guruforEdit" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Guru</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label for="kodeguru">Kode Guru</label>
    <input type="text" class="form-control" placeholder="Kode Guru" name="kode_guru2">
  </div>
  <div class="form-group">
    <label for="nip">NIP</label><br>
	<div class="row">
	<div class="col-sm-5 punyaNip" >
	<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-default active punyaNipBtn2">
    <input type="radio" name="options2" id="option1" value="1" autocomplete="off" checked> Tidak Punya
  </label>
  <label class="btn btn-default punyaNipBtn2">
    <input type="radio" name="options2" id="option2" value="2" autocomplete="off"> Punya
  </label>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12 spasiAtas" id="inputNip2">
</div>
</div>
  </div>
  <div class="form-group">
    <label for="nama">Nama</label>
    <input type="text" class="form-control" placeholder="Nama Guru" name="nama2">
  </div>
  <div class="form-group">
    <label for="nama">Telepon</label>
    <input type="text" class="form-control" placeholder="Telepon" name="telepon2">
  </div>
  <div class="form-group">
    <label for="nama">Tempat Lahir</label>
    <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir2">
  </div>
  <div class="form-group">
    <label for="nama">Tanggal Lahir</label>
	<div class="input-group date" id="dp2">
    <input type="text" class="form-control" name="tgl_lahir2" placeholder="Pilih Tanggal Lahir">
	  <span class="input-group-addon"><span  class="glyphicon glyphicon-calendar"></span></span>
	</div>
  </div>
  <div class="form-group">
    <label for="nama">Alamat</label>
    <textarea class="form-control" name="alamat2" placeholder="Alamat"></textarea>
  </div>
   <div class="form-group">
    <label for="nama">Photo</label>
    <div class="row">
    <div class="col-lg-2"><span class="btn btn-default btn-file">
    Browse.. <input type="file" class="fotoGuru" name="photo2">
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
 <tr><td>Kode Guru</td><td>:</td><td id="dataKodeGuru">fff</td></tr>
 <tr><td>NIP</td><td>:</td><td id="dataNip">fff</td></tr>
 <tr><td>Nama Guru</td><td>:</td><td id="dataNamaGuru">fff</td></tr>
 <tr><td>No. Telp</td><td>:</td><td id="dataNoTelpon">fff</td></tr>
 <tr><td>Tempat/Tgl. Lahir</td><td>:</td><td id="dataTmptTglLahir">fff</td></tr>
 <tr><td>Alamat</td><td>:</td><td id="dataAlamat">fff</td></tr>
 <tr><td>Photo</td><td>:</td><td><img width="200px" height="200px" class="img-thumbnail" src="" id="dataPhoto"></td></tr>
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