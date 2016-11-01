<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");
function detailNilai(id){
	$.ajax({
		url:'<?php echo site_url('admin/nilai_uts/getNilaiUts'); ?>',
		type:'get',
		data:{id:id},
		dataType:'json',
		beforeSend:function(){
			
		}		
	}).done(function(data){
		$("#dataNis").html(data.nis);
		$("#dataNama").html(data.nama);
		$("#dataKelas").html(data.kelas);
		$("#dataMapel2").html(data.nama_mapel);
		$("#dataSemester").html(data.semester2);
		$("#dataTahunAjaran").html(data.tahun_ajaran);
		$("#dataNilai").html(data.nilai);
		$("#detailJudul").html("Detail Nilai UTS");
		$("#dataGuruPenilai").html(data.namaguru);
		$("#modalDetail").modal('show');
			
		
	}).fail(function(xhr,err){
		alert(err);
	});
	return false;
}
function hapusNilai(id){
	$("body").data("idHapus",id);
	$("#modalHapusBody").html("Hapus nilai yang dipilih ?");
	$("#modalHapusJudul").html("Konfirmasi Hapus");
	$("#modalHapus").modal('show');
	return false;
}
function editNilai(id){
	//var obj=JSON.parse(objraw);
	$("[name='idEdit']").val(id);
	$.ajax({
		url:'<?php echo site_url("admin/nilai_uts/getNilaiUts"); ?>',
		type:'get',
		data:{id:id},
		dataType:'json'
	}).done(function(data){
		$("#modalEditNilai [name='nis']").val(data.nis+' | '+data.nama);
		$("#modalEditNilai [name='kd_mapel']").val(data.nama_mapel);
		$("#modalEditNilai [name='tahun_ajaran']").val(data.tahun_ajaran);
		var index;
		if(data.semester==1)index=0;
		else index=1;
		$("#modalEditNilai label.btn").removeClass("active");
		$("#modalEditNilai label.btn:eq("+index+")").addClass("active");
		$("#modalEditNilai input[type='radio']:eq("+index+")").prop("checked",true);
		$("#modalEditNilai [name='nilai']").val(data.nilai);		
		$("#modalEditNilai select").selectpicker('refresh');
		$("#modalEditNilai").modal("show");
	});
	return false;
}
$(function(){
	$("body").data("nipEdit",'');
	$("body").data("isRefresh",false);
	$("#modalSetting [name='kd_kelas']").val('<?php echo $kd_kelas_value; ?>');
	$("#modalSetting [name='nis']").val('<?php echo $nis_value; ?>');
	$("#modalSetting [name='kd_mapel']").val('<?php echo $kd_mapel_value; ?>');
	$("#modalSetting [name='semester']").val('<?php echo $semester_value; ?>');
	$("#modalSetting [name='tahun_ajaran']").val('<?php echo $tahun_ajaran_value; ?>');
	$("#modalSetting select").selectpicker('refresh');
	$("#konfirmHapus").click(function(){
		var data={id:$("body").data("idHapus")};
		$.ajax({
			url:'<?php echo site_url("admin/nilai_uts/hapusNilaiUts"); ?>',
			type:'post',
			data:data,
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
	$("#frmeditNilai").ajaxForm({
		beforeSubmit:function(){
			$("button,input:not(.ora)").prop("disabled",true);
		},
		dataType:'json',
		success:function(data){
			$("button,input:not(.ora)").prop("disabled",false);
			if(data.sukses){
				$("#logBody").html(data.sukses);
				$("#logJudul").html("Sukses");
				$("body").data("isRefresh",true);
			}else if(data.error){
				$("#logBody").html(data.error);
				$("#logJudul").html("Warning");
			}
			$("#modalLog").modal("show");
			$("button,input:not(.ora)").prop("disabled",false);
		},
		error:function(xhr,error,er){
			$("button,input:not(.ora)").prop("disabled",false);
			alert(error);
			
		}
	});
	$('body').tooltip({selector:'[data-toggle="tooltip"]'});
	$("#modalTambahNilai [name='kd_kelas'],#modalSetting [name='kd_kelas']").change(function(e){
		var kd_kelas;
		//if($(this).
		var njir=$("[name='kd_kelas']");
		var mbut;
		var index;
		var all;
		if(njir.index(this)==0){
			mbut="#modalTambahNilai select[name='nis']";
			index=0;
			all=false;
			kd_kelas=$("#modalTambahNilai [name='kd_kelas']").val();
		}
		else{
			mbut="#modalSetting select[name='nis']";
			index=1;
			all=true;
			kd_kelas=$("#modalSetting [name='kd_kelas']").val();
		}
		$.ajax({
			url:'<?php echo site_url('admin/nilai_uts/getSiswaByKelas'); ?>',
			type:'get',
			data:{kd_kelas:kd_kelas,all:all},
			beforeSend:function(){
				$("select[name='nis']").prop("disabled",true);
			}
		}).done(function(data){
			$("select[name='nis']").prop("disabled",false);
			$(mbut).html(data);

			$("select[name='nis']").selectpicker('refresh');
		}).fail(function(xhr,er){
			alert(er);
			$("select[name='nis']").prop("disabled",false);
		});
	});
	$("#frmTambahNilai").ajaxForm({
		beforeSubmit:function(){
			$("button,input:not(.ora)").prop("disabled",true);
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
			$("button,input:not(.ora)").prop("disabled",false);
		},
		error:function(xhr,error,er){
			$("button,input:not(.ora)").prop("disabled",false);
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
                           Nilai <small>UTS</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Nilai</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Nilai UTS
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php 
				if($hakAkses=="guru"){
				?>
                <div class="row">
				<div class="col-lg-12">
						<button class="btn btn-primary" id="btnTambahMrkt" data-toggle="modal" data-target="#modalTambahNilai"><i class="fa fa-plus"></i> Input Nilai</button>
                    </div>
				</div>
				<hr>
				<?php } ?>
				<div class="row">
				<div class="col-lg-2">
				<button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modalSetting"> Filter Data</button>
				</div>
				<div class="col-lg-6">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/nilai_uts/gantiPaging"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/nilai_uts/index"); ?>">
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
                                        <th>Kelas</th>
                                   		<th>Nama Mapel</th>
                                   		<th>Semester</th>
                                   		<th>Tahun Ajaran</th>
                                   		<th>Nilai UTS</th>
                                   		<th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									$a=($startPage)+1;
								   foreach($dataNilaiUTS as $data){
									   echo "<tr><td>$a</td><td>".$data->nis."</td><td>".$data->nama."</td><td>".$data->kelas."</td><td>".$data->nama_mapel."</td><td>".$data->semester2."</td><td>".$data->tahun_ajaran."</td><td>".$data->nilai."</td><td>";
									    if($hakAkses=="guru" && in_array($data->kd_mapel,$mapelYangDiajar))echo "<a href=\"#\" onclick=\"return editNilai('".$data->id."')\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit</a> | ";
										 if($hakAkses=="admin" || ($hakAkses=="guru" && in_array($data->kd_mapel,$mapelYangDiajar)))echo "<a href=\"#\" onclick=\"return hapusNilai('".$data->id."')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</a> | ";
									   echo "<a href=\"#\" onclick=\"return detailNilai('".$data->id."')\"><span class=\"glyphicon glyphicon-eye-open\"></span>	Detail</a>";
										echo "</td></tr>";
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
<div class="modal fade" tabindex="-1" role="dialog" id="modalTambahNilai">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmTambahNilai" method="post" action="<?php echo site_url("admin/nilai_uts/tambahNilaiUts"); ?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Nilai UTS</h4>
      </div>
      <div class="modal-body">
        <p>
		<div class="form-group">
    <label>Kelas</label>
<select name="kd_kelas" class="form-control selectpicker" data-live-search="true">
	<option value="0">Semua kelas</option> 

<?php foreach($kelas as $key=>$mbuh){
				 echo "<optgroup label=\"".$key."\">";
				 foreach($mbuh as $key=>$mbuh2)echo "<option value=\"".$key."\">".$mbuh2."</option>";
				 echo "</optgroup>";
			} ?>
</select>
  </div>
  <hr>
  <div class="form-group">
    <label>NIS/Nama Siswa</label>
<select name="nis" class="form-control selectpicker gay" data-live-search="true">
<?php echo $nisData; ?>
</select>
  </div>

  <div class="form-group">
    <label>Mapel</label>
	<select name="kd_mapel" class="form-control selectpicker gay" data-live-search="true">
<?php echo $mapelData; ?>
</select>
</div>
<div class="form-group">
    <label>Semester</label><br>
	<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-default active">
    <input type="radio" class="gay" name="semester" id="option1" autocomplete="off" value="1" checked> 1 | Ganjil
  </label>
  <label class="btn btn-default">
    <input type="radio" class="gay" name="semester" id="option2" autocomplete="off" value="2"> 2 | Genap
  </label>
</div>
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
    <label class="lblNilai">Nilai UTS</label>
	<div class="row">
	<div class="col-sm-6" >
		<input type="text" class="form-control" name="nilai" placeholder="Masukkan Nilai (1-100)">
	</div>
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



<div class="modal fade" tabindex="-1" role="dialog" id="modalEditNilai">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmeditNilai" method="post" action="<?php echo site_url("admin/nilai_uts/editNilaiUts"); ?>">
	<input type="hidden" name="idEdit" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Nilai UTS</h4>
      </div>
      <div class="modal-body">
        <p>
  <div class="form-group">
    <label>NIS | Nama Siswa</label>
	<input type="text" class="form-control ora"  disabled="disabled" value="" name="nis">
  </div>
  <div class="form-group">
    <label>Mapel</label>
	<input type="text" class="form-control ora" disabled="disabled" value="" name="kd_mapel">
</div>
  <hr>
<div class="form-group">
    <label>Semester</label><br>
	<div class="btn-group" data-toggle="buttons">
  <label class="btn btn-default active">
    <input type="radio" name="semester" id="option1" autocomplete="off" value="1" checked> 1 | Ganjil
  </label>
  <label class="btn btn-default">
    <input type="radio" name="semester" id="option2" autocomplete="off" value="2"> 2 | Genap
  </label>
</div>
  </div>
   <div class="form-group">
    <label>Tahun Ajaran</label>
	<select name="tahun_ajaran" class="form-control selectpicker" data-live-search="true">
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
    <label class="lblNilai">Nilai UTS</label>
	<div class="row">
	<div class="col-sm-6" >
		<input type="text" class="form-control" name="nilai" placeholder="Masukkan Nilai (1-100)">
	</div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modalSetting">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
	<form method="post" action="<?php echo site_url("admin/nilai_uts/gantiPaging"); ?>" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="x">Tampilkan Data Berdasarkan</h4>
      </div>
	  <div class="modal-body" id="xx">
	 <p>
	<div class="form-group">
    <label>Kelas</label>
	<select name="kd_kelas" class="form-control selectpicker">
	<option value="0">Semua kelas</option> 

<?php foreach($kelas as $key=>$mbuh){
				 echo "<optgroup label=\"".$key."\">";
				 foreach($mbuh as $key=>$mbuh2)echo "<option value=\"".$key."\">".$mbuh2."</option>";
				 echo "</optgroup>";
			} ?>
	</select>
	</div>
	 <div class="form-group">
    <label>NIS/Nama Siswa</label>
<select name="nis" class="form-control selectpicker gay" data-live-search="true">
<option value="0">Semua Siswa</option> 
<div class="nisData">
<?php echo $nisData; ?>
</div>
</select>
  </div>
  <div class="form-group">
    <label>Mapel</label>
	<select name="kd_mapel" class="form-control selectpicker gay" data-live-search="true">
	<option value="0">Semua Mapel</option> 
	<?php if($hakAkses=="guru") echo '<option value="00">Semua Mapel yang Diajar</option>'; ?> 
<?php echo $mapelData2; ?>
</select>
</div>
<div class="form-group">
    <label>Semester</label>
	<select name="semester" class="form-control selectpicker gay" data-live-search="true">
	<option value="0">Semua Semester</option> 
	<option value="1">1 | Ganjil</option>
	<option value="2">2 | Genap</option>
	</select>
</div>
<div class="form-group">
    <label>Tahu Ajaran</label>
	<select name="tahun_ajaran" class="form-control selectpicker gay" data-live-search="true">
	<option value="0">Semua Tahun Ajaran</option> 
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
 <tr><td>NIS</td><td>:</td><td id="dataNis">rieqyns13</td></tr>
 <tr><td>Nama Siswa</td><td>:</td><td id="dataNama">rieqyns13</td></tr>
  <tr><td>Kelas</td><td>:</td><td id="dataKelas">rieqyns13</td></tr>
 <tr><td>Mapel</td><td>:</td><td id="dataMapel2">rieqyns13</td></tr>
 <tr><td>Semester</td><td>:</td><td id="dataSemester">rieqyns13</td></tr>
 <tr id="vangke"><td>Tahun Ajaran</td><td>:</td><td id="dataTahunAjaran">rieqyns13</td></tr>
 <tr><td>Nilai UTS</td><td>:</td><td id="dataNilai">rieqyns13</td></tr>
 <tr><td>Guru Penilai</td><td>:</td><td id="dataGuruPenilai">rieqyns13</td></tr>
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