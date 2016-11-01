<html>
<head><title>E-Raport</title>
	    <link href="<?php echo base_url()."assets/bootstrap/css/bootstrap.min.css"; ?>" rel="stylesheet">

	<script src="<?php echo base_url()."assets/jquery-1.11.2.min.js"; ?>"></script>
	</head>
	<body>

				<div class="container">

        <div class="row" ">
            <!-- isi berita -->
            <div class="col-md-12">

   
				
				<div class="row" id="njir">
				<div class="col-sm-6" id="section-to-print ">
				<table>
				<tr><td>Nama Sekolah</td><td>:</td><td>SMK Negeri 8 Semarang</td></tr>
				<tr><td>Alamat Sekolah</td><td>:</td><td>Jl. Pandanaran II/12 Semarang</td></tr>
				<tr><td>Nama Peserta Didik</td><td>:</td><td><?php echo strtoupper($header->nama); ?></td></tr>
				<tr><td>Nomor Induk/NISN</td><td>:</td><td><?php echo $header->nis." / ".$header->nisn; ?></td></tr>
				
				</table>
				</div>
				<div class="col-sm-6">
				<table>
				<tr><td>Kelas</td><td>:</td><td><?php echo  $header->prefix_kelas; ?></td></tr>
				<tr><td>Semester</td><td>:</td><td><?php echo $semester; ?></td></tr>
				<tr><td>Tahun Pelajaran</td><td>:</td><td><?php echo $tahun_ajaran; ?></td></tr>
				<tr><td>Paket Keahlian</td><td>:</td><td><?php echo $header->nama_full; ?></td></tr>
				</table>
				</div>
				<table>
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
			function konversi3($mbuh){
				switch($mbuh){
					case 4:$nilai="Menunjukkan sikap beriman dan bertaqwa, santun, demokratis, dapat bekerjasama, mampu menghargai karya orang lain, konsisten menunjukkan sikap objektif, jujur, rasa ingin tahu, percaya diri dan peduli lingkungan.";break;
					case 3:$nilai="Menunjukkan sikap beriman dan bertaqwa, santun, demokratis, dapat bekerjasama, mampu menghargai karya orang lain, konsisten menunjukkan sikap objektif, jujur, rasa ingin tahu, percaya diri tetapi masih kurang peduli lingkungan.";break;
					case 2:$nilai="Menunjukkan sikap beriman dan bertaqwa, santun, demokratis, dapat bekerjasama,  tetapi kurang mampu menghargai karya orang lain, serta kurang konsisten dalam menunjukkan sikap objektif, jujur, rasa ingin tahu, percaya diri dan peduli lingkungan.";break;
					case 1:$nilai="Belum menunjukkan sikap beriman dan bertaqwa, santun, demokratis, dapat bekerjasama, mampu menghargai karya orang lain, konsisten, menunjukkan sikap objektif, jujur, rasa ingin tahu,   percaya diri dan peduli lingkungan.";break;
					default:$nilai=$mbuh;
				}
				return $nilai;
			}
				?>
				</table>
				</div>
				</div>
				<table class="table table-striped table-hover table-bordered" style="margin-top:10px">
				<thead>
					<tr><td align="center" rowspan=3 colspan=2><br><br><strong>MATA PELAJARAN</strong><strong></td><td colspan=2><strong>Pengetahuan (KI 3)</strong><strong></td><td colspan=2><strong>Keterampilan (KI 4)<strong></td><td colspan=2><strong>Sikap Spiritual dan Sosial (KI 1 dan KI 2)<strong></td></tr>
					<tr><td><strong>Angka<strong></td><td><strong>Predikat<strong></td><td><strong>Angka<strong></td><td><strong>Predikat<strong></td><td><strong>Dalam Mapel<strong></td><td rowspan=2 align="center"><strong><br>Antar Mapel<strong></td></tr>
					<tr><td><strong>1-4<strong></td><td><strong>&nbsp;<strong></td><td><strong>1-4<strong></td><td><strong>&nbsp;<strong></td><td><strong>SB/B/C/K<strong></td></tr>
					<tr><td colspan=8><strong>Kelompok A (Wajib)</strong></td></tr>
					<?php 
					$jumlahnilai=0;
					$jumlahnilai2=0;
					$jumlahnilai3=0;
					$tot=0;
					$belum=true;
					if(isset($dataGay["A"])){
						$a=1;
						foreach($dataGay["A"] as $data){
							$tot++;
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
						$jumlahnilai+=$angka1;
						$jumlahnilai2+=$angka2;
						$jumlahnilai3+=$angka3;
						$huruf3=konversi2($mbuh);
							echo "<tr><td>$a</td><td>".$data->nama_mapel."<br>Nama Guru : ".$data->namaguru."</td><td>".$angka1."</td><td>".$huruf1."</td><td>".$angka2."</td><td>".$huruf2."</td><td>".$huruf3."</td>";
							if($belum){
								echo "<td rowspan='".($jumlahBaris+1)."' width='10%' id=\"konversiS\"></td>";
								$belum=false;
							}
							echo "</tr>";
							$a++;
						}
					}
					?>
					<tr><td colspan=7><strong>Kelompok B (Wajib)</strong></td>
					<?php
					if($belum){
								echo "<td rowspan='".($jumlahBaris+1)."' width='10%' id=\"konversiS\">asu</td>";
								$belum=false;
							}
							?></tr>
					<?php 
					
					if(isset($dataGay["B"])){
						$a=1;
						foreach($dataGay["B"] as $data){
							$tot++;
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
						$jumlahnilai+=$angka1;
						$jumlahnilai2+=$angka2;
						$jumlahnilai3+=$angka3;
						$huruf3=konversi2($mbuh);
							echo "<tr><td>$a</td><td>".$data->nama_mapel."<br>Nama Guru : ".$data->namaguru."</td><td>".$angka1."</td><td>".$huruf1."</td><td>".$angka2."</td><td>".$huruf2."</td><td>".$huruf3."</td>";
							echo "</tr>";
							$a++;
						}
					}
					?>
					<tr><td colspan=7><strong>Kelompok C (Peminatan)</strong></td></tr>
					<?php 
					if(isset($dataGay["C"])){
						$a=1;
						foreach($dataGay["C"] as $data){
							$tot++;
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
						$jumlahnilai+=$angka1;
						$jumlahnilai2+=$angka2;
						$jumlahnilai3+=$angka3;
						$huruf3=konversi2($mbuh);
							echo "<tr><td>$a</td><td>".$data->nama_mapel."<br>Nama Guru : ".$data->namaguru."</td><td>".$angka1."</td><td>".$huruf1."</td><td>".$angka2."</td><td>".$huruf2."</td><td>".$huruf3."</td>";
							
							echo "</tr>";
							$a++;
						}
					}
					$njir=4*$tot;
					$rata2Pengetahuan=($jumlahnilai/$njir)*4;
					$rata2Keterampilan=($jumlahnilai2/$njir)*4;
					$rata2Sikap=($jumlahnilai3/$njir)*4;
					$NilaiP=round($rata2Pengetahuan,2);
					$konversiP=konversi(round(($NilaiP/4)*10));
					$NilaiK=round($rata2Keterampilan,2);
					$konversiK=konversi(round(($NilaiK/4)*10));
					$konversiS=konversi3(round(($rata2Sikap)));
					echo '<script>$("#konversiS").html("'.$konversiS.'")</script>';
					//$tmp=round($rata2Pengetahuan);
					//$tmp2=round($rata2Keterampilan);					
					?>
					<tr><td>&nbsp;</td><td align="center"><strong>Jumlah Nilai</strong></td><td><?php echo $jumlahnilai; ?></td><td>&nbsp;</td><td><?php echo $jumlahnilai2; ?></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td><td align="center"><strong>Rata-rata</strong></td><td><?php echo $NilaiP; ?></td><td><?php echo $konversiP; ?></td><td><?php echo $NilaiK; ?></td><td><?php echo $konversiK; ?></td><td>&nbsp;</td><td>&nbsp;</td></tr>

				</thead>
				</table>
            </div>

            <!-- Sidebar-->
            

        </div>
        <!-- /.row -->
    </div>
	<script>window.print()</SCRIPT>
			</body>
			</html>