<div id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
			<?php 
			$x=ceil(count($konten)/3);
			for($i=0; $i<$x; $i++){
				echo '<li data-target="#myCarousel" data-slide-to="'.$i.'" '.($i==0?'class="active"':null).' "></li>';
			}
			?>
        </ol>

<!-- Wrapper for Slides -->
        <div id="work">
            <div class="news">
                <div class="container">
                    <div class="row">
                    <h3><a href="#"><i class="fa fa-newspaper-o fa-2x fa-fw"></i> Latest News </a></h3>
                        <div class="carousel-inner">
							<?php 
							$a=0;
							$first=true;
							$total=count($konten);
							$mbuh='';
							while($a<$total){
								if($first){
									$mbuh.='<div class="item active">';
									$first=false;
								}else $mbuh.='<div class="item">';
								$mbuh.='<div class="fill">';
								$i=0;
								while($a<$total && $i<3){
									$mbuh.='<div class="col-lg-4"><div class="title">';
									$mbuh.='<a href="'.site_url().'/home/bacapengumuman/'.$konten[$a]->id.'"><h4 style="color: #3b627c;">'.$konten[$a]->judul.'</h3></a>';
									$mbuh.='</div>';
									$gambar=!empty($konten[$a]->gambar)?base_url($konten[$a]->gambar):base_url("assets/images/place.png");
									$mbuh.='<img width="360px" height="150px" src="'.$gambar.'"><hr>';
									$mbuh.='<p class="t2">'.substr($konten[$a]->isi,0,40).(strlen($konten[$a]->isi)>40?".....":null).'</p>';
									$mbuh.='</div>';
									$i++;
									$a++;
								}
								$mbuh.="</div></div>";
								//$a++;
							}
							echo $mbuh;
							?>
                            <!--
							<div class="item active">
                                <div class="fill">
                                     <div class="col-lg-4">
                                        <div class="title">
                                            <a href="#"><h4 style="color: #3b627c;">dd</h3></a>
                                        </div>
                                        <img class="img-responsive" src="http://placehold.it/900x300" alt=""><hr>
                                        <p class="t2"> dd </p>
                                    </div>
                                                                        <div class="col-lg-4">
                                        <div class="title">
                                            <a href="#"><h4 style="color: #3b627c;">cek</h3></a>
                                        </div>
                                        <img class="img-responsive" src="http://placehold.it/900x300" alt=""><hr>
                                        <p class="t2"> cek </p>
                                    </div>
                                                                        <div class="col-lg-4">
                                        <div class="title">
                                            <a href="#"><h4 style="color: #3b627c;">cek</h3></a>
                                        </div>
                                        <img class="img-responsive" src="http://placehold.it/900x300" alt=""><hr>
                                        <p class="t2"> cek </p>
                                    </div>
                                  </div>
                            </div>

                            <div class="item">
                                <div class="fill">
                                                                            <div class="col-lg-4">
                                        <div class="title">
                                            <a href="#"><h4 style="color: #3b627c;">coba coba</h3></a>
                                        </div>
                                        <img class="img-responsive" src="http://placehold.it/900x300" alt=""><hr>
                                        <p class="t2"> coba coba </p>
                                    </div>
                                                                        <div class="col-lg-4">
                                        <div class="title">
                                            <a href="#"><h4 style="color: #3b627c;">Coba Pengumuman Baru</h3></a>
                                        </div>
                                        <img class="img-responsive" src="http://placehold.it/900x300" alt=""><hr>
                                        <p class="t2"> Iya coba </p>
                                    </div>
                                                                        <div class="col-lg-4">
                                        <div class="title">
                                            <a href="#"><h4 style="color: #3b627c;">Penilaian</h3></a>
                                        </div>
                                        <img class="img-responsive" src="http://placehold.it/900x300" alt=""><hr>
                                        <p class="t2"> Hari ini penilaian </p>
                                    </div>
                                                                    </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div><!--work-->
<!-- Controls -->
<a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
</a>
<a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
</a>
</div><!--carousel-->

<div class="services">
	<div class="container">
	   <div class="row">
		  <h3><a href="#"><i class="fa fa-newspaper-o fa-2x fa-fw"></i> Features </a></h3>
          <!--<h1><strong>Features</strong></h1><br>-->
              <!--<div class="section-heading">
                <p>Est te congue scaevola comprehensam. No pri simul decore, in partem electram voluptatibus vel esse facer.</p><br>
    		  </div>-->
		</div>
		<div class="row">
        <center>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <i class="fa fa-code fa-5x"></i>
				<h4>Tugas</h4>
		      	<p>Lorem ipsum dolor sit amet, ut decore iracundia urbanitas sit.</p>
				<a class="btn btn-primary">More</a>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" data-wow-delay="0.3s">
				<i class="fa fa-cog fa-5x"></i>
				<h4>Nilai</h4>
			    <p>Lorem ipsum dolor sit amet, ut decore iracundia urbanitas sit.</p>
				<a class="btn btn-primary">More</a>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" data-wow-delay="0.5s">
				<i class="fa fa-desktop fa-5x"></i>
				<h4>Jadwal</h4>
				<p>Lorem ipsum dolor sit amet, ut decore iracundia urbanitas sit.</p>
				<a class="btn btn-primary">More</a>
			</div>
        </center>
        </div>
	</div>
</div>