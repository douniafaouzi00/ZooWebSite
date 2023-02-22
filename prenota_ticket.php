<?php
		session_start();
		$email=$_SESSION["email"];
		$psw=$_SESSION["password"];
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
					<th><button type='submit' style='margin:8px;' onclick='attività()'>Prenota Attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_attività()'> visualizza prenotazioni attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_ticket()'> visualizza ticket</button></th>
					
				</tr>
			</table>
			<div id="ticket">
				<h3 align=center> Prenota Ticket </h3>
				<form id="prenotazione" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" align="center" style="margin: 20px;">
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
				<div  align='center' id='wrong-input' hidden=true>
					<h4 class='alert alert-warning'><strong>Warning!</strong> Inserisci tutti i valori! NB: deve esserci almeno un adulto
					<button type='submit' onclick='hide_wrong()'>ok</button>
					</h4>
				</div>
				<div  align='center' id='duplicate' hidden=true>
					<h4 class='alert alert-warning'><strong>Warning!</strong> Hai già una prenotazione per questa data se vuoi modificarla accedi a visualizza ticket!
					<button type='submit' onclick='hide_dup()'>ok</button>
					</h4>
				</div>
				<div  align='center' id='notification-ticket' hidden=true style="margin:8px;">
					<h4 class='alert alert-notification'><strong>Notification!</strong> Prenotazione eseguita con successo!
					<button type='submit' onclick='hide_not()'>continua prenotazioni</button>
					</h4>
				</div>
			<?php
				$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$varA =htmlspecialchars($_REQUEST['adulti']);
					$varB =htmlspecialchars($_REQUEST['bambini']);
					$varD =htmlspecialchars($_REQUEST['data']);
					if($varA!=""  & $varB!="" & $varD!="")
					{
						if($varA!="0"){
							$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
							$query ="INSERT INTO `ticket`  VALUES ('".$email."','".$varD."','".$varB."','".$varA."' )";	
							$result=mysqli_query($test, $query);
							mysqli_close($test);								
							if($result==true){
                            	$query ="select cognome from `utenti` where email='".$email."'";	
								$r=mysqli_query($test, $query);
								$row=mysqli_fetch_assoc($r);
								$cognome=$row["cognome"];
								$subject="Prenotazione Ticket";
								$content="Salve Gentile ".$cognome.", \n Ha prenotato un biglietto per visitare lo zoo di Torino in data: ".$varD." per ".$varA." adulti e ".$varB." bambini. \n 
								Se desidera modificare la prenotazione acceda alla sua area utenti, dopo di che sull'area visualizza prenotazioni ticket e modificare la prenotazione. \n 
								Cordialmente, Zoo di torino.";
								$header="From: 'Zoo Torino' <info.zootorino@gmail.com> \r\n";
                                $header .= "Reply-To: info.zootorino@gmail.com\r\n";
								$header .= "X-Mailer: PHP/" . phpversion();
                                
								if(mail($email,$subject, $content, $header))
								{
								echo"
                                  <script> 
                                      document.getElementById('notification-ticket').hidden=false;
                                      document.getElementById('prenota').hidden=true;
                                      document.getElementById('wrong-input').hidden=true;
                                  </script>";
								}
							}
							else{
								echo"<script> 
									document.getElementById('duplicate').hidden=false;
									document.getElementById('wrong-input').hidden=true;
									document.getElementById('prenota').hidden=true;
								</script>";
							}
						}
						else{
							echo"<script> 
								document.getElementById('wrong-input').hidden=false;
								document.getElementById('prenota').hidden=true;
							</script>";
						}
					}
					else{
						echo"<script> 
								document.getElementById('wrong-input').hidden=false;
								document.getElementById('prenota').hidden=true;
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
					document.getElementById("wrong-input").hidden=true;
					document.getElementById("prenota").hidden=false;
				}
				function hide_not() {
					document.getElementById("notification-ticket").hidden=true;
					document.getElementById("prenota").hidden=false;
				}
				function hide_data() {
					document.getElementById("wrong_data").hidden=true;
					document.getElementById("prenota").hidden=false;
				}
				function modifica(){
					location.href='areaUtenti.php';
				}
				function attività(){
					location.href='prenota_attivit_.php';
				}
				function visualizza_attività(){
					location.href='visualizza_attivit_.php';
				}
				function visualizza_ticket(){
					location.href='visualizza_ticket.php';
				}
			</script>
		</div>
	</body>
</html>