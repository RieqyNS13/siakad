<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
.table>thead>tr>th{
	vertical-align:top;
}

</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");
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
			url:'<?php echo site_url("admin/hapusNilaiUTS"); ?>',
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
		//if($(this).
		var njir=$("[name='kd_kelas']");
		var mbut;
		var index;
		var all;
		mbut="#modalSetting select[name='nis']";
		index=1;
		var all=true;
		var kd_kelas=$("#modalSetting [name='kd_kelas']").val();
	
		$.ajax({
			url:'<?php echo site_url('admin/nilai_proyek/getSiswaByKelas'); ?>',
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
                           Raport
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Nilai</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Raport
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
	
				<div class="row">
				<div class="col-lg-2">
				<button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modalSetting"> Filter Data</button>
				</div>
				<div class="col-lg-6">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/raport/gantiPaging"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/raport/index"); ?>">
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
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan=2 align="top">#</th>
                                        <th rowspan=2>NIS</th>
                                        <th rowspan=2>Nama Siswa</th>
                                        <th rowspan=2>Kelas</th>
                                        <th rowspan=2>Mapel</th>
                                   		<th rowspan=2>Semester</th>
                                   		<th rowspan=2>Tahun Ajaran</th>
                                   		<th colspan=2>Pengetahuan</th>
										
                                   		<th colspan=2>Keterampilan</th>
                                   		<th colspan=2>Sikap</th>
                                    </tr>
									<tr>
										<td>Angka</td>
										<td>Huruf</td>
										<td>Angka</td>
										<td>Huruf</td>
										<td>Angka</td>
										<td>Huruf</td>
									</tr>
                                </thead>
                                <tbody>
                                   <?php
									function konversi($mbuh){
										switch($mbuh){
											case 1:$huruf="D";break;
											case 2:$huruf="D+";break;
											case 3:$huruf="C-";break;
											case 4:$huruf="C";break;
											case 5:$huruf="C+";break;
											case 6:$huruf="B-";break;
											case 7:$huruf="B";break;
											case 8:$huruf="B+";break;
											case 9:$huruf="A-";break;
											case 10:$huruf="A";break;
											default:$huruf=$mbuh;break;
										}
										return $huruf;
									}
									function konversi2($mbuh){
										switch($mbuh){
											case 4:$huruf="SB";break;
											case 3:$huruf="B";break;
											case 2:$huruf="C";break;
											default:$huruf=$mbuh;break;
										}
										return $huruf;
									}
									$a=($startPage)+1;
								   foreach($dataNilai as $data){
										$nilaitugas=(float)$data->nilaitugas;
										$nilaiuts=(float)$data->nilaiuts;
										$nilaiuas=(float)$data->nilaiuas;
									   $pengetahuan=round(($nilaitugas+$nilaiuts+$nilaiuas)/3,2);
									   $rata2=($pengetahuan/100)*4;
									   $angka1=round($rata2,2);
									   $mbuh=round(($pengetahuan/100)*10);
									   $huruf1=konversi($mbuh);
									   $nilaipraktek=(float)$data->nilaipraktek;
									   $nilaiproyek=(float)$data->nilaiproyek;
									   $nilaiportofolio=(float)$data->nilaiportofolio;
									   $keterampilan=round(($nilaiproyek+$nilaipraktek+$nilaiportofolio)/3,2);
									   $rata2=($keterampilan/100)*4;
									    $angka2=round($rata2,2);
										 $mbuh=round(($keterampilan/100)*10);
										$huruf2=konversi($mbuh);
									   $sikap1=round($data->nilai_observasi);
									   $sikap2=round($data->nilai_diri);
									   $sikap3=round($data->nilai_antarteman);
									   $sikap4=round($data->nilai_jurnal);
									   $sikapCok=round(($sikap1+$sikap2+$sikap3+$sikap4)/4,2);
									    $angka3=round($sikapCok,2);
										$mbuh=round($sikapCok);
										$huruf3=konversi2($mbuh);
									   
									   echo "<tr><td>$a</td><td>".$data->nis."</td><td>".$data->nama."</td><td>".$data->kelas."</td><td>".$data->nama_mapel."</td><td>".$data->semester."</td><td>".$data->tahun_ajaran."</td>";
									   echo "<td>".$angka1."</td><td>".$huruf1."</td><td>".$angka2."</td><td>".$huruf2."</td><td>".$angka3."</td><td>".$huruf3."</td>";
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


<div class="modal fade" tabindex="-1" role="dialog" id="modalSetting">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
	<form method="post" action="<?php echo site_url("admin/raport/gantiPaging"); ?>" >
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