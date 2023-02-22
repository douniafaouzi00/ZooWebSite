<?php
		session_start();
		$email=$_SESSION["email"];
		$priority=$_SESSION["priority"];
        $url=$_SERVER['REQUEST_URI'];
        $cod=explode("=",$url);
        $codS="a1";
		if($cod[1]!='a1'){
			$codS=$cod[1];
		}
?>
<html>
	<head>
		<meta name="Dounia Faouzi 29122" content="zoo" http-equiv="refresh" content="60"/>
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
		<hr/>
			<div align="right" id="area">
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
		<div class="center">
        	<table id="servizi">
				<tr>
					<th><button type='submit' style='margin:8px;' onclick='modifica()'> Modifica dati Personali</button></th>
					<th><button type='submit' style='margin:8px;' onclick='prenota_ticket()'>Prenota Ticket</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_attività()'> visualizza prenotazioni attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_ticket()'> visualizza ticket</button></th>
					
				</tr>
			</table>
        	<h3 align=center> Prenota Attività </h3>
			<?php
				$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
				$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
				$query="select nome from attività where codice='".$codS."'";
				$result=mysqli_query($test, $query);
				mysqli_close($test);
				$row=mysqli_fetch_assoc($result);
				$nome=$row["nome"];
			?>
			<form id="prenotazione" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" align="center" style="margin: 20px;">
				<b style="margin: 8px;">Prenota un/a</b>
				<select name="attività" style="margin-left: 55px;" >
				<?php
					echo"<option value=".$codS.">".$nome."</option>";
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					$query ="SELECT * from attività where codice != '".$codS."'";
					$result=mysqli_query($test, $query);
					mysqli_close($test);
					$num=mysqli_num_rows($result);
					$i=0;
					while($i < $num ){
					$row=mysqli_fetch_assoc($result);
					$codice=$row["codice"];
					$nome=$row["nome"];
					echo"<option value=".$codice.">".$nome."</option>";
					$i++;
					}
				?>
				</select>
				<br></br>
				<b style="margin: 8px;">numero di adulti:</b>
				<input type="text" name="adulti" style="margin-left:24px" size="20" maxlength="30" value="0">
				<br></br>
				<b style="margin: 8px;">numero di bambini:</b>
				<input type="text" name="bambini" style="margin-left:8px" size="20" maxlength="30" value="0">
				<br></br>
				<b style="margin: 8px;">data:</b>
				<input type="date" name="data" style="margin-left:125" size="20" maxlength="30">
				<br></br>
				<button type="submit" id="prenota" style="margin:50px">prenota</button>
			</form>
			<div  align='left' id='wrong_data' hidden=true>
				<h4 class='alert alert-warning'><strong>Warning!</strong> Data occupata prova un'altra data!
				<button type='submit' onclick='hide_data()'>ok</button>
				</h4>
			</div>
			<div  align='left' id='wrong' hidden=true>
				<h4 class='alert alert-warning'><strong>Warning!</strong> Inserisci tutti i valori! NB: deve esserci almeno un adulto
				<button type='submit' onclick='hide_wrong()'>ok</button>
				</h4>
			</div>
			<div  align='left' id='duplicate' hidden=true>
				<h4 class='alert alert-warning'><strong>Warning!</strong> Hai già una prenotazione per questa attività per questa data se vuoi modificarla accedi all'area personale!
				<button type='submit' onclick='hide_dup()'>ok</button>
				</h4>
			</div>
			<div  align='left' id='notification' hidden=true style="margin:8px;">
				<h4 class='alert alert-notification'><strong>Notification!</strong> Prenotazione eseguita con successo! Le abbiamo inviato una mail contennete i dati della tua prenotazione.
				<button type='submit' onclick='attività()'>torna attività</button>
				<button type='submit' onclick='hide_not()'>continua prenotazioni</button>
				</h4>
			</div>
			<?php
				$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$varC=htmlspecialchars($_REQUEST['attività']);
					$varA =htmlspecialchars($_REQUEST['adulti']);
					$varB =htmlspecialchars($_REQUEST['bambini']);
					$varD =htmlspecialchars($_REQUEST['data']);
					if($varA!="" & $varA!="0" & $varB!="" & $varD!="")
					{

						$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
						$query="SELECT * FROM `prenota_attività` WHERE data='".$varD."' and attività='".$varC."'";
						$result=mysqli_query($test, $query);
						mysqli_close($test);
						$num=mysqli_num_rows($result);
						if($num>1){
							echo"
							<script>
								document.getElementById('prenota').hidden=true;
								document.getElementById('wrong_data').hidden=false;
							</script>";
						}
						else{
							$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
							$query ="INSERT INTO `prenota_attività`  VALUES ('".$email."','".$varC."','".$varB."','".$varA."','".$varD."' )";	
							$result=mysqli_query($test, $query);
							if($result==true){
								$query ="select cognome from `utenti` where email='".$email."'";	
								$r=mysqli_query($test, $query);
								$row=mysqli_fetch_assoc($r);
								$cognome=$row["cognome"];
								$query ="select nome from `attività` where codice='".$varC."'";	
								$res=mysqli_query($test, $query);
								$row=mysqli_fetch_assoc($res);
								$nome=$row["nome"];
								$subject="Prenotazione Attività";
								$content="Salve Gentile ".$cognome.", \n Ha prenotato un ".$nome." in data: ".$varD." per ".$varA." adulti e ".$varB." bambini. \n 
								Se desidera modificare la prenotazione acceda alla sua area utenti, dopo di che sull'area visualizza prenotazioni attività e modificare la prenotazione. \n 
								Cordialmente, Zoo di torino.";
								$header="From: 'Zoo Torino' <info.zootorino@gmail.com> \r\n";
                                $header .= "Reply-To: info.zootorino@gmail.com\r\n";
								$header .= "X-Mailer: PHP/" . phpversion();
                                
								if(mail($email,$subject, $content, $header))
								{
                                	$query ="select responsabile, email_resp from `attività` where codice='".$varC."'";	
                                  $res=mysqli_query($test, $query);
                                  $row=mysqli_fetch_assoc($res);
                                  $resp=$row["responsabile"];
                                  $email_resp=$row["email_resp"];
                                	$subject="Prenotazione Attività";
									$content="Salve Gentile ".$resp.", \n Il signor ".$cognome." ha prenotato un ".$nome." in data: ".$varD." per ".$varA." adulti e ".$varB." bambini. \n 
                                    Se desidera contattarlo può scrivergli a questa email: ".$email."\n 
                                    Cordialmente, Zoo di torino.";
                                    $header="From: 'Zoo Torino' <info.zootorino@gmail.com> \r\n";
                                    $header .= "Reply-To: info.zootorino@gmail.com\r\n";
                                    $header .= "X-Mailer: PHP/" . phpversion();
									echo"
									<script> 
										document.getElementById('notification').hidden=false;
										document.getElementById('prenota').hidden=true;
										document.getElementById('wrong').hidden=true;
										document.getElementById('wrong_data').hidden=true;
									</script>";
								}
								mysqli_close($test);	
							}
							else{
								echo"<script> 
									document.getElementById('duplicate').hidden=false;
									document.getElementById('wrong').hidden=true;
									document.getElementById('prenota').hidden=true;
									document.getElementById('wrong_data').hidden=true;
								</script>";
							}
						}

					}
					else{
						echo"<script> 
								document.getElementById('wrong').hidden=false;
								document.getElementById('prenota').hidden=true;
								document.getElementById('wrong_data').hidden=true;
							</script>";
					}
				}
				?>
				<script>
				function hide_dup() {
					document.getElementById("duplicate").hidden=true;
					document.getElementById("prenota").hidden=false;
				}
				function hide_wrong() {
					document.getElementById("wrong").hidden=true;
					document.getElementById("prenota").hidden=false;
				}
				function hide_not() {
					document.getElementById("notification").hidden=true;
					document.getElementById("prenota").hidden=false;
				}
				function hide_data() {
					document.getElementById("wrong_data").hidden=true;
					document.getElementById("prenota").hidden=false;
				}
				function attività() {
						location.href='attivit_.php';
				}
                function modifica(){
					location.href='areaUtenti.php';
				}
				function prenota_ticket(){
					location.href='prenota_ticket.php';
				}
				function visualizza_attività(){
					location.href='visualizza_attivit_.php';
				}
				function visualizza_ticket(){
					location.href='visualizza_ticket.php';
				}
			</script>
		</script>
		</div>
	</body>
</html>