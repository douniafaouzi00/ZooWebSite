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
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Personale()'>Visualizza Personale</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Attività()'> Visualizza Prenotazioni Attività</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Prenotazioni_Ticket()'>visualizza Prenotazioni Ticket</button></th>
					<th><button type='submit' style='margin:8px;' onclick='visualizza_Attività()'> Visualizza Attività</button></th>
					
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
					location.href='visualizza_Attività_admin.php';
				}
				function visualizza_Personale(){
					location.href='visualizza_Personale.php';
				}
			</script>
			<div id="visualizza" align='center'>
				<table align='center'>
					<tr>
					<th></th>
					<th></th>
					<th><h3>nome</h3></th>
					<th><h3>specie</h3></th>
					<th><h3>recinto</h3></th> 
					<th><h3>immagine</h3></th> 
					<th><h3>conteggio</h3></th>
					</tr>
					<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					$query="SELECT a.codice, a.nome, a.immagine, a.recinto, a.conteggio, s.specie as nome_specie, a.specie as codice_specie from `animale` as a ,`specie` as s where a.specie=s.codice ";
					$result=mysqli_query($test, $query);
					$num = mysqli_num_rows($result);
					$i=0;
					while($i < $num ){
						echo"<tr> 
						<form method='post' action='".$_SERVER['PHP_SELF']."' align='center'>";
						$row=mysqli_fetch_assoc($result);
						$varC=$row["codice"];
						$varN=$row["nome"];
						$varCS=$row["codice_specie"];
						$varNS=$row["nome_specie"];
						$varI=$row["immagine"];
						$varR=$row["recinto"];
						$varCount=$row["conteggio"];
						echo"<th><input type='hidden' name='id' value=".$i."></th>
							<th><input type='hidden' name='codice' value=".$varC.">
							<b>".$varC."</b></th>
						<th><input type='text' name='nome' value=".$varN."></th>
						<th><select name='specie'>
						<option value=".$varCS.">".$varNS."</option>";
						$query ="SELECT * from specie where codice != '".$varS."'";
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
						</th>
						<th><select name='recinto'>
						<option value=".$varR.">".$varR."</option>";
						$query ="SELECT * from recinto where codice != '".$varR."'";
						$res=mysqli_query($test, $query);
						$n=mysqli_num_rows($res);
						$j=0;
						while($j < $n ){
							$r=mysqli_fetch_assoc($res);
							$codice=$r["codice"];
							echo"<option value=".$codice.">".$codice."</option>";
							$j++;
						}
						echo"
						</select></th>
						<th><input type='text' name='immagine' value=".$varI."></th>
						<th><input type='text' name='conteggio' value=".$varCount."></th>
						<th><button type='submit'>modifica</button></th>
						</form>
						</tr>";
						$i++;
					}
					mysqli_close($test);
				?>
				</table>
				<div  align='center' id='wrong' hidden=true>
					<h4 class='alert alert-warning'><strong>Warning!</strong> Inserisci tutti i valori!
					<button type='submit' onclick='hide_wrong()'>ok</button>
					</h4>
				</div>
				<div  align='center' id='notification' hidden=true style="margin:8px;">
					<h4 class='alert alert-notification'><strong>Notification!</strong> Modifica eseguita con successo!
					<button type='submit' onclick='hide_not()'>continua modifiche</button>
					</h4>
				</div>
				<div align='center'>
					<button type='submit' style='margin:15px' onclick='inserisci_Animale()'>Inserisci animale</button>
				</div>
				<script>
					function hide_wrong() {
						document.getElementById("wrong").hidden=true;
					}
					function hide_not() {
						document.getElementById("notification").hidden=true;
						location.href=location.href;
					}
					function inserisci_Animale() {
						location.href='inserisci_Animale.php';
					}
				</script>
				<?php
					$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
					$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$varC = htmlspecialchars($_REQUEST['codice']);
						$varN = htmlspecialchars($_REQUEST['nome']);
						$varS = htmlspecialchars($_REQUEST['specie']);
						$varR = htmlspecialchars($_REQUEST['recinto']);
						$varI = htmlspecialchars($_REQUEST['immagine']);
						$varCount = htmlspecialchars($_REQUEST['conteggio']);
						$id=htmlspecialchars($_REQUEST['id']);
						if($varC!="" & $varN!="" & $varI!="" & $varCount!=""){
							$query="SELECT a.codice, a.nome, a.immagine, a.recinto, a.conteggio, s.specie as nome_specie, a.specie as codice_specie from `animale` as a ,`specie` as s where a.specie=s.codice";
							$risultato=mysqli_query($test, $query);
							$num = mysqli_num_rows($risultato);
							$i=0;
							while($i < $num ){
								$r=mysqli_fetch_assoc($risultato);
									$codice=$r["codice"];
									if($i==$id){
										$query="DELETE FROM `animale` WHERE `codice` = '".$codice."'";
										$ris=mysqli_query($test, $query);
											if($ris==true){
												$query ="INSERT INTO `animale`  VALUES ('".$varC."','".$varN."','".$varS."','".$varI."','".$varR."','".$varCount."' )";
												$result=mysqli_query($test, $query);
												if($result==true){											
													echo"
													<script> 
														document.getElementById('wrong').hidden=true;
														document.getElementById('notification').hidden=false;
													</script>";
												}
											}
									}	
									$i++;		
							}
						}
						else{
								echo"<script> 
									document.getElementById('wrong').hidden=true;
									document.getElementById('notification').hidden=true;
								</script>";
						}
					}
				?>
			</div>	
		</div>	
	</body>
</html>