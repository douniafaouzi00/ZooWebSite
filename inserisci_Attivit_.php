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
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Personale()'>Visualizza Personale</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Attività()'> Visualizza Prenotazioni Attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Ticket()'>visualizza Prenotazioni Ticket</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Animali()'> visualizza Animali</button></th>
					
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
				function visualizza_Animali(){
					location.href='visualizza_Animali.php';
				}
				function visualizza_Personale(){
					location.href='visualizza_Personale.php';
				}
			</script>
			<div id="visualizza">
				<h3 align='center' style="margin:15px;">Inserisci Attività</h3>
				<form id='inserisci' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' align='center'>
					<b style="margin: 8px;">Codice:</b>
					<input type="text" name="codice" style="margin-left:50px" size="20" maxlength="30">
					<br></br>
					<b style="margin: 8px;">Nome:</b>
					<input type="text" name="nome" style="margin-left:55px" size="20" maxlength="30">
					<br></br>
					<b style="margin: 8px;">Responsabile:</b>
					<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					echo"<select name='responsabile'>";
						$query ="SELECT * from `utenti` where priority='a'";
						$res=mysqli_query($test, $query);
						$n=mysqli_num_rows($res);
						$j=0;
						while($j < $n ){
							$r=mysqli_fetch_assoc($res);
							$email=$r["email"];
							$nome=$r["nome"];
							$cognome=$r["cognome"];
							echo"<option value=".$email.">".$nome." ".$cognome."</option>";
							$j++;
						}
						echo"
						</select>";
					?>
					<br></br>
					<b style="margin: 8px;">Prezzo adulto:</b>
					<input type="text" name="prezzo_adulto" style="margin-left:50px" size="20" maxlength="30">
					<br></br>
					<b style="margin: 8px;">Prezzo bambino:</b>
					<input type="text" name="prezzo_bambino" style="margin-left:50px" size="20" maxlength="30">
					<br></br>
					<b style="margin: 8px;">Descrizione:</b>
					<input type="text" name="descrizione" style="margin-left:50px; width:500px; height:200px" >
					<br></br>
					<b style="margin: 8px;">Immagini:</b>
					<input type="text" name="immagine1" style="margin-left:50px;" >
					<input type="text" name="immagine2" style="margin-left:50px;" >
					<input type="text" name="immagine3" style="margin-left:50px;" >
					<input type="text" name="immagine4" style="margin-left:143px;" >
					<input type="text" name="immagine5" style="margin-left:50px;" >
					<input type="text" name="immagine6" style="margin-left:50px;" >
					<br></br>
					<b style="margin: 8px;">Animali:</b>
					<?php
					echo"<select name='animale1'>
					<option value='none'>animale</option>";
						$query ="SELECT * from `animale`";
						$res=mysqli_query($test, $query);
						$n=mysqli_num_rows($res);
						$j=0;
						while($j < $n ){
							$r=mysqli_fetch_assoc($res);
							$codice=$r["codice"];
							$nome=$r["nome"];
							echo"<option value=".$codice.">".$nome."</option>";
							$j++;
						}
						echo"
						</select>
						<select name='animale2'>
						<option value='none'>animale</option>";
						$query ="SELECT * from `animale`";
						$res=mysqli_query($test, $query);
						$n=mysqli_num_rows($res);
						$j=0;
						while($j < $n ){
							$r=mysqli_fetch_assoc($res);
							$codice=$r["codice"];
							$nome=$r["nome"];
							echo"<option value=".$codice.">".$nome."</option>";
							$j++;
						}
						echo"
						</select>
						<select name='animale3'>
						<option value='none'>animale</option>";
						$query ="SELECT * from `animale`";
						$res=mysqli_query($test, $query);
						$n=mysqli_num_rows($res);
						$j=0;
						while($j < $n ){
							$r=mysqli_fetch_assoc($res);
							$codice=$r["codice"];
							$nome=$r["nome"];
							echo"<option value=".$codice.">".$nome."</option>";
							$j++;
						}
						echo"
						</select>
						<select name='animale4'>
						<option value='none'>animale</option>";
						$query ="SELECT * from `animale`";
						$res=mysqli_query($test, $query);
						$n=mysqli_num_rows($res);
						$j=0;
						while($j < $n ){
							$r=mysqli_fetch_assoc($res);
							$codice=$r["codice"];
							$nome=$r["nome"];
							echo"<option value=".$codice.">".$nome."</option>";
							$j++;
						}
						echo"
						</select>
						<select name='animale5'>
						<option value='none'>animale</option>";
						$query ="SELECT * from `animale`";
						$res=mysqli_query($test, $query);
						$n=mysqli_num_rows($res);
						$j=0;
						while($j < $n ){
							$r=mysqli_fetch_assoc($res);
							$codice=$r["codice"];
							$nome=$r["nome"];
							echo"<option value=".$codice.">".$nome."</option>";
							$j++;
						}
						echo"
						</select>
						<select name='animale6'>
						<option value='none'>animale</option>";
						$query ="SELECT * from `animale`";
						$res=mysqli_query($test, $query);
						$n=mysqli_num_rows($res);
						$j=0;
						while($j < $n ){
							$r=mysqli_fetch_assoc($res);
							$codice=$r["codice"];
							$nome=$r["nome"];
							echo"<option value=".$codice.">".$nome."</option>";
							$j++;
						}
						echo"
						</select>";
						?>
					<br></br>
					<button type="submit" id="registra" style="margin:15px">registra</button>
				</form>
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
					<h4 class='alert alert-warning'><strong>Warning!</strong> codice già usato prova con un'altro!
					<button type='submit' onclick='hide_dup()'>ok</button>
					</h4>
				</div>
				<div  align='center' id='visualizza_Attività'>
					<button style="margin:15px" type='submit' onclick='visualizza_Attività()'>Visualizza Attività</button>
					</h4>
				</div>
				<script>
				function visualizza_Attività() {
					location.href="visualizza_Attivit__admin.php";
				}
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
				</script>
				<?php
				$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
				$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$varC =htmlspecialchars($_REQUEST['codice']);
					$varN =htmlspecialchars($_REQUEST['nome']);
					$varR =htmlspecialchars($_REQUEST['responsabile']);
					$varPA =htmlspecialchars($_REQUEST['prezzo_adulto']);
					$varPB =htmlspecialchars($_REQUEST['prezzo_bambino']);
					$varD =htmlspecialchars($_REQUEST['descrizione']);
					$varI1 =htmlspecialchars($_REQUEST['immagine1']);
					$varI2 =htmlspecialchars($_REQUEST['immagine2']);
					$varI3 =htmlspecialchars($_REQUEST['immagine3']);
					$varI4 =htmlspecialchars($_REQUEST['immagine4']);
					$varI5 =htmlspecialchars($_REQUEST['immagine5']);
					$varI6 =htmlspecialchars($_REQUEST['immagine6']);
					$varA1 =htmlspecialchars($_REQUEST['animale1']);
					$varA2 =htmlspecialchars($_REQUEST['animale2']);
					$varA3 =htmlspecialchars($_REQUEST['animale3']);
					$varA4 =htmlspecialchars($_REQUEST['animale4']);
					$varA5 =htmlspecialchars($_REQUEST['animale5']);
					$varA6 =htmlspecialchars($_REQUEST['animale6']);
					if($varC!="" & $varN!="" & $varPA!="" & $varPB!="" & $varD!="" )
					{
						$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
						$query ="select nome, cognome from `utenti` where email='".$varR."'";			
						$res=mysqli_query($test, $query);
						$r=mysqli_fetch_assoc($res);
						$nome=$r["nome"];
						$cognome=$r["cognome"];
						$query ="INSERT INTO `attività`  VALUES ('".$varC."','".$varN."','".$varD."','".$nome." ".$cognome."','".$varR."','".$varPA."','".$varPB."' )";
						$res=mysqli_query($test, $query);
						if($res==true){
							if($varI1!="" or $varI2!="" or $varI3!="" or $varI4!="" or $varI5!="" or $varI6!="" ){
								$query ="select count(*) as conteggio from `immagini_attività`";
								$res=mysqli_query($test, $query);
								$r=mysqli_fetch_assoc($res);
								$n=$r["conteggio"];
								$n++;
								if($varI1!=""){
									$query="INSERT INTO `immagini_attività`  VALUES ('i".$n++."','".$varC."','".$varI1."');";
									mysqli_query($test, $query);
								}
								if($varI2!=""){
									$query="INSERT INTO `immagini_attività`  VALUES ('i".$n++."','".$varC."','".$varI2."');";
									mysqli_query($test, $query);
								}
								if($varI3!=""){
									$query="INSERT INTO `immagini_attività`  VALUES ('i".$n++."','".$varC."','".$varI3."');";
									mysqli_query($test, $query);
								}
								if($varI4!=""){
									$query="INSERT INTO `immagini_attività`  VALUES ('i".$n++."','".$varC."','".$varI4."');";
									mysqli_query($test, $query);
								}
								if($varI5!=""){
									$query="INSERT INTO `immagini_attività`  VALUES ('i".$n++."','".$varC."','".$varI5."');";
									mysqli_query($test, $query);
								}
								if($varI6!=""){
									$query="INSERT INTO `immagini_attività`  VALUES ('i".$n++."','".$varC."','".$varI6."');";
									mysqli_query($test, $query);
								}
							}
							if($varA1!="animale" or $varA2!="animale" or $varA3!="animale" or $varA4!="animale" or $varA5!="animale" or $varA6!="animale" ){
								if($varA1!="animale"){
									$query="INSERT INTO `partecipa`  VALUES ('".$varC."','".$varA1."');";
									mysqli_query($test, $query);
								}
								if($varA2!="animale"){
									$query="INSERT INTO `partecipa`  VALUES ('".$varC."','".$varA2."');";
									mysqli_query($test, $query);
								}
								if($varA3!="animale"){
									$query="INSERT INTO `partecipa`  VALUES ('".$varC."','".$varA3."');";
									mysqli_query($test, $query);
								}
								if($varA4!="animale"){
									$query="INSERT INTO `partecipa`  VALUES ('".$varC."','".$varA4."');";
									mysqli_query($test, $query);
								}
								if($varA5!="animale"){
									$query="INSERT INTO `partecipa`  VALUES ('".$varC."','".$varA5."');";
									mysqli_query($test, $query);
								}
								if($varA1!="animale"){
									$query="INSERT INTO `partecipa`  VALUES ('".$varC."','".$varA6."');";
									mysqli_query($test, $query);
								}
							}
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
				mysqli_close($test);
				?>
			</div>	
		</div>	
	</body>
</html>