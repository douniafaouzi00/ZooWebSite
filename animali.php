<?php
		session_start();
		$email=$_SESSION["email"];
		$priority=$_SESSION["priority"];
		echo $email;
		echo $priority;
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
		<div id="authenticated">
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
			<?php
			if($email!="guest"){
				echo"<script>
					document.getElementById('area').hidden=false;
				</script>";
			}
			else{
				echo"<script>
					document.getElementById('area').hidden=true;
					</script>";
			}
			?>
		</div>
		<div id="menu">
			<hr/>
			<table id="menu" width="100%">
				<tr>
					<th><a href="index.php">HOME</a></th>
					<th><a href="attivit_.php">ATTIVITA' DEL PARCO</a></th>
					<th><a href="informazioni.php">INFO</a></th>
				</tr>
			</table>
			<hr/>
		</div>
		<div class="center">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<b style="margin: 8px;">Nome:</b>
			<input type="text" name="nome" size="20" maxlength="30" value="tutti" >
			<br></br>
			<b style="margin: 8px;">Specie:</b>
			<select name="specie" style="margin: 8px;" >
			<option value="s0">sconosciuta</option>;
			<?php
				$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
                $test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
				$query ="SELECT * from specie";
				$result=mysqli_query($test, $query);
				mysqli_close($test);
				$num=mysqli_num_rows($result);
				$i=0;
				while($i < $num ){
				$row=mysqli_fetch_assoc($result);
				$codice=$row["codice"];
				$nome=$row["specie"];
				echo"<option value=".$codice.">".$nome."</option>";
				$i++;
				}
			?>
			</select>
			<button type="submit">CERCA</button>
			</form>
			<?php
				echo"<table>
					<tr> 
					<th><h3>immagine</h3></th> 
					<th><h3>nome</h3></th>
					<th><h3>specie</h3></th>
					<th><h3>zona</h3></th> 
					<th><h3>habitat</h3></th>
					<th><h3>conteggio</h3></th>
					</tr>";
				
				$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
				$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
					
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$varN = htmlspecialchars($_REQUEST['nome']);
					$varS = htmlspecialchars($_REQUEST['specie']);
					if(($varN=="tutti" or $varN=="") && $varS=="s0"){
						$query ="SELECT a.nome,s.specie,a.immagine,r.zona, r.habitat, a.conteggio from animale a,specie s, recinto r where a.specie=s.codice and a.recinto=r.codice";
					}
					elseif(($varN=="tutti" or $varN=="") && $varS!="s0"){
						$query ="SELECT a.nome,s.specie,a.immagine,r.zona, r.habitat, a.conteggio from animale a,specie s, recinto r where a.specie=s.codice and a.recinto=r.codice AND s.codice= '".$varS."' ";
					}
					elseif (($varN!="tutti" or $varN!="")&& $varS=="s0"){
						$query ="SELECT a.nome,s.specie,a.immagine,r.zona, r.habitat, a.conteggio from animale a,specie s, recinto r where a.specie=s.codice and a.recinto=r.codice AND a.nome= '".$varN."' ";
					}
					else{
						$query ="SELECT a.nome,s.specie,a.immagine,r.zona, r.habitat, a.conteggio from animale a,specie s, recinto r where a.specie=s.codice and a.recinto=r.codice AND a.nome= '".$varN."' AND s.codice= '".$varS."' ";
					}
				}
				else
				{
					$query ="SELECT a.nome,s.specie,a.immagine,r.zona, r.habitat, a.conteggio from animale a,specie s, recinto r where a.specie=s.codice and a.recinto=r.codice";
				}
				$result=mysqli_query($test, $query);
				mysqli_close($test);
				$num = mysqli_num_rows($result);
				$i=0;
				while($i < $num ){
				$row=mysqli_fetch_assoc($result);
				$nome=$row["nome"];
				$specie=$row["specie"];
				$immagine=$row["immagine"];
				$recinto=$row["zona"];
				$habitat=$row["habitat"];
				$conteggio=$row["conteggio"];
				echo"<tr>";
				echo"<th><img src=".$immagine." alt=".$nome." width='120' height='120'/></th>";
				echo"<th><p>".$nome."</th>";
				echo"<th><p>".$specie."</th>";
				echo"<th><p>".$recinto. " </th>";
				echo"<th><p>".$habitat."</th>";
				echo"<th><p>".$conteggio."</th>";
				echo"</tr>";
				$i++;
				}
				echo"</table>";
			?>
		</div>
	</body>
</html>