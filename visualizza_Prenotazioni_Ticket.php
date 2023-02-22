<?php
		session_start();
		$email=$_SESSION["email"];	
?>
<html>
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
				width:auto; 
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
			<div align="right" id="area">
				<hr/>
				<button type='submit' style='margin:8px;' onclick="logout()"> logout </button>
			</div>
			<script>
                function logout(){              
                  location.href="logout.php";
              }
			</script>
		</div>
		<div id="menu">
			<hr/>
			<table id="menu" width="100%">
				<tr>
					<th><a href="index.php">HOME</a></th>
					<th><a href="animali.php">ANIMALI</a></th>
					<th><a href="attivit_.php">ATTIVITA' DEL PARCO</a></th>
					<th><a href="informazioni.php">INFO</a></th>
				</tr>
			</table>
			<hr/>
		</div>
		<div class="center">
			<table id="servizi">
				<tr>
					<th><button type='submit' style='margin:8px;' onclick='modifica()'> Modifica dati Personali</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Utenti()'>Visualizza Utenti</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Attività()'> Visualizza Prenotazioni Attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Personale()'>visualizza Personale</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Attività()'> Visualizza Attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Animali()'> Visualizza Animale</button></th>
					
				</tr>
			</table>
			<script>
				function modifica(){
					location.href='areaAdmin.php';
				}
				function visualizza_Personale(){
					location.href='visualizza_Personale.php';
				}
				function visualizza_Prenotazioni_Attività(){
					location.href='visualizza_Prenotazioni_Attivit_.php';
				}
				function visualizza_Utenti(){
					location.href='visualizza_Utenti.php';
				}
				function visualizza_Attività(){
					location.href='visualizza_Attivit__admin.php';
				}
				function visualizza_Animali(){
					location.href='visualizza_Animali.php';
				}
			</script>
			<div id="visualizza">
				<h3 align='center' style="margin:15px;">Ticket a giornata</h3>
				<table>
					<tr>
						<th><h3>Data</h3></th>
						<th><h3>Adulti</h3></th>
						<th><h3>Bambini</h3></th>
						<th><h3>Totale</h3></th>
					</tr>
					<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					$query="SELECT data, SUM(adulti) as numA, SUM(bambini) as numB from `ticket` group by data order by data";
					$result=mysqli_query($test, $query);
					mysqli_close($test);

					$num = mysqli_num_rows($result);
					$i=0;
					while($i < $num ){
						echo"<tr>";
						$row=mysqli_fetch_assoc($result);
						$varD=$row["data"];
						$varA=$row["numA"];
						$varB=$row["numB"];
						$varT=$varA+$varB;
						echo"
						<th><b>".$varD."</b></th>
						<th><b>".$varA."</b></th>
						<th><b>".$varB."</b></th>
						<th><b>".$varT."</b></th>
						</tr>";
						$i++;
					}
				?>
				</table>
			</div>
		</div>		
	</body>
</html>