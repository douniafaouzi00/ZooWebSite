<?php
	session_start();
	$email=$_SESSION["email"];
	$psw=$_SESSION["password"];
	$priority=$_SESSION["priority"];
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
				width:500px; 
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
	<div id="autentication">
		<hr/>
		<form hidden=true id="login" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" align="right" style="margin: 8px;">
			<b style="margin: 8px;">Username:</b>
			<input id="email" type="text" name="email" size="20" maxlength="30" value=<?php echo $email ?>>
			<b style="margin: 8px;">Password:</b>
			<input type="password" name="password" size="20" maxlength="30" value=<?php echo $psw ?>>
			<button type="submit">login</button>
		</form>
		<div id="subscribe" align='right' style="margin:8px;">
			<button type="submit" onclick='registra()'>registrazione</button>
		</div>
		<script>
			function registra() {
				location.href='registrazione.php';
			}
		</script>
		<div hidden=true align="right" id="area">
			<?php
			if($priority=="a")
			{
				echo"<button type='submit' style='margin:8px;' onclick='areaAdmin()'> AREA ADMIN </button>";
			}
			else{
				echo"<button type='submit' style='margin:8px;' onclick='areaUtenti()'> AREA UTENTE </button>";
			}
			?>
			<button type='submit' onclick="logout()" style='margin:8px;'> logout </button>
            <script> 
				document.getElementById('login').hidden=true;
				document.getElementById('subscribe').hidden=true;
				document.getElementById('e/p_wrong').hidden=true;
			</script>
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
		<div hidden=true align='right' id='e/p_wrong'>
			<h4 class='alert alert-warning'><strong>Warning!</strong> Email/password incorrette riprova o registrati.
			<button type='submit' onclick='hide()'>ok</button>
			</h4>
		</div>
		<?php
			if($email!="guest"){
				echo"<script>
					document.getElementById('e/p_wrong').hidden=true;
					document.getElementById('login').hidden=true;
					document.getElementById('subscribe').hidden=true;
					document.getElementById('area').hidden=false;
				</script>";
			}
			else{
				echo"<script>
					document.getElementById('e/p_wrong').hidden=true;
					document.getElementById('login').hidden=false;
					document.getElementById('subscribe').hidden=false;
					document.getElementById('area').hidden=true;
					</script>";
			}
			$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$varE =htmlspecialchars($_REQUEST['email']);
				$varP = htmlspecialchars($_REQUEST['password']);
				$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
				$query ="SELECT * from utenti where email= '".$varE."' AND password= '".$varP."' ";			
				$result=mysqli_query($test, $query);
				mysqli_close($test);
				$num = mysqli_num_rows($result);
				if($num > 0){
					$row=mysqli_fetch_assoc($result);
					$email=$row["email"];
					$psw=$row["password"];
					$priority=$row["priority"];
					$_SESSION["email"]=$email;
					$_SESSION["priority"]=$priority;
					$_SESSION["password"]=$psw;					
					echo"<script>
						window.location.href=window.location.href;
					</script>";
				}
				else{
					echo"<script>
					document.getElementById('e/p_wrong').hidden=false;
					document.getElementById('login').hidden=false;
					document.getElementById('subscribe').hidden=false;
					document.getElementById('area').hidden=true;
					</script>";
				}
			}
			
		?>
			
		<script>
			function hide() {
				document.getElementById("e/p_wrong").hidden= true;
		</script>
	</div>
	<div id="menu">
		<hr/>
		<table id="menu" width="100%">
			<tr>
				<th><a href="animali.php">ANIMALI</a></th>
				<th><a href="attivit_.php">ATTIVITA' DEL PARCO</a></th>
				<th><a href="informazioni.php">INFO</a></th>
			</tr>
		</table>
		<hr/>
	</div>
	<div id="center">
		<table align="center" width="100%" >
			<tr>
				<th align="center"><img src="ippopotamo.jpg" width="250" height="150" alt="Giardino Zoologico" /></th>
				<th align="center"><img src="pinguino.jpg" width="250" height="150" alt="Giardino Zoologico" /></th>
				<th align="center"><img src="giraffe.jpg" width="250" height="150" alt="Giardino Zoologico" /></th>
			</tr>
		</table>
		<p align="center">Il Giardino Zoologico è un parco con oltre 400 animali e 7 ettari di estensione; in continua espansione.
		In una avvolgente dimensione naturalistica le emozioni che vivrai ti avvicineranno alla conoscenza degli animali e ai diversi modi per poterli proteggere e per vivere rispettando il Pianeta.
		Per dimensione e importanza dell'attività didattica e di conservazione delle specie animali, il parco costituisce una delle principali strutture del genere in Italia.
		La missione: rappresentare un centro per accrescere nel pubblico la conoscenza della biodiversità e il suo valore per la vita umana.
		</p>
		<h2 align="center">Come prenotare un biglietto:</h2>
		<p>
			Per poter prenotare un biglietto bisogna accedere all'area personale se si è in possesso delle credenziali, altrimenti iscriversi; dopo di che cliccare Prenota ticket e riempire i parametri della prenotazione.
			Se si desiderasse eliminare una prenotazione basti accedere all'area personale, cliccare Visualizza tickets, selezionare il ticket da eliminare e cliccare il bottone elimina.
			Per prenotare un'attività bisogna dopo aver effettuato l'accesso con credenziali o andare nell'area personale e cliccare Prenota attività oppure dopo aver visto le attività del parco prenotare direttamente dalla pagina di descrizione dell'attività.
			Se si desiderasse eliminare una prenotazione per un'attività basti accedere all'area personale, cliccare Visualizza prenotazioni, selezionare la prenotazione da eliminare e cliccare il bottone elimina.
		</p>
		<h1 align="center">3 cose che non sai del nostro zoo</h1>
		<ol>
		<li> GLI ANIMALI DELLO ZOO NON SONO PRESI DALLA NATURA 
			<br/>Sono nati qui o provengono da altri zoo. I trasferimenti seguono progetti per la salvaguardia delle specie minacciate o programmi di collaborazione tra zoo. </li>
		<li>ANCHE TU PARTECIPI ALLA TUTELA DELLA NATURA
			<br/>Con il tuo biglietto d’ingresso finanziamo progetti per la salvaguardia in natura di specie minacciate. In questi anni siamo impegnati nella tutela del: Lemure catta in Madagascar, Pinguino africano in Sudafrica, Gibbone dalle guance rosa in Vietnam, Panda minore in Nepal; la Lontra asiatica e il Binturong in Asia</li>
		<li>IN CONTINUA TRASFORMAZIONE
			<br/>Negli ultimi 15 anni lo zoo ha intrapreso un processo di profonda trasformazione; stiamo lavorando per completarlo quanto prima.</li>
		</ol>
	</div>
	</body>
<html>