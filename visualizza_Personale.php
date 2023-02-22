<?php
		session_start();
		$email=$_SESSION["email"];
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
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Attività()'> Visualizza Prenotazioni Attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Ticket()'>visualizza Prenotazioni Ticket</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Attività()'> Visualizza Attività</button></th>
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
				function visualizza_Attività(){
					location.href='visualizza_Attivit__admin.php';
				}
				function visualizza_Animali(){
					location.href='visualizza_Animali.php';
				}
			</script>
			<div id="visualizza" hidden=true>
				<h3 align='center' style="margin:15px;">Elenco dipendenti</h3>
				<table>
					<tr>
						<th><h3>Email</h3></th>
						<th><h3>Nome</h3></th>
						<th><h3>Cognome</h3></th>
						<th><h3>Telefono</h3></th>
					</tr>
					<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					$query="SELECT * from `utenti` where email!='".$email."' and priority='a'";
					$result=mysqli_query($test, $query);
					mysqli_close($test);

					$num = mysqli_num_rows($result);
					$i=0;
					while($i < $num ){
						echo"<tr> 
						<form method='post' action='".$_SERVER['PHP_SELF']."' align='center'>";
						$row=mysqli_fetch_assoc($result);
						$varE=$row["email"];
						$varN=$row["nome"];
						$varC=$row["cognome"];
						$varT=$row["telefono"];
						echo"
						<th><b>".$varE."</b></th>
						<th><b>".$varN."</b></th>
						<th><b>".$varC."</b></th>
						<th><b>".$varT."</b></th>
						<th><input type='hidden' name='mail' value=".$varE."></th>
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
					<button style='margin:15px'; type='submit' onclick='inserisci_dipendenti()'>Inserisci dipendenti</button>
				</div>
				<script>
				function hide_not() {
					document.getElementById("elimina").hidden=true;
					location.href=location.href;
				}
				function inserisci_dipendenti() {
					location.href="inserisci_dipendenti.php";
				}
				</script>
				<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$varE = htmlspecialchars($_REQUEST['mail']);
						$query="DELETE FROM `utenti` WHERE `email` = '".$varE."'";
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
				?>
			</div>
		
			<div id="autorized" hidden=true>
				<h3 align=center> Visualizza Personale </h3>
				<h4 align=center>Solo personale autorizzato può visualizzare i dati del personale!</h4>
                <div align=center>
                <button type="submit" onclick="invia()">invia codice di accesso</button>
                </div>
                <script>
                	function invia(){
                    	<?php
                    	$codAccesso="a5r1sr46";
                        $user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
                        $test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
                        $query ="select cognome from `utenti` where email='".$email."'";	
                        $r=mysqli_query($test, $query);
                        $row=mysqli_fetch_assoc($r);
                        $cognome=$row["cognome"];
                        $subject="Codice Accesso";
                        $content="Salve Gentile ".$cognome.", \n Questo è il codice che deve inserire per poter visualizzare il personale dello zoo: ".$codAccesso;
                        $header="From: 'Zoo Torino' <info.zootorino@gmail.com> \r\n";
                        $header .= "Reply-To: info.zootorino@gmail.com\r\n";
                        $header .= "X-Mailer: PHP/" . phpversion();
                        mail($email,$subject, $content, $header);
                        ?>
                    }
                </script>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" align="center" style="margin: 20px;">
				<b>Inserisci codice di autenticazione:</b>
				<input type="password" name="codice">
				<button type="submit" id="controlla" >autorizza</button>
				</form>
				<div  align='center' id='wrong-cod' hidden=true>
					<h4 class='alert alert-warning'><strong>Warning!</strong> Inserisci codice!
					<button type='submit' onclick='hide()'>ok</button>
					</h4>
				</div>
				<?php
                $user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
				$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$codice=htmlspecialchars($_REQUEST['codice']);
					if($autorizzato==false){
						if($codice!=""){
							if($codice==$codAccesso){
								$_SESSION["autorizzato"]=true;
								echo"<script>
									document.getElementById('visualizza').hidden=false;
									document.getElementById('autorized').hidden=true;
								</script>";
							}
						}
						else{
								echo"<script>
									document.getElementById('wrong-cod').hidden=false;
									document.getElementById('controlla').hidden=true;
								</script>";
						}
					}
				}
				if($autorizzato==true){
					echo"<script>document.getElementById('autorized').hidden=true;
					document.getElementById('visualizza').hidden=false;</script>";
				}
				else
				{
					echo"<script>document.getElementById('autorized').hidden=false;
					document.getElementById('visualizza').hidden=true;</script>";
				}
				?>
				<script>
				function hide() {
					document.getElementById("wrong-cod").hidden=true;
					document.getElementById("controlla").hidden=false;
					document.getElementById("notification").hidden=true;
				}
				</script>
			</div>
		</div>		
	</body>
</html>