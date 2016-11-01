<script type="text/javascript">
function editPengumuman(kode){
	$("[name='id_forEdit']").val(kode);
	$("body").data("id_forEdit",kode);
	$.ajax({
		url:'<?php echo site_url('home/getdetailPengumuman'); ?>',
		type:'get',
		data:{id_pengumuman:kode},
		dataType:'json'
	}).done(function(data){
		$("#modalEdit [name='judul']").val(data.judul);
		$("#modalEdit [name='isi']").val(data.isi);
		$("#modalEdit").modal('show');
	}).fail(function(xhr){
		alert(xhr.responseText);
	});
	return false;
}
$(function(){
	$("#konfirmHapus").click(function(){
		$.ajax({
			url:'<?php echo site_url('home/hapusPengumuman'); ?>',
			type:'post',
			data:{id_forHapus:$("body").data("id_forEdit")},
			dataType:'json',
		}).done(function(data){
			$("#modalHapus").modal('hide');
			if(data.sukses){
				$("#logJudul").html("Sukses");
				$("#logBody").html("Hapus data sukses");
				$("#modalLog").modal('show');
				$("body").data("isRefresh",false);
				window.location='<?php echo site_url('home/pengumuman'); ?>';
			}else if(data.error){
				$("#logJudul").html("Error");
				$("#logBody").html("Hapus data gagal");
				$("#modalLog").modal('show');
				$("body").data("isRefresh",false);
			}else alert("Error tidak diketahui");
			
		}).fail(function(xhr){
			alert(xhr.responseText);
		});
	});
	$("body").data("isRefresh",false);
	$("#frmEdit").ajaxForm({
		dataType:'json',
		beforeSend:function(){
			$("button,input").prop("disabled",true);
		},
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
		error:function(xhr,error){
			$("button,input").prop("disabled",false);
			alert(error);
		}
	});
});
</script>
<div class="container">

        <div class="row">

            <!-- isi berita -->
            <div class="col-md-8 spasiBawah">
			<h2 class="page-header">
                    <?php echo htmlentities($konten->judul); ?>
					<?php 
			if($konten->id_user==$id_user)echo "<small><a href=\"#\" onclick=\"return editPengumuman('".addslashes($konten->id)."')\"><span class=\"glyphicon glyphicon-pencil\"></span></a></small>";
			?>
            </h2>
			<p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $konten->tanggal." by ".$konten->nama; ?> 
			
			</p><hr>
			<?php 
			$gambar=empty($konten->gambar)?null:"<img class=\"img-thumbnail\" src=\"".base_url($konten->gambar)."\"><br>";
			?>
			<?php echo $gambar; ?>
			<?php echo nl2br(htmlentities($konten->isi)); ?>


            </div>

            <!-- Sidebar-->
            <div class="col-md-4">

                <!-- Search -->
                <div class="well">
                    <h4>Cari Pengumuman</h4>
                    <form method="get" action="<?php echo site_url("home/pengumuman"); ?>">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
					</form>
                    <!-- /.input-group -->
					
                    <br> 

                <!-- Kategori berita -->
                    <h4>Input Pengumuman</h4>
                    <div class="row">
                        <div class="col-lg-12">
                        <form action="<?php echo site_url("home/submitpengumuman"); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="judul_pengumuman">Judul</label>
                                    <input type="text" class="form-control" name="judul" placeholder="Judul Pengumuman">
                                </div>
                                <div class="form-group">
                                    <label for="isi_pengumuman">Isi</label>
                                    <textarea name="isi" class="form-control" rows="3" placeholder="Isi pengumuman"></textarea>
                                </div>
								<div class="form-group">
                                    <label for="isi_pengumuman">Gambar</label>
                                    <input type="file" name="gambar">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                        </form>
                    </div>
                    </div>
                    <!-- /.row -->
					<div class="row">
					<?php echo $log; ?>
					</div>
                </div>
                

                <!-- Side Widget
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>-->

            </div>

        </div>
        <!-- /.row -->
    </div>

	<div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
  <div class="modal-dialog">
    <div class="modal-content">
	<form id="frmEdit" method="post" action="<?php echo site_url("home/editPengumuman"); ?>" enctype="multipart/form-data">
	<input type="hidden" name="id_forEdit" value="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Pengumuman</h4>
      </div>
      <div class="modal-body">
        <p>
		<div class="form-group">
                                    <label for="judul_pengumuman">Judul</label>
                                    <input type="text" class="form-control" name="judul" placeholder="Judul Pengumuman">
                                </div>
                                <div class="form-group">
                                    <label for="isi_pengumuman">Isi</label>
                                    <textarea name="isi" class="form-control" rows="3" placeholder="Isi pengumuman"></textarea>
                                </div>
								<div class="form-group">
                                    <label for="isi_pengumuman">Gambar</label>
                                    <input type="file" name="gambar">
                                </div>
                             </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus">Hapus</button>
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
        <h4 class="modal-title" id="modalHapusJudul">Konfirmasi Hapus</h4>
      </div>
	  <div class="modal-body" id="modalHapusBody">
	  Hapus pengumuman ?
	  </div>
	  <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" id="konfirmHapus">Hapus</button>
      </div>
      </div>
    </div>
  </div>
</div>