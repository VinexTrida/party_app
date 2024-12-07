<?php?>
<script>
	var fmt = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });
	var admin = '<?php echo $_SESSION['admin'] ?>';
	var logBD = {};
	//vendas("data = '<?php echo date('Y-m-d')?>'");
	vendas('1');
	
	function vendas(recebido){
		$.ajax({
			url: '../conexoes_bd/consultaLog.php',
			type: "POST",
			dataType: "json",
			data: { consulta: recebido },
			success: function (response) {
				logBD = response;
				console.log(response);
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
						<span class="total">${fmt.format(logBD[id].valor)}</span>
						<button class="reimprimir" onclick="excluir(${logBD[id].id}, ${id})">Excluir</button>
					</center>
				`;		
				container.appendChild(divProduto);
			}			
		}
	}
	function excluir(recebido, id){
		$.ajax({
			url: '../conexoes_bd/excluirLog.php',
			type: "POST",
			dataType: "json",
			data: { id: recebido },
			success: function (response) {
				var itemRestaurado = JSON.parse(logBD[id].info);
				for(let item in itemRestaurado){
					if(itemRestaurado[item].produtos != null){
						var listaItens = JSON.parse(itemRestaurado[item].produtos);
						for(let produto in listaItens){
							alterarEstoque(produto, listaItens[produto].quantidade);
						}
					}
					alterarEstoque(item, itemRestaurado[item].quantidade);
				}
				location.reload();
			}
		});
	}
	function alterarEstoque(nome, quantidade) {
		$.ajax({
			url: '../conexoes_bd/atualizaEstoque.php',
			type: "POST",
			dataType: "json",      
			data: { nome: nome, quantidade: quantidade },
			success: function (response) {
			}
		});
	}
</script>
