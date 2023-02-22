<?php
		session_start();
		$email=$_SESSION["email"];
		$psw=$_SESSION["password"];
		$autorizzato=$_SESSION["autorizzato"];
		
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
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Personale()'> Visualizza Personale</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Ticket()'>visualizza Prenotazioni Ticket</button></th>
					<th><button type='submit' style='margin:8px;' onclick='inserisci_Attività()'> Inserisci Attività</button></th>
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
				function visualizza_Utenti(){
					location.href='visualizza_Utenti.php';
				}
				function visualizza_Prenotazioni_Ticket(){
					location.href='visualizza_Prenotazioni_Ticket.php';
				}
				function inserisci_Attività(){
					location.href='inserisci_Attivit_.php';
				}
				function visualizza_Animali(){
					location.href='visualizza_Animali.php';
				}
			</script>
			<div id="visualizza">
				<h3 align='center' style="margin:15px;">Inserisci nuovi dipendenti</h3>
				<form id='inserisci' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' align='center'>
					<b style="margin: 8px;">Nome:</b>
					<input type="text" name="nome" style="margin-left:50px" size="20" maxlength="30">
					<br></br>
					<b style="margin: 8px;">Cognome:</b>
					<input type="text" name="cognome" style="margin-left:25px" size="20" maxlength="30">
					<br></br>
					<b style="margin: 8px;">Email:</b>
					<input type="text" name="email" style="margin-left:50px" size="20" maxlength="30">
					<br></br>
					<b style="margin: 8px;">Telefono:</b>
					<input type="text" name="telefono" style="margin-left:33px" size="20" maxlength="30">
					<br></br>
					<button type="submit" id="registra" style="margin:50px">registra</button>
				</form>
				<div id="visualizza" align='center'>
					<button type="submit" onclick="visualizza()">Visualizza elenco dipendenti</button>
				</div>
				<div  align='left' id='success' hidden=true>
					<h4 class='alert alert-notification'><strong>Notification!</strong> Registrazione eseguita con successo!
					<button type='submit' onclick='hide_reg()'>continua registrazioni</button>
					</h4>
				</div>
				<div  align='left' id='wrong' hidden=true>
					<h4 class='alert alert-warning'><strong>Warning!</strong> Inserisci tutti i valori!
					<button type='submit' onclick='hide_wrong()'>ok</button>
					</h4>
				</div>
				<div  align='left' id='duplicate' hidden=true>
					<h4 class='alert alert-warning'><strong>Warning!</strong> email già usata prova con un'altra!
					<button type='submit' onclick='hide_dup()'>ok</button>
					</h4>
				</div>
				<script>
				function hide_reg() {
					document.getElementById("success").hidden=true;
					document.getElementById("registra").hidden=false;
					location.href=location.href;
				}
				function hide_wrong() {
					document.getElementById("wrong").hidden=true;
					document.getElementById("registra").hidden=false;
				}
				function hide_dup() {
					document.getElementById("duplicate").hidden=true;
					document.getElementById("registra").hidden=false;
					location.href=location.href;
				}
				function visualizza() {
					location.href="visualizza_Personale.php";
				}
				</script>
				<?php
				$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
				$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$varN =htmlspecialchars($_REQUEST['nome']);
					$varC =htmlspecialchars($_REQUEST['cognome']);
					$varE =htmlspecialchars($_REQUEST['email']);
					$varT =htmlspecialchars($_REQUEST['telefono']);
					if($varN!="" & $varC!="" & $varE!="" & $varT!="")
					{
						$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
						$query ="INSERT INTO `utenti`  VALUES ('".$varE."','temporanea','".$varN."','".$varC."','".$varT."','a' )";			
						$res=mysqli_query($test, $query);
						mysqli_close($test);
						if($res==true){
							echo" <script> document.getElementById('registra').hidden=true;
									document.getElementById('success').hidden=false;
									document.getElementById('wrong').hidden=true;
									document.getElementById('wrong-cod').hidden=true;
									document.getElementById('elimina').hidden=true;</script>";
						}
						else{
							echo" <script> document.getElementById('registra').hidden=true;
									document.getElementById('duplicate').hidden=false;</script>";
						}
						
					}
					else{
						echo" <script> document.getElementById('wrong').hidden=false;</script>";
					}
				}
				?>
			</div>	
		</div>	
	</body>
</html>