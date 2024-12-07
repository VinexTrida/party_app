<?php?>
<script>
	// Mascara jQuery para input de valor
	$('#precoProduto').mask("#.##0,00", {reverse: true});

	var operadoresBD = {};
	var caixa;
	usuarios();
	// Função que cria um objeto com os usuarios cadastrados no banco de dados
	function usuarios() {
		$.ajax({
			url: '../conexoes_bd/usuariosBD.php',
			type: "POST",
			dataType: "json",
			success: function (response) {
				operadoresBD = response;
				criaPagina();
			}
		});
	}
	// Função que cria as opções para o input de usuarios
	function criaPagina() {
	    for (var nome in operadoresBD) {
			var container = document.getElementById('operadoresRetirada');
			container.innerHTML += `
				<option value="${nome}" style="text-align: center">${nome}</option>
			`;
	    }
	}

    var objetosBD ={};
    objetos();
	// Função que cria um objeto com os produtos cadastrados no banco de dados
    function objetos() {
		$.ajax({
			url: '../conexoes_bd/objetoBD.php',
			type: "POST",
			dataType: "json",
			success: function (response) {
				objetosBD = response;
				criaListaProdutos();
			}
		});
	}
	// Função que cria as opções para o input de produtos
	function criaListaProdutos(){
		for (var nome in objetosBD) {
			if(objetosBD[nome].combo == false){
				var container = document.getElementById('nomeProduto');
				container.innerHTML += `
					<option value="${nome}" style="text-align: center">${nome}</option>
				`;
			}
		}
	}
	// Função chamada pelo botão de confirmação do estorno
    function realizarEstorno(){
        var nome = document.getElementById("nomeProduto");
        var preco = document.getElementById("precoProduto");
        var quantidade = document.getElementById("quantidadeProduto");
		var operador = document.getElementById("operadoresRetirada");
        var produtos = {};
		// Cria um objeto com a quantidade negativa, que será salvo na tabela de logs, para que no relatório final ele desconte esses produtos
        produtos[nome.value] = {"quantidade": -quantidade.value, "preco": parseInt(preco.value), "produtos": null}
        var stringProdutos = JSON.stringify(produtos);
        var stringNumero = operador.value;

        alterarEstoque(nome.value, quantidade.value);
        setarLog(stringProdutos, operador.value, operadoresBD[operador.value].caixa, "devolucao", parseInt(preco.value) * parseInt(quantidade.value));
		preco.value = "";
		quantidade.value = "";
    }
	// Função que aumenta a quantidade do produto no estoque total do banco de dados de acordo com o que foi devolvido
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
	// Função que grava a devolução na tabela de logs do banco de dados
    function setarLog(stringRecebido, usuarioPagina, caixa, formaPagamento, valor){
		$.ajax({
			url: '../conexoes_bd/setarLog.php',
			type: "POST",
			dataType: "json",      
			data: { stringRecebido: stringRecebido, usuarioPagina: usuarioPagina, caixa: caixa, formaPagamento: formaPagamento, valor: valor }
		});
	}
</script>