<?php
		session_start();
		$email=$_SESSION["email"];
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
					<th><button type='submit' style='margin:8px;' onclick='modifica()'> Modifica dati Personali</button>
					<th><button type='submit' style='margin:8px;' onclick='ticket()'>Prenota Ticket</button>
					<th><button type='submit' style='margin:8px;' onclick='prenota_attività()'>Prenota Attività</button>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_ticket()'> visualizza ticket</button>
				</tr>
			</table>
			<script>
			function modifica(){
					location.href='areaUtenti.php';
				}
				function ticket(){
					location.href='prenota_ticket.php';
				}
				function prenota_attività(){
					location.href='prenota_attivit_.php';
				}
				function visualizza_ticket(){
					location.href='visualizza_ticket.php';
				}
			</script>
			<div id="visualizza">
				<h3 align=center> Visualizza le prenotazioni delle attività </h3>
				<table>
					<tr>
						<th width="30"></th>
						<th><h3>Attività</h3></th>
						<th><h3>Numero Adulti</h3></th>
						<th><h3>Numero Bambini</h3></th>
						<th><h3>Data</h3></th>
						<th width="30"></th>
					</tr>
					<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					$query="SELECT a.codice, a.nome,p.bambini,p.adulti,p.data from `prenota_attività` as p , `attività` as a where p.attività=a.codice and p.email='".$email."'";
					$result=mysqli_query($test, $query);
					$num = mysqli_num_rows($result);
					$i=0;
					while($i < $num ){
						echo"<tr> 
						<form method='post' action='".$_SERVER['PHP_SELF']."' align='center'>";
						$row=mysqli_fetch_assoc($result);
						$varC=$row["codice"];
						$varN=$row["nome"];
						$varB=$row["bambini"];
						$varA=$row["adulti"];
						$varD=$row["data"];
						echo"<th><input type='hidden' name='id' value=".$i."></th>
						<th><select name='attività'>
						<option value=".$varC.">".$varN."</option>";
						$query ="SELECT * from attività where codice != '".$varC."'";
						$res=mysqli_query($test, $query);
						$n=mysqli_num_rows($res);
						$j=0;
						while($j < $n ){
							echo"ciao";
							$r=mysqli_fetch_assoc($res);
							$codice=$r["codice"];
							$nome=$r["nome"];
							echo"<option value=".$codice.">".$nome."</option>";
							$j++;
						}
						echo"
						</select>
						</th>
						<th><input type='text' name='adulti' value=".$varA."></th>
						<th><input type='text' name='bambini' value=".$varB."></th>
						<th><input type='date' name='data' value=".$varD."></th>
						<th><button type='submit'>modifica</button></th>
						</form>
						</tr>";
						$i++;
					}
					mysqli_close($test);
				?>
				</table>
				<p style="margin:15px;">Per eliminare una prenotazione azzerare il numero di adulti e il numero di bambini e poi modificare.</p>
				<div  align='center' id='elimina' hidden=true>
					<h4 class='notification'><strong>Notification!</strong> Prenotazione eliminata con successo!
					<button type='submit' onclick='hide()'>ok</button>
					</h4>
				</div>
				<div  align='left' id='wrong' hidden=true>
				<h4 class='alert alert-warning'><strong>Warning!</strong> Inserisci tutti i valori! NB: deve esserci almeno un adulto
				<button type='submit' onclick='hide_wrong()'>ok</button>
				</h4>
			</div>
			<div  align='left' id='duplicate' hidden=true>
				<h4 class='alert alert-warning'><strong>Warning!</strong> Hai già una prenotazione per questa attività per questa data!
				<button type='submit' onclick='hide_dup()'>ok</button>
				</h4>
			</div>
			<div  align='left' id='notification' hidden=true style="margin:8px;">
				<h4 class='alert alert-notification'><strong>Notification!</strong> Modifica eseguita con successo!
				<button type='submit' onclick='hide_not()'>continua modifiche</button>
				</h4>
			</div>
			<div  align='left' id='wrong_data' hidden=true>
				<h4 class='alert alert-warning'><strong>Warning!</strong> Data occupata prova un'altra data!
				<button type='submit' onclick='hide_data()'>ok</button>
				</h4>
			</div>
				<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$varC = htmlspecialchars($_REQUEST['attività']);
						$varA = htmlspecialchars($_REQUEST['adulti']);
						$varB = htmlspecialchars($_REQUEST['bambini']);
						$varD = htmlspecialchars($_REQUEST['data']);
						$id=htmlspecialchars($_REQUEST['id']);
						if($varA!="" & $varA!="0" & $varB!="" & $varD!=""){
							$query="SELECT * FROM `prenota_attività` WHERE data='".$varD."' and attività='".$varC."'";
							$risultato=mysqli_query($test, $query);
							$numero=mysqli_num_rows($risultato);
							if($numero>1){
								echo"
								<script>
									document.getElementById('wrong_data').hidden=false;
								</script>";
							}
							else{
								$query="SELECT a.codice, p.data from `prenota_attività` as p , `attività` as a where p.attività=a.codice and p.email='".$email."'";
								$res=mysqli_query($test, $query);
								$n = mysqli_num_rows($result);
								$i=0;
								while($i < $n ){
									$r=mysqli_fetch_assoc($res);
									$codice=$r["codice"];
									$data=$r["data"];
									if($i==$id){
										$query="DELETE FROM `prenota_attività` WHERE `email` = '".$email."' and `attività` = '".$codice."' and `data` = '".$data."'";
										$ris=mysqli_query($test, $query);
											if($ris==true){
												$query ="INSERT INTO `prenota_attività`  VALUES ('".$email."','".$varC."','".$varB."','".$varA."','".$varD."' )";
												$result=mysqli_query($test, $query);
												if($result==true){											
													echo"
													<script> 
														document.getElementById('wrong').hidden=true;
														document.getElementById('notification').hidden=false;
													</script>";
												}
												else{
													echo"<script> 
														document.getElementById('duplicate').hidden=false;
														document.getElementById('wrong').hidden=true;
														document.getElementById('notification').hidden=true;
													</script>";
												}
											}
									}
									$i++;
								}
							}
						}
						else if($varA=='0' & $varB=='0'){
							$query="DELETE FROM `prenota_attività` WHERE `email` = '".$email."' and `attività` = '".$varC."' and `data` = '".$varD."'";
							$ris=mysqli_query($test, $query);
							if($ris==true){											echo"
								<script> 
									document.getElementById('elimina').hidden=false;
								</script>";
							}
						}
						else{
							echo"<script> 
									document.getElementById('duplicate').hidden=true;
									document.getElementById('wrong').hidden=false;
									document.getElementById('notification').hidden=true;
								</script>";
						}
						
					}
				?>
			</div>
			<script>
				function hide(){
					document.getElementById('elimina').hidden=true;
					location.href=location.href;
				}
				function hide_dup() {
					document.getElementById("duplicate").hidden=true;
				}
				function hide_data() {
					document.getElementById("wrong_data").hidden=true;
					location.href=location.href;
				}
				function hide_wrong() {
					document.getElementById("wrong").hidden=true;
				}
				function hide_not() {
					document.getElementById("notification").hidden=true;
					location.href=location.href;
				}
			</script>
		</div>
	</body>
</html>