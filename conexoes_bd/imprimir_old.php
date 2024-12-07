<?php
	require_once __DIR__ . '/../vendor/autoload.php';

	$nome = $_POST['nome'];
	$preco = $_POST['preco'];
	$usuario = $_POST['usuario'];
	$caixa = $_POST['caixa'];
	$hora = date("H:i");
	$pagamento = $_POST['pagamento'];
	$imagem = "Logo Colégio Cultura sem fundo";
	$localImagem = __DIR__ . '/var/www/html/imagens/saoCristovao.png';
	

	$mpdf = new \Mpdf\Mpdf(['tempDir' => '/var/www/html/tmp/mpdf']);
	$mpdf->WriteHTML("<div style=\"text-align:center\"><img src=\"/var/www/html/imagens/$imagem.png\" style=\"width: 450px; height: 450px\"></div>");
	$mpdf->WriteHTML("<div style=\"text-align:center; margin-top:100px\"><span style=\"font-size:100px;\">$nome</span><br></div>");
	$mpdf->WriteHTML("<div style=\"text-align:center\"><span style=\"font-size:50px;\">$preco</span><br></div>");
	$mpdf->WriteHTML("<div style=\"text-align:center; margin-top:100px\"><span style=\"font-size:30px; margin-bottom:100px\">Hora:$hora / F.PGTO:$pagamento</span><br></div>");
	$mpdf->WriteHTML("<div style=\"text-align:center; margin-top:10px\"><span style=\"font-size:20px; \">.</span><br></div>");

	$mpdf->Output("/var/www/html/cartoes/$nome$usuario", 'F');
	passthru("cd ../cartoes; lp -d caixa$caixa $nome$usuario");	
?>
