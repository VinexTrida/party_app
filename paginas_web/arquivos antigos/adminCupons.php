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
			background-color: #2f2e2e;
		}
		button{
			border: none;
			background-color: transparent;
			height: 50px;
			width: 50px;
		}
		.menu{
			background-color: #707070; 
			display: block;
			margin-top: -7px;
			margin-left: -8px;
			margin-right: -7px;
  			overflow: auto;
		}
		.menu button{
			width: 85px!important;
		}
		.redirect{
			width: 50px;
			transition: letter-spacing 0.2s;
			height: 50px;
			display: block;
			float: right;
			color: black;
			cursor: pointer;
			transition: background-color 0.2s;
			font-size: 25px;
		}
		.redirect:hover{
			letter-spacing: 2px;
			background-color: rgba(255, 255, 255, 0.3);
		}
		.item{
			padding-left: 10px;
			margin-top: 2px;
			background-color: white;
			height: 60px;
			border-radius: 10px;
			font-size: 20px;	
			display: grid;
			align-items: center;
			position: relative;
		}
		.item button{
			font-size: 20px;
			width: auto!important;
			float: right;
			top: 50%;
			color: red;
			transform: translateY(-35%);
			position:relative;	
		}	
		.item span{
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
