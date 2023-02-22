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
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Ticket()'>visualizza Prenotazioni Ticket</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Personale()'> Visualizza Personale</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Animali()'> Visualizza Animale</button></th>
					
				</tr>
			</table>
			<script>
				function modifica(){
					location.href='areaAdmin.php';
				}
				function visualizza_Utenti(){
					location.href='visualizza_Utenti.php';
				}
				function visualizza_Prenotazioni_Attività(){
					location.href='visualizza_Prenotazioni_Attivit_.php';
				}
				function visualizza_Prenotazioni_Ticket(){
					location.href='visualizza_Prenotazioni_Ticket.php';
				}
				function visualizza_Personale(){
					location.href='visualizza_Personale.php';
				}
				function visualizza_Animali(){
					location.href='visualizza_Animali.php';
				}
			</script>
			<div id="visualizza">
				<h3 align='center' style="margin:15px;">Elenco dipendenti</h3>
				<table>
					<tr>
						<th><h3>Codice</h3></th>
						<th><h3>Nome</h3></th>
						<th><h3>Responsabile</h3></th>
						<th><h3>email responsabile</h3></th>
						<th><h3>Prezzo adulto</h3></th>
						<th><h3>Prezzo bambino</h3></th>
					</tr>
					<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					$query="SELECT * from `attività`";
					$result=mysqli_query($test, $query);
					mysqli_close($test);

					$num = mysqli_num_rows($result);
					$i=0;
					while($i < $num ){
						echo"<tr> 
						<form method='post' action='".$_SERVER['PHP_SELF']."' align='center'>";
						$row=mysqli_fetch_assoc($result);
						$varC=$row["codice"];
						$varN=$row["nome"];
						$varR=$row["responsabile"];
						$varER=$row["email_resp"];
						$varPA=$row["prezzo_adulto"];
						$varPB=$row["prezzo_bambino"];
						echo"
						<th><b>".$varC."</b></th>
						<th><b>".$varN."</b></th>
						<th><b>".$varR."</b></th>
						<th><b>".$varER."</b></th>
						<th><b>".$varPA."</b></th>
						<th><b>".$varPB."</b></th>
						<th><input type='hidden' name='codice' value=".$varC."></th>
						<th><button type='submit'>elimina</button></th>
						</form>
						</tr>";
						$i++;
					}
				?>
				</table>
				<div  align='center' id='elimina' hidden=true>
					<h4 class='notification'><strong>Notification!</strong> Account eliminato con successo!
					<button type='submit' onclick='hide_not()'>ok</button>
					</h4>
				</div>
				<div align="center" id='inserisci'>
					<button style='margin:15px'; type='submit' onclick='inserisci_Attività()'>Inserisci Attività</button>
				</div>
				<script>
				function hide_not() {
					document.getElementById("elimina").hidden=true;
					location.href=location.href;
				}
				function inserisci_Attività() {
					location.href="inserisci_Attivit_.php";
				}
				</script>
				<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$varC = htmlspecialchars($_REQUEST['codice']);
						$query="DELETE FROM `immagini_attività` WHERE `codiceA` = '".$varC."'";
						$result=mysqli_query($test, $query);
						if($result==true){	
							$query="DELETE FROM `partecipa` WHERE `codiceA` = '".$varC."'";
							$result=mysqli_query($test, $query);
							if($result==true){				
								$query="DELETE FROM `attività` WHERE `codice` = '".$varC."'";
								$result=mysqli_query($test, $query);
								mysqli_close($test);
								if($result==true){											
									echo"
									<script> 
										document.getElementById('elimina').hidden=false;
										document.getElementById('wrong').hidden=true;
									</script>";
								}
							}
						}
					}
				?>
			</div>
		</div>		
	</body>
</html>