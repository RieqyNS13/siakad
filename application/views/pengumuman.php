<div class="container">

        <div class="row">
            <!-- isi berita -->
            <div class="col-md-8">

                <h1 class="page-header">
                    <?php echo $judulAtas; ?>
                </h1>
				
				<?php
					echo $logAtas;
				foreach($konten as $konten2){
					echo "<h2><a href=\"".site_url("home/bacaPengumuman/".$konten2->id)."\">".$konten2->judul."</a></h2>";
					echo "<p><span class=\"glyphicon glyphicon-time\"></span> Posted on ".$konten2->tanggal." by ".$konten2->nama." </p><hr>";
					$gambar=empty($konten2->gambar)?base_url("assets/images/place.png"):base_url($konten2->gambar);
					echo "<img width=\"700\px\" height=\"300px\" src=\"".$gambar."\"><hr>";
					echo "<p>".substr($konten2->isi,0,66).(strlen($konten2->isi)>66?"...................":null)."</p>"; 
					echo "<a class=\"btn btn-primary\" href=\"".site_url("home/bacaPengumuman/".$konten2->id)."\">Read More <span class=\"glyphicon glyphicon-chevron-right\"></span></a>";
				}
				?>
                               <!-- <h2>
                    <a href="#">ass</a>
                </h2>
                <p><span class="glyphicon glyphicon-time"></span> Posted on 2016-02-06 04:26:45 by Rifqon Muzakki </p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p>ass</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>-->
                              

                

                <!-- Pager -->
				<div id="paging" class="spasiBawah">
				<?php echo $pagination; ?>
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