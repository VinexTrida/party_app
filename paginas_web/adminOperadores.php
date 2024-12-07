<?php
	include('../conexoes_bd/conex.php');
	session_start();
  	if(!isset($_SESSION['nome'])){
    		session_destroy();
    		header("Location: ../index.php");
		exit;
  	}
  	if($_SESSION['admin'] !== '1'){
  		session_destroy();
    		header("Location: ../index.php");
		exit;
  	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(isset($_POST['voltar'])){
			header("Location: caixa.php");
			exit; 
		}
	}
?>
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<html>
	<head>
		<style type="text/css">
			body{
	  			box-sizing: border-box;
				background-color: #a0b7d7;
				/*display: grid;
            	place-items: center;
            	height: 100%;*/
			}
			button{
				border: none;
				background-color: transparent;
				height: 50px;
				width: 80px;
			}
			select{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.menu{
				background-color: #4d81be; 
				margin-top: -7px;
				margin-left: -8px;
				margin-right: -7px;
	  			height: 50px;
			}
			.botoesMenu{
				display: inline;	
			}
			.voltar{
				width: 170px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: block;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 25px;
				transition: background-color 0.2s;
				font-size: 29px;
				background-image: url('../imagens/operadores/voltar.png');
				background-repeat: no-repeat;
	    		background-position: 123px center;
	    		background-size: 32px 32px;
			}
			.voltar:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 127px center;
			}
			.novo{
				width: 180px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: none;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 25px;
				transition: background-color 0.2s;
				font-size: 29px;
				background-image: url('../imagens/operadores/adiconar.png');
				background-repeat: no-repeat;
	    		background-position: 145px center;
	    		background-size: 32px 32px;
			}
			.novo:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 149px center;
			}
			.remover{
				width: 180px;
				transition: letter-spacing 0.2s;
				height: 50px;
				display: none;
				float: right;
				color: white;
				cursor: pointer;
				padding-right: 25px;
				transition: background-color 0.2s;
				font-size: 29px;
				background-image: url('../imagens/operadores/remover.png');
				background-repeat: no-repeat;
	    		background-position: 140px center;
	    		background-size: 32px 32px;
			}
			.remover:hover{
				letter-spacing: 1.5px;
				background-color: rgba(255, 255, 255, 0.3);
				background-position: 149px center;
			}
			.usuarios{
				padding-left: 10px;
				margin-top: 15px;
				background-color: #e4e8f0;
				height: 65px;
				border-radius: 10px;
				font-size: 20px;	
				display: flex;
				align-items: center;
				position: relative;
			}
			.usuarios button{
				width: auto!important;
				font-size: 20px;  
			}
			.usuarios p{
				display:flex;
				float: right;
				position:relative;			
			}
			.usuarios label{
				font-size: 20px;
				margin-right: 50px;		
			}
			.botoes{
				position: absolute;
				right: 10px;
				margin-left: auto;
				top: 50%;
				transform: translateY(-50%);
				font-size: 10px;
				display: flex;
				flex-direction: column;
				display: inline-block;
			}
			.visibilidade{
				position: absolute;
				color: black;
				width: 130px;
				border-radius: 15px;
				top: 50%;
				right: 50%;
				transform: translate(60%, -50%);
			}
			.quantidade{
				position: absolute;
				right: 10px;
				margin-left: auto;
				margin-right: 200px;
				top: 50%;
				transform: translateY(-50%);
				border-radius: 5px;
				color: black;
				font-weight: bold;
			}
			.editarOperador{
				padding-top: 5px;
				height: auto;
				display: none;
				font-size: 20px;
				background-color: #e4e8f0;  
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center;
			}
            .editarOperador button{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.editarOperador input{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.cadastrarOperador{
				margin-top: 10px;
				display: none;
				font-size: 20px;
				background-color: #e4e8f0;  
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center;
				padding-top: 20px;
			}
			.cadastrarOperador h3{
				margin-top: 0px;
				margin-bottom: 20px;
			}
			.cadastrarOperador button{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.cadastrarOperador input{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.removerOperador{
				margin-top: 10px;
				display: none;
				font-size: 20px;
				background-color: #e4e8f0; 
				border-radius: 10px;
				width: 400px;
				justify-content: center;
				text-align: center;
				flex-direction: column;
				align-items: center;
				padding-top: 20px;
			}
			.removerOperador h3{
				margin-top: 0px;
				margin-bottom: 20px;
			}
			.removerOperador button{
				font-size: 20px;  
				width: 300!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
			.removerOperador input{
				font-size: 20px;  
				width: 370!important;
				height: 50px;
				background-color: white;
				border: solid 1px;
				border-radius: 10px;
				margin-bottom: 15px;
			}
		</style>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Caixa</title>
	</head>
	
	<body>
		<div class="menu">
			<div class="botoesMenu">
				<form method="post">
					<button class="voltar" name='voltar'>Voltar</button>	
				</form>
				<button class="remover" id="remover" name="remover" onclick="excluirOperador(1)">Remover</button>
				<button class="novo" id="novo" name="novo" onclick="adicionarOperador(1)">Adicionar</button>
			</div>
		</div>
		<center>
			<div class="editarOperador" id="editarOperador">
				<center>
					<h3>Informe o novo caixa do operador</h3>
					<span>Caixa:</span>
					<select id="caixaNovoOperador" name="caixaNovoOperador">
						<option value="0">--</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
					</select>
					<button onclick="atualizarOperador()">Alterar</button>
					<button onclick="mostraAtualizaCaixa(0)">Cancelar</button>
				</center>
			</div>
			<div class="cadastrarOperador" id="cadastrarOperador">
				<center>
					<h3>Informe os dados do novo operador</h3>
					<span>Nome:</span>
					<input type="text" id="nomeOperador">
					<span>Caixa:</span>
					<select id="caixaOperador" name="caixaOperador">
						<option value="0">--</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
					</select>
					<br>
					<button onclick="realizarCadastro()">Cadastrar</button>
					<br>
					<button onclick="adicionarOperador(0)">Cancelar</button>
				</center>
			</div>
			<div class="removerOperador" id="removerOperador">
				<center>
					<h3>Informe o nome do operador a ser removido</h3>
					<span>Nome:</span>
					<input type="text" id="nomeremover" list="listaOperadores">
					<datalist id="listaOperadores">
					</datalist>
					<br>
					<button onclick="realizarremover()">remover</button>
					<br>
					<button onclick="excluirOperador(0)">Cancelar</button>
				</center>
			</div>
		</center>
		<div id="usuarios">
		</div>
		<?php include('../codigos_js/codigosAdminOperadores.php')?>
		
	</body>
</html>
