<div class="container">

        <div class="row" style="margin-top:-50px">
            <!-- isi berita -->
            <div class="col-md-6">

                <h1 class="page-header">
                    Raport
                </h1>
				
				
                               <!-- <h2>
                    <a href="#">ass</a>
                </h2>
                <p><span class="glyphicon glyphicon-time"></span> Posted on 2016-02-06 04:26:45 by Rifqon Muzakki </p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p>ass</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>-->
                           <form class="form-horizontal" method="post" action="<?php echo site_url("home/cetakraport"); ?>"		>
  <div class="form-group">
    <label class="col-sm-4 control-label">Pilih yang Akan Ditampilkan</label>
    <div class="col-sm-8">
	<select name="pilihan" class="form-control selectpicker">
	  	  <?php echo $pilihan; ?>

	  </select>
  </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      <button type="submit" class="btn btn-primary">Tampil Raport</button>
    </div>
  </div>
</form>

                

                <!-- Pager -->
				<div id="paging" class="spasiBawah">
				</div>
                <!--<ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>-->

            </div>

            <!-- Sidebar-->
            

        </div>
        <!-- /.row -->
    </div>