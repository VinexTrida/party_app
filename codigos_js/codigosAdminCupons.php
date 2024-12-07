<?php?>
<script>
	// Cria uma variavel para formatar numeros no formato da moeda brasileira (R$0,00)
	var fmt = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });
	var admin = '<?php echo $_SESSION['admin'] ?>';
	var logBD = {};
	// Essa linha comentada serve para q na pagina de log de venda, só apareça as vendas do dia atual
	//vendas("data = '<?php echo date('Y-m-d')?>'");
	vendas('1');
	
	// Essa função serve para consultar o banco de dados e retornar um objeto com todas as vendas feitas
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
	// Função que cria as divs das vendas
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
						<span class="total">${fmt.format(logBD[id].valor)}</span>
						<button class="reimprimir" onclick="excluir(${logBD[id].id}, ${id})">Excluir</button>
					</center>
				`;		
				container.appendChild(divProduto);
			}			
		}
	}

	// Função para excluir a venda selecionada do banco de dados e retornar os itens para o estoque
	function excluir(recebido, id){
		$.ajax({
			url: '../conexoes_bd/excluirLog.php',
			type: "POST",
			dataType: "json",
			data: { id: recebido },
			success: function (response) {
				var itemRestaurado = JSON.parse(logBD[id].info);
				for(let item in itemRestaurado){
					// Confere se o produto é um combo
					if(itemRestaurado[item].produtos != null){
						var listaItens = JSON.parse(itemRestaurado[item].produtos);
						// Estorna os produtos do combo
						for(let produto in listaItens){
							alterarEstoque(produto, listaItens[produto].quantidade);
						}
					}
					// Estorna os produtos (também estorna o combo como produto, não seus itens internos)
					alterarEstoque(item, itemRestaurado[item].quantidade);
				}
				location.reload();
			}
		});
	}
	// Função que adiciona os produtos novamente ao banco de dados
	function alterarEstoque(nome, quantidade) {
		$.ajax({
			url: '../conexoes_bd/atualizaEstoque.php',
			type: "POST",
			dataType: "json",      
			data: { nome: nome, quantidade: quantidade }
		});
	}
</script>