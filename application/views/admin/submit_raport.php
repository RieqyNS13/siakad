<!-- Page Heading -->
<style type="text/css">
.col-sm-5.punyaNip {
	width: 33.66666667%
}
.table>thead>tr>th{
	vertical-align:top;
}
#modalDetail .modal-content{
	width:1100px;
	margin-left:-90px;
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");
function detail(nis,semester,tahun_ajaran){
	$.ajax({
		url:'<?php echo site_url('admin/submit_raport/getNilaiRaport'); ?>',
		type:'post',
		data:{nis:nis,semester:semester,tahun_ajaran:tahun_ajaran},
		dataType:'json',
		beforeSend:function(){
			
		}		
	}).done(function(data){
		if(data.data){
			var label=[];
			var dataset=[];
			var jumlahnilaiP=0;
			var jumlahnilaiK=0;
			var jumlahnilaiS=0;
			var nilaip=[],nilaik=[],nilais=[];
			$("#detailJudul").html("Detail Raport "+data.data[0].nama);

			for(var i=0; i<data.jumlah; i++){
				label.push(data.data[i].nama_mapel);
			
				if(data.data[i].nilaitugas==null)data.data[i].nilaitugas=0;
				if(data.data[i].nilaiuas==null)data.data[i].nilaiuas=0;
				if(data.data[i].nilaiuts==null)data.data[i].nilaiuts=0;
				jumlahnilaiP=parseFloat(data.data[i].nilaitugas)+parseFloat(data.data[i].nilaiuas)+parseFloat(data.data[i].nilaiuts);
				jumlahnilaiP=jumlahnilaiP/3;
				if(data.data[i].nilaiproyek==null)data.data[i].nilaiproyek=0;
				if(data.data[i].nilaipraktek==null)data.data[i].nilaipraktek=0;
				if(data.data[i].nilaiportofolio==null)data.data[i].nilaiportofolio=0;
				jumlahnilaiK=parseFloat(data.data[i].nilaipraktek)+parseFloat(data.data[i].nilaiproyek)+parseFloat(data.data[i].nilaiportofolio);
				jumlahnilaiK=jumlahnilaiK/3;
				if(data.data[i].nilai_observasi==null)data.data[i].nilai_observasi=0;
				if(data.data[i].nilai_diri==null)data.data[i].nilai_diri=0;
				if(data.data[i].nilai_antarteman==null)data.data[i].nilai_antarteman=0;
				if(data.data[i].nilai_jurnal==null)data.data[i].nilai_jurnal=0;
				jumlahnilaiS=parseFloat(data.data[i].nilai_observasi)+parseFloat(data.data[i].nilai_diri)+parseFloat(data.data[i].nilai_antarteman)+parseFloat(data.data[i].nilai_jurnal);
				jumlahnilaiS=jumlahnilaiS/4;
				var rata2p=(jumlahnilaiP/100)*4;
				var rata2k=(jumlahnilaiK/100)*4;
				
				nilaip.push(parseFloat(rata2p.toFixed(2)));
				nilaik.push(parseFloat( rata2k.toFixed(2)));
				nilais.push(parseFloat( jumlahnilaiS.toFixed(2)));
				
			}
			
			var option={
				chart: {
					type: 'column',
					//renderTo: 'chart'
				},
				title: {
					text: 'Nilai Rata-rata Tiap Mapel'
				},
				xAxis: {
					categories: label,
					crosshair: true
				},
				yAxis: {
					min: 0
				},
				tooltip: {
					headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y}</b></td></tr>',
					footerFormat: '</table>',
					shared: true,
					useHTML: true
				},
				
				series: [{
					name: 'Nilai Pengetahuan',
					data: nilaip

				}, {
					name: 'Nilai Keterampilan',
					data: nilaik

				}, {
					name: 'Nilai Sikap',
					data: nilais

				}]
			};
			//console.log(option.series[0].data);
			//console.log(option.series[1].data);
			//console.log(option.series[2].data);
			//alert(label);
			$("#chart").highcharts(option);
			//var chart= new Highcharts.Chart(option);
        }
			$("#modalDetail").modal('show');

    }).fail(function(xhr,err){
		alert(err);
	});
	return false;
}
$(function(){
	$("body").data("nipEdit",'');
	$("body").data("isRefresh",false);
	$("#modalSetting [name='kd_kelas']").val('<?php echo $kd_kelas_value; ?>');
	$("#modalSetting [name='nis']").val('<?php echo $nis_value; ?>');
	$("#modalSetting [name='semester']").val('<?php echo $semester_value; ?>');
	$("#modalSetting [name='tahun_ajaran']").val('<?php echo $tahun_ajaran_value; ?>');
	$("#modalSetting [name='submit']").val('<?php echo $sudahdisubmit_value; ?>');
	$("#modalSetting select").selectpicker('refresh');
	$(".centangkabeh").click(function(){
		var x=$(this).is(":checked");
		if(x){
			$("#njir input[type='checkbox']").prop("checked",true);
		}else $("#njir input[type='checkbox']").prop("checked",false);
	});
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
	$("#modalSetting [name='kd_kelas']").change(function(e){
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
			url:'<?php echo site_url(); ?>/admin/nilai_praktek/getSiswaByKelas',
			type:'get',
			data:{kd_kelas:kd_kelas,all:all},
			beforeSend:function(){
				$("select[name='nis']").prop("disabled",true);
			}
		}).done(function(data){
			$("select[name='nis']").prop("disabled",false);
			var lbl;
			if(index==0)lbl='<option value="pilihsiswa">Pilih Siswa</option>';
			else lbl='';
			$("#modalSetting select[name='nis']").html(data);

			$("select[name='nis']").selectpicker('refresh');
		}).fail(function(xhr,er){
			alert(er);
			$("select[name='nis']").prop("disabled",false);
		});
	});

	$("#btnsubmitraport").click(function(){
		var x=$(".mbuhCheckbox");
		//alert(x.length);
		var id=[],nis=[],id_kelas=[],semester=[],tahun_ajaran=[],submit=[];
		$.each(x,function(){
			var idx=$(this).attr("id");
			var z=$(".data"+idx);
			id.push(z.eq(0).val());
			nis.push(z.eq(1).val());
			id_kelas.push(z.eq(2).val());
			semester.push(z.eq(3).val());
			tahun_ajaran.push(z.eq(4).val());
			if($(this).prop("checked"))submit.push(1);
			else submit.push(0);
			
		});
		//alert(mbuh);
		$.ajax({
			url:'<?php echo site_url("admin/submit_raport/submitRaport"); ?>',
			type:'post',
			data:{id:JSON.stringify(id),nis:JSON.stringify(nis),id_kelas:JSON.stringify(id_kelas),semester:JSON.stringify(semester),tahun_ajaran:JSON.stringify(tahun_ajaran),submit:JSON.stringify(submit)},
			dataType:'json'
		}).done(function(data){
			if(data.sukses){
				$("body").data("isRefresh",true);
				$("#logJudul").html("Sukses");
				$("#logBody").html(data.sukses);
				$("#modalLog").modal('show');
			}else{
				$("body").data("isRefresh",false);
				$("#logJudul").html("Error");
				$("#logBody").html(data.error);
				$("#modalLog").modal('show');
			}
		});
	});
	$("select[name='kd_kelas']#mbuh").change(function(){
		$("form#kelas").submit();
	});
	$('body').tooltip({selector:'[data-toggle="tooltip"]'});
	$("#modalLog").on("hidden.bs.modal",function(e){
		if($("body").data("isRefresh")==true)window.location.reload();
	});
	
});
</script>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Submit <small>Raport</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
							 <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Nilai</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Submit Raport
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<div class="row">
				<div class="col-lg-12">
				<?php 
				if($walikelas!=false){
				?>
								<div class="well">

				Wali Kelas : <?php echo $walikelas->kelas; ?><br>
				Jumlah Murid : <?php echo $walikelas->jumlahmurid; ?><br>
				</div>
				<?php }else if($hakAkses=="admin"){ ?>

		<form method="get" id="kelas" action="<?php echo site_url("admin/submit_raport/index"); ?>">
			 <div class="col-lg-4">
			 <select name="kd_kelas" id="mbuh" class="form-control selectpicker" data-live-search="true">
			 <option value="0">Pilih Kelas</option>
			 <?php 
			 foreach($semuakelas as $key=>$mbuh){
				 echo "<optgroup label=\"".$key."\">";
				 foreach($mbuh as $key=>$mbuh2)echo "<option value=\"".$key."\">".$mbuh2."</option>";
				 echo "</optgroup>";
			}
			 ?>
</select>
  </div><!-- /.col-lg-6 -->
  </form>
				<?php } ?>
				
				</div>
				</div>
				<div class="row spasiAtas">
				<div class="col-lg-2">
				<button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modalSetting"> Filter Data</button>
				</div>
				<div class="col-lg-6">
				 <form class="form-inline" id="gantiPaging" method="post" action="<?php echo site_url("admin/submit_raport/gantiPaging"); ?>">
			<div class="form-group">
				<label>Data per page</label>
			<input type="number" id="dataperpage" style="width:100px" value="<?php echo $perpage; ?>" name="perpage" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary"> Proses</button>
			</form></div>
			<form id="frmCari" method="get" action="<?php echo site_url("admin/submit_raport/index"); ?>">
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
                                        <th align="top">#</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                   		<th>Semester</th>
                                   		<th>Tahun Ajaran</th>
                                   		<th>Centang <input class="centangkabeh" type="checkbox"></th>
                                   		<th>Detail</th>
                                   </tr>
								  </thead>
                                <tbody id="njir">
                                   <?php
									$a=($startPage)+1;
								  foreach($dataNilai as $data){
										
										$checked=null;
										$id=null;
									   echo "<tr><td>$a</td><td>".$data->nis."</td><td>".$data->nama."</td><td>".$data->kelas."</td><td>".$data->semester2."</td><td>".$data->tahun_ajaran."</td>";
									   foreach($sudahdisubmit as $mbuh){
										   //print_r($mbuh);

										   if($mbuh->nis==$data->nis && $mbuh->id_kelas==$data->id_kelas && $mbuh->semester==$data->semester && $mbuh->tahun_ajaran==$data->tahun_ajaran){
											   $id=$mbuh->id;
											   if($mbuh->submit==1)$checked="checked";
												break;
											 
										   }
										  // else $checked=null;
									   }
									  //echo $checked;
									   	echo "<td><input $checked class=\"mbuhCheckbox\" id=\"".$a."\" type=\"checkbox\"></td>";
										echo "<input class=\"data".$a."\" type='hidden' value='".$id."' name='id'>";
										echo "<input class=\"data".$a."\" type='hidden' value='".$data->nis."' name='nis'>";
										echo "<input class=\"data".$a."\" type='hidden' value='".$data->id_kelas."' name='id_kelas'>";
										echo "<input class=\"data".$a."\" type='hidden' value='".$data->semester."' name='semester'>";
										echo "<input class=\"data".$a."\" type='hidden' value='".$data->tahun_ajaran."' name='tahun_ajaran'>";
									    ?>
										<td><a href="#" onclick="return detail('<?php echo $data->nis; ?>','<?php echo $data->semester; ?>','<?php echo $data->tahun_ajaran; ?>')"><span class="glyphicon glyphicon-eye-open"></span>	Detail</a></td></tr>
										<?php
									   $a++;
								   }
								   ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
					</div>
					
				<div class="row">
					<div class="col-lg-10">
					
					<?php echo $pagination; ?>
					</div>
					<div class="col-lg-2">
						<button type="button" class="btn btn-primary" id="btnsubmitraport">Submit Raport</button>

					</div>
				</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modalSetting">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
	<form method="post" action="<?php echo site_url("admin/submit_raport/gantiPaging"); ?>" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="x">Tampilkan Data Berdasarkan</h4>
      </div>
	  <div class="modal-body" id="xx">
	 <p>
	 <?php 
	if($hakAkses=="admin"){
		?>
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
	<?php } ?>
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
    <label>Semester</label>
	<select name="semester" class="form-control selectpicker gay" data-live-search="true">
	<option value="0">Semua Semester</option> 
	<option value="1">1 | Ganjil</option>
	<option value="2">2 | Genap</option>
	</select>
</div>
<div class="form-group">
    <label>Tahun Ajaran</label>
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
<div class="form-group">
    <label>Sudah disubmit</label>
	<select name="submit" class="form-control selectpicker gay" data-live-search="true">
	<option value="0">Belum dan Sudah</option> 
	<option value="1">Belum</option> 
	<option value="2">Sudah</option> 
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

<div class="modal fade " tabindex="-1" role="dialog" id="modalDetail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="detailJudul">...</h4>
      </div>
      <div class="modal-body" id="chart"  style="width:80%">
       
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