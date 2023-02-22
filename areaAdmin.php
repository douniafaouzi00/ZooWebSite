<?php
		session_start();
		$email=$_SESSION["email"];
		$psw=$_SESSION["password"];
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
			<script>
                function logout(){              
                  location.href="logout.php";
              }
			</script>
            </div>
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
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Personale()'> Visualizza Personale</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Utenti()'>Visualizza Utenti</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Attività()'> Visualizza Prenotazioni Attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Ticket()'>visualizza Prenotazioni Ticket</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Attività()'> Visualizza Attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Animali()'> Visualizza Animale</button></th>
				</tr>
			</table>
			<div id="modifica" >
				<h3 align=center> Modifica i tuoi dati </h3>
				<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					$query ="SELECT * from utenti where email= '".$email."' AND password= '".$psw."' ";			
					$result=mysqli_query($test, $query);
					mysqli_close($test);
					$num = mysqli_num_rows($result);
					$row=mysqli_fetch_assoc($result);
					$mail=$row["email"];
					$psw=$row["password"];
					$nome=$row["nome"];
					$cognome=$row["cognome"];
					$telefono=$row["telefono"];
				?>
				<form align=center method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="margin: 20px;">
					<b style="margin: 8px;">Nome:</b>
					<input type="text" name="nome" style="margin-left:50px" size="20" maxlength="30" value="<?php echo $nome; ?>">
					<br></br>
					<b style="margin: 8px;">Cognome:</b>
					<input type="text" name="cognome" style="margin-left:25px" size="20" maxlength="30" value="<?php echo $cognome; ?>">
					<br></br>
					<b style="margin: 8px;">Email:</b>
					<input type="text" name="email" style="margin-left:50px" size="20" maxlength="30" value="<?php echo $mail; ?>">
					<br></br>
					<b style="margin: 8px;">Telefono:</b>
					<input type="text" name="telefono" style="margin-left:33px" size="20" maxlength="30" value="<?php echo $telefono; ?>">
					<br></br>
					<b style="margin: 8px;">Password:</b>
					<input type="password" name="password" style="margin-left:25px" size="20" maxlength="30" value="<?php echo $psw; ?>">
					<br></br>
					<button type="submit" id="change" style="margin:50px">Modifica</button>
				</form>
				<div  align='center' id='notification' hidden=true>
					<h4 class='alert alert-notification'><strong>Notification!</strong> Modifica dati eseguita con successo!
					<button type='submit' onclick='hide()'>continua modifiche</button>
					</h4>
				</div>
				<div  align='center' id='wrong' hidden=true>
					<h4 class='alert alert-warning'><strong>Warning!</strong> Inserisci tutti i valori o riprova!
					<button type='submit' onclick='hide()'>ok</button>
					</h4>
				</div>
				<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$varN =htmlspecialchars($_REQUEST['nome']);
						$varC =htmlspecialchars($_REQUEST['cognome']);
						$varE =htmlspecialchars($_REQUEST['email']);
						$varT =htmlspecialchars($_REQUEST['telefono']);
						$varP = htmlspecialchars($_REQUEST['password']);
						if($varN!="" & $varC!="" & $varE!="" & $varP!="" & $varT!="")
						{
							$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
							$query="DELETE FROM `utenti` WHERE `email` = '".$email."'";
							$result=mysqli_query($test, $query);
							if($result==true){
								$query ="INSERT INTO `utenti`  VALUES ('".$varE."','".$varP."','".$varN."','".$varC."','".$varT."','u' )";			
								$result=mysqli_query($test, $query);
								if($result==true){
									$_SESSION["email"]=$varE;
									$_SESSION["password"]=$varP;
									echo" <script> 
										document.getElementById('change').hidden=true;
										document.getElementById('notification').hidden=false;
										</script>";
									 	
								}
							}
							else{
								echo" <script> document.getElementById('wrong').hidden=false;</script>";
							}
							mysqli_close($test);
						}
						else{
							echo" <script> document.getElementById('wrong').hidden=false;</script>";
						}
					}
				?>
				<script>
				function hide() {
					document.getElementById("notification").hidden= true;
					document.getElementById("change").hidden=false;
					document.getElementById("wrong").hidden=true;
					location.href=location.href;
				}
				</script>
			</div>
			<script>
				function visualizza_Personale(){
					location.href='visualizza_Personale.php';
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
					location.href='visualizza_Attivit_admin.php';
				}
				function visualizza_Animali(){
					location.href='visualizza_Animali.php';
				}
			</script>
		</div>
	</body>
</html>