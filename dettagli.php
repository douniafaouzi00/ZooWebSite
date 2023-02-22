<?php
		session_start();
		$email=$_SESSION["email"];
		$priority=$_SESSION["priority"];
		$url=$_SERVER['REQUEST_URI'];
		$cod=explode("=",$url);
?>
<htlm>
	<head>
		<meta name="Dounia Faouzi 29122" content="zoo"/>
		<title> ZOO </title>
		<style>
			body {
				align: center;
				display: block;
				margin: 10px 150px;
				border:1px solid;
				background-color:#90EE90;
				width: 1000;
				height:auto;
			}
			
			.alert-warning{
				width:500px; 
				height:25px; 
				margin:5px; 
				border:1px solid; 
				border-color: red;
				align: center;
			}
			
			table{
				width:100%;
				align: center;
			}
			th{
				align: center;
			}
		</style>
	</head>
	<body>
		<header>
			<img src="logo.png" align=left width="70" height="50" alt="Giardino Zoologico" />
			<img src="logo.png" align=right width="70" height="50" alt="Giardino Zoologico" />
			<h1 align=center style="margin-top:10px">ZOO</h1>
		</header>
		<div id="authenticated">
		<hr/>
			<div hidden=true align="right" id="area">
			<?php
			if($priority=="a")
			{
				echo"<button type='submit' style='margin:8px;' onclick='areaAdmin()'> AREA ADMIN </button>";
			}
			else{
				echo"<button type='submit' style='margin:8px;' onclick='areaUtenti()'> AREA UTENTE </button>";
			}
			?>
			<button type='submit' style='margin:8px;' onclick="logout()"> logout </button>
			</div>
			<script>
				function areaAdmin() {
					location.href='areaAdmin.php';
				}							
				function areaUtenti() {
					location.href='areaUtenti.php';
				}
                function logout(){              
                  location.href="logout.php";
              }
			</script>
			<div align="right" style='margin:8px;' id="prenota" hidden=true>
				<?php echo "<button type='submit' style='margin:8px;'><a href='prenota_attivit_.php?cod=".$cod[1]." ' align='right'>Prenota attività</a></button>"; ?>
			</div>
			<div align="right" style='margin:8px;' id="registra" hidden=true>
				<label> Per poter prenotare un'attività registrati; </label>
				<button type='submit' style='margin:8px;'><a href='registrazione.php'> registrati</a> </button>
			</div>
			<?php
			if($email!="guest"){
				echo"<script>
					document.getElementById('area').hidden=false;
					document.getElementById('prenota').hidden=false;
					document.getElementById('registra').hidden=true;
				</script>";
			}
			else{
				echo"<script>
					document.getElementById('area').hidden=true;
					document.getElementById('registra').hidden=false;
					document.getElementById('prenota').hidden=true;
					document
					</script>";
			}
			?>
		</div>
		<div id="menu">
			<hr/>
			<table id="menu" width="100%">
				<tr>
					<th><a href="index.php">HOME</a></th>
					<th><a href="attivit_.php">ATTIVITA' DEL PARCO</a></th>
					<th><a href="animali.php">ANIMALI</a></th>
					<th><a href="informazioni.php">INFO</a></th>
				</tr>
			</table>
			<hr/>
		</div>
		<div class="center" align="center"> 
		<?php
			$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
			$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
			$query ="SELECT * from attività a where a.codice='".$cod[1]."'";
			$result=mysqli_query($test, $query);
			$row=mysqli_fetch_assoc($result);
			$nome=$row["nome"];
			$desc=$row["descrizione"];
			$resp=$row["resposabile"];
			$email=$row["email"];
			$prezzoA=$row["prezzo_adulto"];
			$prezzoB=$row["prezzo_bambino"];
			echo"<h1>".$nome."<h1>
			<p style='font-size:15px; margin:10px'>".$desc."<p>
			<h4 align='left' style='margin: 8px'> Prezzo Adulto: ".$prezzoA."</h4>
			<h4 align='left' style='margin: 8px'> Prezzo Bambino: ".$prezzoB."</h4>
			<h4 align='right' style='margin: 8px'> Responsabile: ".$resp."</h4>
			<h4 align='right' style='margin: 8px'> Email: ".$email."</h4>";
			
			$query ="SELECT * from immagini_attività i where i.codiceA='".$cod[1]."' ";
			$result=mysqli_query($test, $query);
			$num=mysqli_num_rows($result);
			if($num!=0){
				$i=0;
				while($i < $num ){
					$row=mysqli_fetch_assoc($result);
					$immagine=$row["immagine"];
					echo"<img src=".$immagine." alt=".$nome." width='200' height='110' align='center' style='margin: 10px'/>";
					$i++;
				}
			}
			
			$query ="SELECT * from animale a, partecipa p where p.animale=a.codice and p.codiceA='".$cod[1]."' group by a.codice";
			$result=mysqli_query($test, $query);

			$num=mysqli_num_rows($result);
			
			if($num!=0){
				$i=0;
				echo"<h3> animali coinvolti </h3>";
				echo"<table>";
				echo"<tr>";
				while($i < $num ){
					$row=mysqli_fetch_assoc($result);
					$nome=$row["nome"];
					echo"<th><h3>".$nome."</h3></th>";
					$i++;
				}
				echo"</tr>";
				$j=0;
				echo"<tr>";
				$result=mysqli_query($test, $query);
				while($j < $num ){
					$row=mysqli_fetch_assoc($result);
					$nome=$row["nome"];
					$immagine=$row["immagine"];
					echo "<th><img src=".$immagine." alt=".$nome." width='90' height='90' align='center' style='margin: 10px'/> </th>";
					$j++;
				}			
				echo"</tr>";
				 echo" </table>";
			}
			else{
				echo"<h3>Sono presenti tutti gli animali</h3>";
			}
			mysqli_close($test);
		?>
		</div>
	</body>
</html>