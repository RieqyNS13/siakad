<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");

function hapusData(kode,obj){
	var x=($('#'+obj).html());
	$("body").data("id_forHapus",kode);
	$("#modalHapusBody").html("Hapus data ?");
	$("#modalHapusJudul").html("Konfirmasi Hapus");
	$("#modalHapus").modal('show');
	return false;
}
function editData(kode){
	$("[name='id_forEdit']").val(kode);
	$.ajax({
		url:'<?php echo site_url("admin/bagi_mapel/detailBagiMapel"); ?>',
		type:'post',
		data:{id:kode},
		dataType:'json'
	}).done(function(data){
		$("[name='kelas_prefix']:eq(1)").val(data.kelas_prefix);
		$("[name='kd_jurusan']:eq(1)").val(data.kd_jurusan);
		$("[name='kode_mapel']:eq(1)").val(data.kode_mapel);
		$("[name='tahun_ajaran']:eq(1)").val(data.tahun_ajaran);
		var asu='';
		$(".semester:eq(1) label").removeClass("active");
		if(data.semester=='1'){
			asu=$(".semester:eq(1)").find("label:eq(0)");
		}else{
			asu=$(".semester:eq(1)").find("label:eq(1)");			
		}
		asu.addClass("active");
		asu.find("input").prop("checked",true);
		$("[name='kode_kelompok_mapel']:eq(1)").val(data.kode_kelompok_mapel);
		$("#modalEdit select").selectpicker('refresh');
		$("#modalEdit").modal("show");
	});
	return false;
}
$(function(){ 
	//$("[name='kelas_prefix']:eq(2)").val('<?php echo $kelas_prefix; ?>');
	//$("[name='kd_jurusan']:eq(2)").val('<?php echo $kd_jurusan; ?>');
	//$("[name='semester']:eq(2)").val('<?php echo $semester; ?>');
	//$("[name='kode_kelompok_mapel']:eq(2)").val('<?php echo $kode_kelompok_mapel; ?>');
	$("body").data("isRefresh",false);
	$("#konfirmHapus").click(function(){
		$.ajax({
			url:'<?php echo site_url("admin/bagi_mapel/hapusBagiMapel"); ?>',
			type:'post',
			data:{id_forHapus:$("body").data("id_forHapus")},
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
	$("#frmEdit").ajaxForm({
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
                            Pembagian <small>Mapel</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Kurikulum</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Pembagian Mapel
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php 
				if($hak_akses=="admin" || $hak_akses=="kurikulum"){
					?>
                <div class="row">
				<div class="col-lg-12">
						<button class="btn btn-primary" id="btnTambahMrkt" data-toggle="modal" data-target="#modalTambahBagiMapel"><i class="fa fa-plus"></i> Tambah Pembagian Mapel</button>
                    </div>
				</div>
				<hr>
				<?php } ?>
				<div class="row">
				<div class="col-lg-2">
				<button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modalSetting"> Filter Pencarian</button>
				</div>
				<div class="col-lg-6">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/bagi_mapel/gantiPaging"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/bagi_mapel/index"); ?>">
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
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Tahun Ajaran</th>
                                       <th>Semester</th>
                                   		<th>Kode Mapel</th>
                                   		<th>Nama Mapel</th>
                                   		<th>Kelompok Mapel</th>
                                   		<?php if($hak_akses=="admin" || $hak_akses=="kurikulum")echo "<th>Aksi</th>"; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									$a=($startPage)+1;
								   foreach($dataBagiMapel as $data){
									  
										if($data->semester==1)$mbuh="Ganjil";
										else $mbuh="Genap";
									   echo "<tr><td>$a</td><td id=\"data".$a."\">".$data->kelas_prefix."</td><td>".$data->nama_jurusan."</td><td>".$data->tahun_ajaran."</td><td>".$data->semester." | $mbuh</td><td>".$data->kode_mapel."</td><td>".$data->nama_mapel."</td><td>".$data->kode_kelompok." (".$data->nama_kelompok_mapel.") </td>";
									   if($hak_akses=="admin" || $hak_akses=="kurikulum")echo "<td><a href=\"#\" onclick=\"return editData('".addslashes($data->id)."')\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit</a> | <a href=\"#\" onclick=\"return hapusData('".addslashes($data->id)."','data".$a."')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</a></td>";
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
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambahBagiMapel">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmTambah" method="post" action="<?php echo site_url("admin/bagi_mapel/tambahBagiMapel"); ?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Pembagian Mapel</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label>Prefix Kelas</label>
<select name="kelas_prefix" class="form-control selectpicker">
<option value="X">X</option>
<option value="XI">XI</option>
<option value="XII">XII</option>
</select>
  </div>
  <div class="form-group">
    <label>Jurusan</label>
<select name="kd_jurusan" class="form-control selectpicker">
<?php 
echo $jurusan;
 ?>
</select>
  </div>
  <div class="form-group">
    <label>Tahun Ajaran</label>
	<select name="tahun_ajaran" class="form-control selectpicker gay" data-live-search="true">
	<?php 
	$y=(int)date("Y");
	//$y=$y-5;
	for($i=0; $i<5; $i++){
		$njir=$y.'-'.($y+1);
		echo '<option value="'.$njir.'">'.$njir.'</option>';
		$y--;
	}
	?>
	</select>
</div>
  <div class="form-group">
    <label>Semester</label><br>
	<div class="btn-group semester" data-toggle="buttons">
  <label class="btn btn-default active">
    <input type="radio" name="semester" id="option1" value="1" autocomplete="off" checked> Satu (Ganjil)
  </label>
  <label class="btn btn-default ">
    <input type="radio" name="semester" id="option2" value="2" autocomplete="off"> Dua (Genap)
  </label>
</div>
  </div>
   <div class="form-group">
    <label>Mapel</label>
<select name="kode_mapel" class="form-control selectpicker" data-live-search=true>
<?php 
echo $kodeMapel;
 ?>
</select>
  </div>
  <div class="form-group">
    <label>Kelompok Mapel</label>
<select name="kode_kelompok_mapel" class="form-control selectpicker">
<?php 
echo $kelompokMapel;
 ?>
</select>
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



<div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmEdit" method="post" action="<?php echo site_url("admin/bagi_mapel/editBagiMapel"); ?>">
		<input type="hidden" name="id_forEdit" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit  Pembagian Mapel</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label>Prefix Kelas</label>
<select name="kelas_prefix" class="form-control selectpicker">
<option value="X">X</option>
<option value="XI">XI</option>
<option value="XII">XII</option>
</select>
  </div>
  <div class="form-group">
    <label>Jurusan</label>
<select name="kd_jurusan" class="form-control selectpicker">
<?php 
echo $jurusan;
 ?>
</select>
  </div>
  <div class="form-group">
    <label>Tahun Ajaran</label>
	<select name="tahun_ajaran" class="form-control selectpicker gay" data-live-search="true">
	<?php 
	$y=(int)date("Y");
	//$y=$y-5;
	for($i=0; $i<5; $i++){
		$njir=$y.'-'.($y+1);
		echo '<option value="'.$njir.'">'.$njir.'</option>';
		$y--;
	}
	?>
	</select>
</div>
  <div class="form-group">
    <label>Semester</label><br>
	<div class="btn-group semester" data-toggle="buttons">
  <label class="btn btn-default active">
    <input type="radio" name="semester" id="option1" value="1" autocomplete="off" checked> Satu (Ganjil)
  </label>
  <label class="btn btn-default ">
    <input type="radio" name="semester" id="option2" value="2" autocomplete="off"> Dua (Genap)
  </label>
</div>
  </div>
   <div class="form-group">
    <label>Mapel</label>
<select name="kode_mapel" class="form-control selectpicker" data-live-search=true>
<?php 
echo $kodeMapel;
 ?>
</select>
  </div>
  <div class="form-group">
    <label>Kelompok Mapel</label>
<select name="kode_kelompok_mapel" class="form-control selectpicker">
<?php 
echo $kelompokMapel;
 ?>
</select>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modalSetting">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
	<form method="post" action="<?php echo site_url("admin/bagi_mapel/gantiPaging"); ?>" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="x">Tampilkan Data Berdasarkan</h4>
      </div>
	  <div class="modal-body" id="xx">
	 <p>
	 <div class="form-group">
    <label>Prefix Kelas</label>
<select name="kelas_prefix" class="form-control selectpicker">
<option value="0">Semua</option>
<option value="X">X</option>
<option value="XI">XI</option>
<option value="XII">XII</option>
</select>
  </div>
  <div class="form-group">
    <label>Jurusan</label>
<select name="kd_jurusan" class="form-control selectpicker">
<option value="0">Semua</option>
<?php 
echo $jurusan;
 ?>
</select>
  </div>
  <div class="form-group">
    <label>Tahun Ajaran</label>
	<select name="tahun_ajaran" class="form-control selectpicker gay" data-live-search="true">
	<option value="0">Semua</option>

	<?php 
	$y=(int)date("Y");
	//$y=$y-5;
	for($i=0; $i<5; $i++){
		$njir=$y.'-'.($y+1);
		echo '<option value="'.$njir.'">'.$njir.'</option>';
		$y--;
	}
	?>
	</select>
</div>
  <div class="form-group">
    <label>Semester</label>
<select name="semester" class="form-control selectpicker">
<option value="0">Semua</option>
<option value="1">Satu (Ganjil)</option>
<option value="2">Dua (Genap)</option>
</select>
  </div>
  <div class="form-group">
    <label>Kelompok Mapel</label>
<select name="kode_kelompok_mapel" class="form-control selectpicker">
<option value="0">Semua</option>
<?php 
echo $kelompokMapel;
 ?>
</select>
  </div>
	 </p>
	  </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Submit</button>
      </div>
	  </form>
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