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
		}
		button{
			border: none;
			background-color: transparent;
			height: 50px;
			width: 50px;
		}
		.menu{
			background-color: #4d81be;
			display: block;
			margin-top: -7px;
			margin-left: -8px;
			margin-right: -7px;
  			overflow: auto;
			margin-bottom: 15px;
		}
		.redirect{
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
			background-image: url('../imagens/cupons/voltar.png');
			background-repeat: no-repeat;
	    	background-position: 123px center;
	    	background-size: 32px 32px;
		}
		.redirect:hover{
			letter-spacing: 2px;
			background-color: rgba(255, 255, 255, 0.3);
			background-position: 127px center;
		}
		.item{
			padding-left: 10px;
			vertical-align: middle;
			margin-top: 7.2px;
			background-color: #e4e8f0;
			height: 65px;
			border-radius: 10px;
			font-size: 20px;
			display: grid;
			align-items: center;
			position: relative;	
			
		}
		.item button{
			font-size: 20px;
			width: 160px;
			float: right;
			color: red;
			transform: translateY(-28%);
			position:relative;	
			transition: background-color 0.2s;
			font-size: 25px;
			background-image: url('../imagens/cupons/lixeira.png');
			background-repeat: no-repeat;
	    	background-position: 120px 5px;
	    	background-size: 35px 35px;
			margin-top: 22px;
		}	
		.item span{
			margin-top: 20px;
			margin-left: 10px;
			float: left;
			position:relative;			
		}
		
	</style>
	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Caixa</title>
</head>
<body>
        <div class="menu">
            <form method="post">
                <button class="redirect" name='voltar'>Voltar</button>
            </form>
        </div>
        <div class="itens" id="itens">
        </div>
             <?php include('../codigos_js/codigosAdminCupons.php')?>
	</body>
</html>
