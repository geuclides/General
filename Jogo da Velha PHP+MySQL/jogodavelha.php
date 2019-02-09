<!-- 
*********************************************
	AUTOR: Gustavo Euclides                 
	DATA: 09/02/19
	Jogo da Velha - PHP, HTML, CSS & MySQL 
*********************************************
-->

<!DOCTYPE html>
<html>
	<head>
		<title>Jogo da Velha</title>
	</head>

	<style>
		body {
			text-align: center;
		}

		div {
			margin: 0 auto;
			background-color: #444444;
			border: solid 5px black;
			border-radius: 50px;
			padding: 30px;
			width: 175px;
		}

		input, select, textarea {
			text-align: center;
			background-color: black;
    		color: #a3a3a3;
    		font-size: 16px;
    		font-family: Courier New;
    		font-weight: bold;
   			border: solid 1px #828080;
		}

		#b1 {
			border-bottom: 3px white solid;
			border-right: 3px white solid;
			border-left: 3px white solid;
		}

		#a2 {
			border-top: 3px white solid;
			border-bottom: 3px white solid;
		}

		#b2 {
			border-right: 3px white solid;
			border-left: 3px white solid;
		}

		#c2 {
			border-top: 3px white solid;
			border-bottom: 3px white solid;
		}

		#b3 {
			border-left: 3px white solid;
			border-right: 3px white solid;
			border-top: 3px white solid;
		}

	</style>

	<body>
		<div>
			<form method="POST" action="jogodavelha.php">
				<input type="text" id="a1" name="a1" size="3" value="<?php if ($_POST['a1'] == "X" or $_POST['a1'] == "O") echo $_POST['a1']; ?>">
				<input type="text" id="b1" name="b1" size="3" value="<?php if ($_POST['b1'] == "X" or $_POST['b1'] == "O") echo $_POST['b1']; ?>">
				<input type="text" id="c1"name="c1" size="3" value="<?php if ($_POST['c1'] == "X" or $_POST['c1'] == "O") echo $_POST['c1']; ?>">
				<br>
				<input type="text" id="a2" name="a2" size="3" value="<?php if ($_POST['a2'] == "X" or $_POST['a2'] == "O") echo $_POST['a2']; ?>">
				<input type="text" id="b2" name="b2" size="3" value="<?php if ($_POST['b2'] == "X" or $_POST['b2'] == "O") echo $_POST['b2']; ?>">
				<input type="text" id="c2" name="c2" size="3" value="<?php if ($_POST['c2'] == "X" or $_POST['c2'] == "O") echo $_POST['c2']; ?>">
				<br>
				<input type="text" id="a3" name="a3" size="3" value="<?php if ($_POST['a3'] == "X" or $_POST['a3'] == "O") echo $_POST['a3']; ?>">
				<input type="text" id="b3" name="b3" size="3" value="<?php if ($_POST['b3'] == "X" or $_POST['b3'] == "O") echo $_POST['b3']; ?>">
				<input type="text" id="c3" name="c3" size="3" value="<?php if ($_POST['c3'] == "X" or $_POST['c3'] == "O") echo $_POST['c3']; ?>">
				<br>
				<input type="submit" name="enviar" value="Enviar">
			</form>
		</div>

		<?php		
			$conexao = mysqli_connect("localhost", "root", "timmie159", "jogodavelha") or die("Não foi possível conectar ao banco de dados.".mysqli_connection_error());
			if($conexao) {
				echo "";
				//Conexão bem sucedida
				print "<br>";
			}
			
			$sql = "UPDATE JOGODAVELHATESTE SET A = '$_POST[a1]', B = '$_POST[b1]', C = '$_POST[c1]' WHERE ID = 1";

			if (mysqli_query($conexao, $sql)) {
    			echo "";
    			//Update feito com sucesso na tabela.
			} else {
			    echo "Error: " . $sql . "<br>" . mysqli_error($conexao);
			}

			$sql = "UPDATE JOGODAVELHATESTE SET A = '$_POST[a2]', B = '$_POST[b2]', C = '$_POST[c2]' WHERE ID = 2";

			if (mysqli_query($conexao, $sql)) {
    			echo "";
    			//Update feito com sucesso na tabela.
			} else {
			    echo "Error: " . $sql . "<br>" . mysqli_error($conexao);
			}

			$sql = "UPDATE JOGODAVELHATESTE SET A = '$_POST[a3]', B = '$_POST[b3]', C = '$_POST[c3]' WHERE ID = 3";

			if (mysqli_query($conexao, $sql)) {
    			echo "";
    			//Update feito com sucesso na tabela.
			} else {
			    echo "Error: " . $sql . "<br>" . mysqli_error($conexao);
			}

			$sql = "SELECT A, B, C FROM JOGODAVELHATESTE WHERE ID = 1";
			$resultado = mysqli_query($conexao, $sql);
			
			if (mysqli_num_rows($resultado) > 0) { //Fetch feito com sucesso na tabela
		    	while($row = mysqli_fetch_assoc($resultado)) {
		    		$res1 = $row['A']; 
		    		$res2 = $row['B'];
		    		$res3 = $row['C'];	    
		    	}
			}

			$sql = "SELECT A, B, C FROM JOGODAVELHATESTE WHERE ID = 2";
			$resultado = mysqli_query($conexao, $sql);
			
			if (mysqli_num_rows($resultado) > 0) { //Fetch feito com sucesso na tabela
		    	while($row = mysqli_fetch_assoc($resultado)) {
		    		$res4 = $row['A']; 
		    		$res5 = $row['B'];
		    		$res6 = $row['C'];	    
		    	}
			}
			
			$sql = "SELECT A, B, C FROM JOGODAVELHATESTE WHERE ID = 3";
			$resultado = mysqli_query($conexao, $sql);
			
				if (mysqli_num_rows($resultado) > 0) { //Fetch feito com sucesso na tabela
		    	while($row = mysqli_fetch_assoc($resultado)) {
		    		$res7 = $row['A']; 
		    		$res8 = $row['B'];
		    		$res9 = $row['C'];	    
		    	}
			}

			if ($res1 == $res2 and $res2 == $res3) {
				echo "Jogador $res1 Ganhou!<br>";
			} else if ($res4 == $res5 and $res5 == $res6) {
				echo "Jogador $res4 Ganhou!";
			} else if ($res7 == $res8 and $res8 == $res9) {
				echo "Jogador $res7 Ganhou!";
			} else if ($res1 == $res4 and $res4 == $res7) {
				echo "Jogador $res1 Ganhou!";
			} else if ($res2 == $res5 and $res5 == $res8) {
				echo "Jogador $res2 Ganhou!";
			} else if ($res3 == $res6 and $res6 == $res9) {
				echo "Jogador $res3 Ganhou!";
			} else if ($res1 == $res5 and $res5 == $res9) {
				echo "Jogador $res1 Ganhou!";
			} else if ($res3 == $res5 and $res5 == $res7) {
				echo "Jogador $res3 Ganhou!";
			} else {
				echo "Empate!";
			}

			mysqli_close($conexao);
		?>
		
	</body>
</html>