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
				width:500; 
				height:25px; 
				margin:5px; 
				border:1px solid; 
				border-color: red;
				align: center;
			}
			.alert-notification{
				width:700; 
				height:25px; 
				margin:5px; 
				border:1px solid; 
				border-color: green;
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
		</header>
		<div class="center">
			<form id="login" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" align="left" style="margin: 20px;">
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
				<b style="margin: 8px;">Password:</b>
				<input type="password" name="password" style="margin-left:25px" size="20" maxlength="30">
				<br></br>
				<button type="submit" id="registra" style="margin:50px">registrati</button>
			</form>
			<div  align='left' id='notification' hidden=true>
				<h4 class='alert alert-notification'><strong>Notification!</strong> Registrazione eseguita con successo!
				<button type='submit' onclick="home()">torna home</button>
				<button type='submit' onclick='hide()'>continua registrazioni</button>
				</h4>
			</div>
			<script>
			function home() {
				location.href='index.php';
			}			
			</script>
			<div  align='left' id='wrong' hidden=true>
				<h4 class='alert alert-warning'><strong>Warning!</strong> Inserisci tutti i valori!
				<button type='submit' onclick='hide()'>ok</button>
				</h4>
			</div>
			<div  align='left' id='duplicate' hidden=true>
				<h4 class='alert alert-warning'><strong>Warning!</strong> email già usata prova con un'altra!
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
						$query ="INSERT INTO `utenti`  VALUES ('".$varE."','".$varP."','".$varN."','".$varC."','".$varT."','u' )";			
						$result=mysqli_query($test, $query);
						mysqli_close($test);
						if($result==true){
							echo" <script> document.getElementById('registra').hidden=true;
									document.getElementById('notification').hidden=false;</script>";
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
			<script>
			function hide() {
				document.getElementById("notification").hidden= true;
				document.getElementById("registra").hidden=false;
				document.getElementById("wrong").hidden=true;
				document.getElementById("duplicate").hidden=true;
			}
			</script>
		</div>
	</body>
</html>