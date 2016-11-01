<!-- Page Heading -->
<style type="text/css">
.col-sm-6.punyaNip {
	//width: 33.66666667%
}
</style>
<script>
$(".navbar-collapse li").removeClass("active");
$("#<?php echo $idAktif; ?>").addClass("active");

$(function(){
	$("body").data("nipEdit",'');
	$("body").data("isRefresh",false);
	
	$("#modalLog").on("hidden.bs.modal",function(e){
		if($("body").data("isRefresh")==true)window.location.reload();
	});
	$("#dataTable li").hide();
	 $('#dataTable .mbuh').click(function(e) {
		 e.preventDefault();
		 var val=$(this).find("input").val();
		 if(val=='1'){
			 $(this).find('li').hide('slow');
			 $(this).find("input").val('0');
			 
		 }else{
			  $(this).find('li').show('slow');
			  $(this).find("input").val('1');
		 }
		 
		 //console.log('cok');
           
        });
		
	
});
</script>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Backup <small>Data</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url()."/admin/index"; ?>">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Backup
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php 
				if($hak_akses==="admin"){
				?>
                <div class="row">
				<div class="col-lg-12">
				<h3>List Table dan Column</h3>
				<div class="well" id="dataTable">
				<?php 
				$a=1;
				foreach($tables as $key=>$table){
					echo "<span class=\"mbuh\">
					<input type=\"hidden\" value=\"0\">
					<a href=\"#\">$a. $key <span class=\"caret\"></span></a><br>";
					foreach($table as $column){
						echo "<li>".$column."</li>";
					}
					echo "</span>";
					$a++;
				}
				?>
				</div>
				</div>
				</div>
				<div class="row spasiAtas">
					<div class="col-sm-6">
					<a href="<?php echo site_url("admin/backup/get"); ?>"><button class="btn btn-primary"><i class="fa fa-undo"></i> Backup Database</button></a>
					</div>
				</div>
				
				<?php } ?>
				
			

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