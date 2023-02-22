<?php
		session_start();
		$email=$_SESSION["email"];
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
					<th><a href="animali.php">ANIMALI</a></th>
					<th><a href="informazioni.php">INFO</a></th>
				</tr>
			</table>
			<hr/>
		</div>
		<div class="center">
			<ul>
			<?php
				$user="zootorino"; $password="KTHuf6DVGhQS"; $host="localhost"; $database="my_zootorino";
				$test=@mysqli_connect($host, $user, $password, $database) or die( "Unable to select database");
				$query ="SELECT a.codice, a.nome,i.immagine from attività a, immagini_attività i where a.codice=i.codiceA GROUP by a.nome";
				$result=mysqli_query($test, $query);
				mysqli_close($test);
				$num=mysqli_num_rows($result);
				$i=0;
				while($i < $num ){
				$row=mysqli_fetch_assoc($result);
				$codice=$row["codice"];
				$nome=$row["nome"];
				$immagine=$row["immagine"];
				echo"<li> <img src=".$immagine." alt=".$nome." width='200' height='120' align='center'/> <a href='dettagli.php?cod=".$codice." ' align='center'>".$nome."</a> </li>";
				echo"<br></br>";
				$i++;
				}
			?>
			</ul>
		</div>
	</body>
</html>