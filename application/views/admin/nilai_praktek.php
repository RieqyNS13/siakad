<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");
function detailNilai(nis,kd_mapel,semester,tahun_ajaran){
	$.ajax({
		url:'<?php echo site_url('admin/nilai_praktik/getNilaiPraktek'); ?>',
		type:'get',
		data:{nis:nis,kd_mapel:kd_mapel,semester:semester,tahun_ajaran:tahun_ajaran},
		dataType:'json',
		beforeSend:function(){
			
		}		
	}).done(function(dataArr){
		if(dataArr.jumlah>0){
			var data=dataArr.msg[0];
			$("#dataNis").html(data.nis);
			$("#dataNama").html(data.nama);
			$("#dataKelas").html(data.kelas);
			$("#dataMapel2").html(data.nama_mapel);
			$("#dataSemester").html(data.semester2);
			$("#dataTahunAjaran").html(data.tahun_ajaran);
			var njir='';
			var nilai=0;
			for(var i=0; i<dataArr.jumlah; i++){
				njir+='<tr class="nilaipraktek"><td>Nilai Praktek '+(i+1)+'</td><td>:</td><td>'+dataArr.msg[i].nilai+'</td></tr>';
				nilai+=parseFloat(dataArr.msg[i].nilai);
			}
			$(".nilaipraktek").remove();
			$("#vangke").after(njir);
			var jemvot=nilai/dataArr.jumlah;
			var semvak=jemvot.toFixed(2);
			$("#dataRata2").html(semvak);
			$("#detailJudul").html("Detail Nilai");
			$("#dataGuruPenilai").html(data.namaguru);
			$("#modalDetail").modal('show');
			
		}
	}).fail(function(xhr,err){
		alert(err);
	});
	return false;
}
function hapusNilai(nis,kd_mapel,semester,tahun_ajaran){
	$("body").data("nisHapus",nis);
	$("body").data("kd_mapelHapus",kd_mapel);
	$("body").data("semesterHapus",semester);
	$("body").data("tahun_ajaranHapus",tahun_ajaran);
	$("#modalHapusBody").html("Hapus nilai yang dipilih ?");
	$("#modalHapusJudul").html("Konfirmasi Hapus");
	$("#modalHapus").modal('show');
	return false;
}
function editNilai(nis,kd_mapel,semester,tahun_ajaran){
	//var obj=JSON.parse(objraw);
	$("[name='nisEdit']").val(nis);
	$("[name='kd_mapelEdit']").val(kd_mapel);
	$("[name='semesterEdit']").val(semester);
	$("[name='tahun_ajaranEdit']").val(tahun_ajaran);
	$.ajax({
		url:'<?php echo site_url("admin/nilai_praktik/getNilaiPraktek"); ?>',
		type:'get',
		data:{nis:nis,kd_mapel:kd_mapel,semester:semester,tahun_ajaran:tahun_ajaran},
		dataType:'json'
	}).done(function(dataX){
		var dataArr=dataX.msg;
		var data=dataArr[0];
		$("#modalEditNilai [name='nis']").val(data.nis+' | '+data.nama);
		$("#modalEditNilai [name='kd_mapel']").val(data.nama_mapel);
		$("#modalEditNilai [name='tahun_ajaran']").val(data.tahun_ajaran);
		var index;
		if(data.semester==1)index=0;
		else index=1;
		$("#modalEditNilai label.btn").removeClass("active");
		$("#modalEditNilai label.btn:eq("+index+")").addClass("active");
		$("#modalEditNilai input[type='radio']:eq("+index+")").prop("checked",true);
		var asu='<div class="form-group"><label class="lblNilai">Nilai Praktek 1</label><div class="row"><div class="col-sm-6" ><input type="text" class="form-control" name="nilai[]" placeholder="Masukkan Nilai (1-100)" value="'+dataArr[0].nilai+'"></div></div>';
		asu+='<input type="hidden" name="id[]" value="'+dataArr[0].id+'">';
		asu+='</div>';
		for(var i=1; i<dataArr.length; i++){
			asu+='<div class="form-group"><label class="lblNilai">Nilai Praktek '+(i+1)+'</label><div class="row"><div class="col-sm-6" ><input type="text" class="form-control" name="nilai[]" placeholder="Masukkan Nilai (1-100)" value="'+dataArr[i].nilai+'"></div><div class="col-sm-6"><a href="#" id="hapusForm2" data-toggle="tooltip" data-placement="right" title="Hapus Form"><i class="icon-remove"></i></a></div></div>';
			asu+='<input type="hidden" name="id[]" value="'+dataArr[i].id+'">';
			asu+='</div>';
		}
		$("#nilaiForm2").html(asu);
		var cok=$("#modalEditNilai .lblNilai");
		if(dataArr.length>=1){
			var start=dataArr.length+1;
			table='<table class="table table-striped">';
			table+='<tr>';
			for(var i=0; i<dataArr.length; i++){
				table+='<th>Nilai Praktek '+(i+1).toString()+'</th>';
			}
			table+='</tr><tr>';
			for(var i=0; i<dataArr.length; i++){
				table+='<td>'+dataArr[i].nilai+'</td>';
				cok.eq(i).html('Nilai Praktek '+(i+1));
			}
			table+='</tr></table>';
		}else{
			table='<div class="alert alert-info" role="alert">Tidak ada record nilai. Nilai dimulai dari Praktek 1</div>';
			var start=1;
		}
		$("#nilaiCok2").html(table);
		
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
		var data={nis:$("body").data("nisHapus"),kd_mapel:$("body").data("kd_mapelHapus"),
		semester:$("body").data("semesterHapus"),tahun_ajaran:$("body").data("tahun_ajaranHapus")};
		$.ajax({
			url:'<?php echo site_url("admin/nilai_praktik/hapusNilaiPraktek"); ?>',
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
	$("body").on("click","#hapusForm",function(e){
		e.preventDefault();
		var mbuh=$(this).parent().parent().parent();
		mbuh.remove();
		var x=$("#modalTambahNilai .lblNilai");
		var x2=$("#modalTambahNilai td");
		var start=x2.length;
		$.each(x,function(i){
			$(this).html('Nilai Praktek '+(start+1));
			start++;
		});
	});
	$("body").on("click","#hapusForm2",function(e){
		e.preventDefault();
		var mbuh=$(this).parent().parent().parent();
		mbuh.remove();
		var x=$("#modalEditNilai .lblNilai");
		$.each(x,function(i){
			$(this).html('Nilai Praktek '+(i+1));
		});
	});
	$("#tambahNilai").click(function(e){
		e.preventDefault();
		var tot=$("#modalTambahNilai [name='nilai[]']").length;
		var tot2=$("#nilaiCok td").length;
		var jumlah=tot+tot2;
		if(jumlah>=5){
			$("#logBody").html("Maximal 5 Nilai Praktek");
			$("#logJudul").html("Info");
			$("#modalLog").modal('show');
			return false;
		}
		var mbuh='<div class="form-group"><label class="lblNilai">Nilai Praktek '+(tot+tot2+1)+'</label><div class="row"><div class="col-sm-6" ><input type="text" class="form-control" name="nilai[]" placeholder="Masukkan Nilai (1-100)"></div><div class="col-sm-6"><a href="#" id="hapusForm" data-toggle="tooltip" data-placement="right" title="Hapus Form"><i class="icon-remove"></i></a></div></div></div>';
		$("#nilaiForm").append(mbuh);
	});
	$("#tambahNilai2").click(function(e){
		e.preventDefault();
		var tot=$("#modalEditNilai [name='nilai[]']").length;
		if(tot==5){
			$("#logBody").html("Maximal 5 Nilai Praktek");
			$("#logJudul").html("Info");
			$("#modalLog").modal('show');
			return false;
		}
		var mbuh='<div class="form-group"><label class="lblNilai">Nilai Praktek '+(tot+1)+'</label><div class="row"><div class="col-sm-6" ><input type="text" class="form-control" name="nilai[]" placeholder="Masukkan Nilai (1-100)"></div><div class="col-sm-6"><a href="#" id="hapusForm2" data-toggle="tooltip" data-placement="right" title="Hapus Form"><i class="icon-remove"></i></a></div></div></div>';
		$("#nilaiForm2").append(mbuh);
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
				$("#logJudul").html("Error");
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
		var kelas;
		if(njir.index(this)==0){
			mbut="#modalTambahNilai [name='nis']";
			index=0;
			all=false;
			kd_kelas=$("#modalTambahNilai [name='kd_kelas']").val();
			
			var x=$("#modalTambahNilai select[name='kd_kelas']").find("option");
			//var 
			
			$.each(x,function(){
				if($(this).val()==kd_kelas)kelas=$(this).text();
			});
		}
		else{
			mbut="#modalSetting select[name='nis']";
			index=1;
			all=true;
			kd_kelas=$("#modalSetting [name='kd_kelas']").val();
		}
		$.ajax({
			url:'<?php echo site_url('admin/nilai_praktik/getSiswaByKelas'); ?>',
			type:'get',
			data:{kd_kelas:kd_kelas,all:all},
			beforeSend:function(){
				$("select[name='nis']").prop("disabled",true);
			}
		}).done(function(data){
			$("select[name='nis']").prop("disabled",false);
			var lbl;
			if(index==0)lbl='<option value="pilihsiswa">Pilih Siswa '+kelas+'</option>';

			else lbl='';
			$(mbut).html(lbl+data);

			$("select[name='nis']").selectpicker('refresh');
		}).fail(function(xhr,er){
			alert(er);
			$("select[name='nis']").prop("disabled",false);
		});
	});
	$("#modalTambahNilai select.gay,input.gay[type='radio']").change(function(e){
		var nis=$("[name='nis']:eq(0)").val();
		var mapel=$("[name='kd_mapel']:eq(0)").val();
		var semester=$("#modalTambahNilai [name='semester']:checked").val();
		var tahun_ajaran=$("[name='tahun_ajaran']:eq(0)").val();
		$.ajax({
			url:'<?php echo site_url('admin/nilai_praktik/getNilaiPraktek'); ?>',
			type:'get',
			dataType:'json',
			data:{nis:nis,kd_mapel:mapel,semester:semester,tahun_ajaran:tahun_ajaran},
			beforeSend:function(){
				$("input:not(.ora),select,button").prop("disabled",true);
			}
		}).done(function(data){
			$("input:not(.ora),select,button").prop("disabled",false);
			if(data.jumlah>=5){
				$("#modalTambahNilai button[type='submit']").prop("disabled",true);
				$("#nilaiCok").html('<div class="alert alert-warning" role="alert">Jumlah nilai praktek sudah mencapai maximal, tidak bisa menambah lagi</div>');
				$("#nilaiForm,#tambahNilai").hide();
				return false;
			}
			if(data.msg){
				$("#nilaiCok").html('');
				$("#nilaiForm,#tambahNilai").show();
				$("#modalTambahNilai button[type='submit']").prop("disabled",false);
				var table='';
				if(data.jumlah>=1){
					var start=data.jumlah+1;
					table='<table class="table table-striped">';
					table+='<tr>';
					for(var i=0; i<data.jumlah; i++){
						table+='<th>Nilai Praktek '+(i+1).toString()+'</th>';
					}
					table+='</tr><tr>';
					for(var i=0; i<data.jumlah; i++){
						table+='<td>'+data.msg[i].nilai+'</td>';
					}
					table+='</tr></table>';
				}else{
					table='<div class="alert alert-info" role="alert">'+data.msg+'</div>';
					var start=1;
				}
			}
			$("#nilaiCok").html(table);
			var cok=$("#modalTambahNilai .lblNilai");
			
			$.each(cok,function(){
				$(this).html('Nilai Praktek '+(start));
				start++;
			});
			
		}).fail(function(xhr,err){
			$("input:not(.ora),select,button").prop("disabled",false);
			alert(err);
		});
		//alert('asu');
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
                           Nilai <small>Praktek</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Nilai</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Nilai Praktek
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
						<button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahNilai"><i class="fa fa-plus"></i> Input Nilai</button>
                    </div>
				</div>
				<hr>
				<?php } ?>
				<div class="row">
				<div class="col-lg-2">
				<button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modalSetting"> Filter Data</button>
				</div>
				<div class="col-lg-6">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/nilai_praktik/gantiPaging"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/nilai_praktik/index"); ?>">
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
                                   		<th>Jumlah Praktek</th>
                                   		<th>Rata-rata</th>
                                   		<th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
									$a=($startPage)+1;
								   foreach($dataNilai as $data){
									   echo "<tr><td>$a</td><td>".$data->nis."</td><td>".$data->nama."</td><td>".$data->kelas."</td><td>".$data->nama_mapel."</td><td>".$data->semester2."</td><td>".$data->tahun_ajaran."</td><td>".$data->jumlah."</td><td>".$data->rata2."</td><td>";
									   if($hakAkses=="guru" && in_array($data->kd_mapel,$mapelYangDiajar))echo "<a href=\"#\" onclick=\"return editNilai('".$data->nis."','".$data->kd_mapel."','".$data->semester."','".$data->tahun_ajaran."')\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit</a> | ";
									   if($hakAkses=="admin" || ($hakAkses=="guru" && in_array($data->kd_mapel,$mapelYangDiajar)))echo "<a href=\"#\" onclick=\"return hapusNilai('".$data->nis."','".$data->kd_mapel."','".$data->semester."','".$data->tahun_ajaran."')\"><span class=\"glyphicon glyphicon-trash\"></span> Hapus</a> | ";
									   echo "<a href=\"#\" onclick=\"return detailNilai('".$data->nis."','".$data->kd_mapel."','".$data->semester."','".$data->tahun_ajaran."')\"><span class=\"glyphicon glyphicon-eye-open\"></span>	Detail</a>";
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
	<form id="frmTambahNilai" method="post" action="<?php echo site_url("admin/nilai_praktik/tambahNilaiPraktek"); ?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Nilai Praktek</h4>
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
<option class="pilihSiswa" value="pilihsiswa">Pilih Siswa</option>
<?php echo $nisData; ?>
</select>
  </div>
  <hr>
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
<hr>
<div class="row">
<div class="col-sm-12" id="nilaiCok">
</div>
</div>
<div id="nilaiForm">
<div class="form-group">
    <label class="lblNilai">Nilai Praktek 1</label>
	
	<div class="row">
	<div class="col-sm-6" >
		<input type="text" class="form-control" name="nilai[]" placeholder="Masukkan Nilai (1-100)">
	</div>
	</div>
</div>
</div><!--end nilaiForm-->
<div class="row">
<div class="col-sm-6">
	<a href="#" id="tambahNilai" data-toggle="tooltip" data-placement="right" title="Tambah Form Input Nilai"><i class="icon-plus icon-1x"></i> Tambah Form</a>
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
	<form id="frmeditNilai" method="post" action="<?php echo site_url("admin/nilai_praktik/editNilaiPraktek"); ?>">
	<input type="hidden" name="nisEdit" value="">
	<input type="hidden" name="kd_mapelEdit" value="">
	<input type="hidden" name="semesterEdit" value="">
	<input type="hidden" name="tahun_ajaranEdit" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Nilai Praktek</h4>
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
<hr>
<div class="row">
<div class="col-sm-12" id="nilaiCok2">
</div>
</div>
<div id="nilaiForm2">

</div><!--end nilaiForm-->
<div class="row">
<div class="col-sm-6">
	<a href="#" id="tambahNilai2" data-toggle="tooltip" data-placement="right" title="Tambah Form Input Nilai"><i class="icon-plus icon-1x"></i> Tambah Form</a>
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
	<form method="post" action="<?php echo site_url("admin/nilai_praktik/gantiPaging"); ?>" >
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
    <label>TahunAjaran</label>
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
 <tr><td>Nilai Rata-rata</td><td>:</td><td id="dataRata2">rieqyns13</td></tr>
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