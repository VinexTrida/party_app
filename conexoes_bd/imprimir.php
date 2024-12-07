<?php
	require_once __DIR__ . '/../vendor/autoload.php';
	
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$preco = $_POST['preco'];
	$usuario = $_POST['usuario'];
	$caixa = $_POST['caixa'];
	$hora = date("H:i");
	$pagamento = $_POST['pagamento'];
	$quantidadeTotal = $_POST['quantidadeTotal'];
	$quantidadeAtual = $_POST['quantidadeAtual'];
	$imagem = "escola.jpg";
	
	$pagina = "<html><body>";
	
	$pagina .= "<div style=\"text-align:center\">";
	$pagina .= "<img src=\"/var/www/html/imagens/$imagem\" style=\"width: 450px;\">";
	$pagina .= "<br>";
	$pagina .= "<br>";
	$pagina .= "<div style=\"height: 100px\">";
	$pagina .= "<span style=\"font-size:80px\">$nome</span>";
	$pagina .= "</div>";
	$pagina .= "<br>";
	$pagina .= "<span style=\"font-size:50px;\">$preco</span>";
	$pagina .= "<br>";

	if($pagamento == 'SANGRIA'){
		$pagina .= "<span style=\"font-size:30px\">Hora:$hora / $usuario</span>";
	} else{
		$pagina .= "<span style=\"font-size:30px\">Hora:$hora / F.PGTO:$pagamento</span>";
	}

	$pagina .= "<br>";
	$pagina .= "<span style=\"font-size:20px\">.</span>";
	$pagina .= "<br>";
	$pagina .= "<span style=\"font-size:30px\">$quantidadeAtual/$quantidadeTotal</span>";
	$pagina .= "</div>";
	
	$pagina .= "</body></html>";
	
	sleep(0.2);
	
	$mpdf = new \Mpdf\Mpdf();
	$mpdf->WriteHTML($pagina);
	$mpdf->Output("/var/www/html/cartoes/$id$usuario", 'F');	
	passthru("cd ../cartoes; lp -d caixa$caixa $id$usuario");
	
	echo true;	
?>
