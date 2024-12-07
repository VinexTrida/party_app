<?php
	include('../conexoes_bd/conex.php');
?>
<script>
	var fmt = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });
	var admin = '<?php echo $_SESSION['admin'] ?>';
	var logBD = {};
	vendas("nome = '<?php echo $_SESSION['nome']?>' and data = '<?php echo date('Y-m-d')?>'");
	
	function vendas(recebido){
		$.ajax({
			url: '../conexoes_bd/consultaLog.php',
			type: "POST",
			dataType: "json",
			data: { consulta: recebido },
			success: function (response) {
				logBD = response;
				criaPagina();
			}
		});
	}
	function criaPagina(){
		for (var id in logBD) {
			var container = document.getElementById("itens");;
			if (logBD.hasOwnProperty(id)) {
				var divProduto = document.createElement('div');
				divProduto.className = 'item';
				divProduto.id = 'id' + id;

				// Conteúdo da div
				divProduto.innerHTML = `
					<center>
						<span class="">${logBD[id].data}</span>
						<span class="">${logBD[id].hora}</span>
						<br>
						<span class="total">${fmt.format(logBD[id].valor)}</span>
						<button class="reimprimir" onclick="reimprimir(${id})">Reimprimir</button>
					</center>
				`;		
				container.appendChild(divProduto);
			}			
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function reimprimir(recebido){
		const elementos = JSON.parse(logBD[recebido].info);
		for(var nome in elementos){
			console.log(elementos);
			if(elementos[nome].produtos != null){
				const itensCombo = JSON.parse(elementos[nome].produtos);
				for(var itens in itensCombo){
					for(var i = 1; i <= itensCombo[itens].quantidade; i++){
						imprimir(recebido, itens.toUpperCase(), logBD[recebido].nome.toLowerCase(), logBD[recebido].caixa, itensCombo[itens].preco, logBD[recebido].pagamento, itensCombo[itens].quantidade, i);
					}
				}
			} else {
				for(var i = 1; i <= elementos[nome].quantidade; i++){
					imprimir(recebido, nome.toUpperCase(), logBD[recebido].nome.toLowerCase(), logBD[recebido].caixa, fmt.format(elementos[nome].preco), logBD[recebido].pagamento, elementos[nome].quantidade, i);
				}
			}
		}
	}
	
	function imprimir(id, nome, usuario, caixa, preco, pagamento, qtdTotal, qtdAtual){
		$.ajax({
			url: '../conexoes_bd/imprimir.php',
			type: "POST",
			dataType: "json",
			async: false,      
			data: { id: id, nome: nome, usuario: usuario, caixa: caixa, preco: preco, pagamento: pagamento.toUpperCase(), quantidadeTotal: qtdTotal, quantidadeAtual: qtdAtual }
		});
	}
</script>
