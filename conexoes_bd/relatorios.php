<?php
	include('conex.php');
	require_once __DIR__ . '/../vendor/autoload.php';
	
	$tipo = $_POST['tipo'];
	$caixas = $_POST['caixas'];
	$operadores = $_POST['operadores'];
	$pagamentos = $_POST['pagamentos'];
	$dataInicio = $_POST['dataInicio'];
	$dataFim = $_POST['dataFim'];
	$horaInicio = $_POST['horaInicio'];
	$horaFim = $_POST['horaFim'];
	
	$resultado = mysqli_query($conn, "SELECT * FROM log where /*nome in $operadores and*/ caixa in $caixas and pagamento in $pagamentos and data between '$dataInicio' and '$dataFim' and hora between '$horaInicio' and '$horaFim'");
	
	$consultas = array();
	global $vendas;
	$vendas = array();
	$totaisPorCaixa = [];
	$tipoPagamento = [];
	global $referencia;
	
	while ($linha = mysqli_fetch_assoc($resultado)) {
		$infoDecodificado = json_decode($linha['info'], true);
		$referencia = 1;
		if ($linha['pagamento'] === 'sangria') {
        		if (!isset($vendas[$linha['caixa']][$linha['nome']]['venda']['sangria'])) {
				$vendas[$linha['caixa']][$linha['nome']]['venda']['sangria'] = -$linha['valor'];
			} else {
				$vendas[$linha['caixa']][$linha['nome']]['venda']['sangria'] += -$linha['valor'];
			}
		} else {
			if($linha['pagamento'] === 'devolucao'){
				$linha['pagamento'] = 'dinheiro';
			}
			criaObjeto($infoDecodificado, $linha);
		}
	}
	
	$pagina = "<html><body>";
	foreach ($vendas as $caixa => $operadores) {
		$totalCaixa = 0;
				
		if($tipo == 1){
			$pagina .= "<h1>Caixa: " . $caixa . "</h1>";
		}
		foreach ($operadores as $operador => $venda) {
			$totalVenda = 0;
			if($tipo == 1){
				$pagina .= "<h2>Operador: " . $operador . "</h2>";
				    
				$pagina .= "<table style='border-spacing: 0'>";
				$pagina .= "<tr><td style='width: 230px; border: solid 1px black;'>Nome</td>";
				$pagina .= "<td style='width: 140px; border: solid 1px black; border-left: none;'>Quantidade</td>";
				$pagina .= "<td style='width: 100px; border: solid 1px black; border-left: none;'>Preco un.</td>";
				$pagina .= "<td style='width: 230px; border: solid 1px black; border-left: none;'>Valor Total</td>";
				$pagina .= "</tr>";
			}
			
			if(isset($venda['itens'])){ 
			foreach ($venda['itens'] as $index => $item) {
				$chaveSemPreco = rtrim($index, '0123456789.'); 
				    
				if($tipo == 1){
					$pagina .= "<tr>";
					$pagina .= "<td style='width: 230px; border: solid 1px black; border-top: none;'>" . $chaveSemPreco . "</td>";
					$pagina .= "<td style='width: 140px; border: solid 1px black; border-left: none; border-top: none;'>" . $item['quantidade'] . "</td>";
					$pagina .= "<td style='width: 100px; border: solid 1px black; border-left: none; border-top: none;'>R$" . number_format(floatval($item['preco']), 2) . "</td>";
					$valorTotal = floatval($item['quantidade']) * floatval($item['preco']);
					$pagina .= "<td style='width: 230px; border: solid 1px black; border-left: none; border-top: none;'>R$" . number_format($valorTotal, 2) . "</td>";
					$pagina .= "</tr>";
					$pagina .= "<br>";
				}
				if (isset($totaisPorItem[$index])) {
					$totaisPorItem[$index] += $item['quantidade'];
				} else {
					$totaisPorItem[$index] = $item['quantidade'];
				}
			}
			}
			if($tipo == 1){
				$pagina .= "</table>";
				$pagina .= "<br>";
			}
			if (isset($venda['venda'])) {
				if($tipo == 1){
					$pagina .= "<table style='border-spacing: 0'>";
					$pagina .= "<tr>";
					$pagina .= "<td style='width: 350px; border: solid 1px black;'>Forma de pagamento</td>";
					$pagina .= "<td style='width: 350px; border: solid 1px black; border-left: none;'>Total</td>";
					$pagina .= "</tr>";
				}
				foreach ($venda['venda'] as $formaPagamento => $valor) {
					if($tipo == 1){
						$pagina .= "<tr>";
						$pagina .= "<td style='width: 350px; border: solid 1px black; border-top: none;'>" . $formaPagamento . "</td>";
						$pagina .= "<td style='width: 350px; border: solid 1px black; border-left: none; border-top: none;'>R$" . number_format($valor, 2) . "</td>";
						$pagina .= "</tr>";
					}
					if(isset($tipoPagamento[$formaPagamento])){
						$tipoPagamento[$formaPagamento] += $valor;
					} else {
						$tipoPagamento[$formaPagamento] = $valor;
					}
					$totalVenda += $valor;
				}
				if($tipo == 1){
					$pagina .= "</table>";
					$pagina .= "<br>";
				}
			}
			if($tipo == 1){
				$pagina .= "Total da venda para o operador " . $operador . ": R$" . number_format($totalVenda, 2) . "<br>";
				$pagina .= "<hr>";
			}
			$totalCaixa += $totalVenda;
		}


		$totaisPorCaixa[$caixa] = $totalCaixa;
		if($tipo == 1){
			$pagina .= "<h3>Total do Caixa " . $caixa . ": R$" . number_format($totalCaixa, 2) . "</h3>";
			$pagina .= "<hr>";
		}
	}

	$totalGeral = array_sum($totaisPorCaixa);

	$pagina .= "<h1>Valor Total de Vendas: R$" . number_format($totalGeral, 2) . "</h1>";
	$pagina .= "<h3>Total de Itens Vendidos:</h3>";
		
	$totaisPorItemQuantidade = [];
	$totaisPorItemValor = [];

	foreach ($vendas as $caixa => $operadores) {
		foreach ($operadores as $operador => $venda) {
			if (isset($venda['itens'])) {
				foreach ($venda['itens'] as $index => $item) {
					$nomeItem = preg_replace('/\d+$/', '', $index);

					if (isset($totaisPorItemQuantidade[$nomeItem])) {
						$totaisPorItemQuantidade[$nomeItem] += $item['quantidade'];
					}else{
						$totaisPorItemQuantidade[$nomeItem] = $item['quantidade'];
					}

					$valorTotalItem = intval($item['quantidade']) * intval($item['preco']);
					if (isset($totaisPorItemValor[$nomeItem])) {
						$totaisPorItemValor[$nomeItem] += $valorTotalItem;
					}else{
						$totaisPorItemValor[$nomeItem] = $valorTotalItem;
					}
					
				}
			}
		}
	}
		
	$pagina .= "<table style='border-spacing: 0'>";
	$pagina .= "<tr><td style='width: 230px; border: solid 1px black;'>Nome</td>";
	$pagina .= "<td style='width: 230px; border: solid 1px black; border-left: none;'>Quantidade Total</td>";
	$pagina .= "<td style='width: 230px; border: solid 1px black; border-left: none;'>Valor Total</td>";
	$pagina .= "</tr>";
	foreach ($totaisPorItemQuantidade as $item => $quantidade) {
		$itemSemPreco = rtrim($item, '0123456789.'); 
				
		$pagina .= "<tr>";
		$pagina .= "<td style='width: 230px; border: solid 1px black; border-top: none;'>" . $itemSemPreco . "</td>";
		$pagina .= "<td style='width: 230px; border: solid 1px black; border-left: none; border-top: none;'>" . $quantidade . "</td>";
		$pagina .= "<td style='width: 230px; border: solid 1px black; border-left: none; border-top: none;'>R$" . number_format($totaisPorItemValor[$item], 2) . "</td>";
		$pagina .= "</tr>";
		$pagina .= "<br>";
	}
	$pagina .= "</table>";
	$pagina .= "<br>";
		
	$pagina .= "<table style='border-spacing: 0'>";
	$pagina .= "<tr>";
	$pagina .= "<td style='width: 350px; border: solid 1px black;'>Forma de pagamento</td>";
	$pagina .= "<td style='width: 350px; border: solid 1px black; border-left: none;'>Total</td>";
	$pagina .= "</tr>";
	foreach ($tipoPagamento as $formaPagamento => $valor) {
	
		$pagina .= "<tr>";
		$pagina .= "<td style='width: 350px; border: solid 1px black; border-top: none;'>" . $formaPagamento . "</td>";
		$pagina .= "<td style='width: 350px; border: solid 1px black; border-left: none; border-top: none;'>R$" . number_format($valor, 2) . "</td>";
		$pagina .= "</tr>";
	}
	$pagina .= "</table>";
	$pagina .= "<br>";

	$pagina .= "</body></html>";
	//echo $pagina;
	$arquivo = "teste.pdf";
	$mpdf = new \Mpdf\Mpdf(['tempDir' => '/var/www/html/tmp/mpdf']);
	$mpdf->addPage();
	$mpdf->writeHTML($pagina);

	$mpdf->Output('php://output', 'I');
	
	function criaObjeto($recebido, $linhaRecebida){
		global $vendas;
		global $referencia;
		foreach ($recebido as $chave => $item) {
			//confere se é combo
			if(preg_match('/^[0-9.,]+$/', $item['preco'])){
				if($linhaRecebida['pagamento'] == 'cortesia'){
					$index = $chave . " (" . $linhaRecebida['pagamento'] . ")";
				} else {
					$index = $chave . $item['preco'];
				}
			} else {
				if($linhaRecebida['pagamento'] == 'cortesia'){
					$index = $chave . " (" . $item['preco'] . ", " . $linhaRecebida['pagamento'] . ")";
				} else {
					$index = $chave . " (" . $item['preco'] . ")";
					
				}
			}
			if(isset($item['produtos'])){
				if($item['produtos'] != ''){
					$produtosCombo = json_decode($item['produtos'], true);
					criaObjeto($produtosCombo, $linhaRecebida);
				}
			}
			if(!isset($vendas[$linhaRecebida['caixa']])) {
				$vendas[$linhaRecebida['caixa']] = array(
					$linhaRecebida['nome'] => array(
						'venda' => array(
							$linhaRecebida['pagamento'] => $linhaRecebida['valor']
						),
						'itens' => array(
							$index => array(
								'quantidade' => $item['quantidade'],
								'preco' => $item['preco']
							)
						)
					)
				);
			} else {
				if(!isset($vendas[$linhaRecebida['caixa']][$linhaRecebida['nome']])) {
					$vendas[$linhaRecebida['caixa']][$linhaRecebida['nome']] = array(
						'venda' => array(
							$linhaRecebida['pagamento'] => $linhaRecebida['valor'],
						),
						'itens' => array(
							$index => array(
								'quantidade' => $item['quantidade'],
								'preco' => $item['preco']
							)
						)
					);
				} else {
					if($referencia === 1){
						if (!isset($vendas[$linhaRecebida['caixa']][$linhaRecebida['nome']]['venda'][$linhaRecebida['pagamento']])) {
							$vendas[$linhaRecebida['caixa']][$linhaRecebida['nome']]['venda'][$linhaRecebida['pagamento']] = $linhaRecebida['valor'];
						} else {
							if($item['quantidade'] < 0){
								$vendas[$linhaRecebida['caixa']][$linhaRecebida['nome']]['venda'][$linhaRecebida['pagamento']] -= $linhaRecebida['valor'];
								
							} else {
								$vendas[$linhaRecebida['caixa']][$linhaRecebida['nome']]['venda'][$linhaRecebida['pagamento']] += $linhaRecebida['valor'];
							}
						}
					}
							
					if (array_key_exists($index, $vendas[$linhaRecebida['caixa']][$linhaRecebida['nome']]['itens'])) {
						$vendas[$linhaRecebida['caixa']][$linhaRecebida['nome']]['itens'][$index]['quantidade'] += $item['quantidade'];
					} else {
						$vendas[$linhaRecebida['caixa']][$linhaRecebida['nome']]['itens'][$index] = array(
							'quantidade' => $item['quantidade'],
							'preco' => $item['preco']
						);
					}
				}
			}
			$referencia = 0;
		}
		return $vendas;
	}
?>
