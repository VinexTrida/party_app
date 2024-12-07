<?php?>

<script>
	$('#precoProduto').mask("#.##0,00", {reverse: true});

	var operadoresBD = {};
	var caixa;
	usuarios();
	function usuarios() {
		$.ajax({
			url: '../conexoes_bd/usuariosBD.php',
			type: "POST",
			dataType: "json",
			success: function (response) {
				operadoresBD = response;
				console.log(response);
				criaPagina();
			}
		});
	}
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
    function realizarEstorno(){
        var nome = document.getElementById("nomeProduto");
        var preco = document.getElementById("precoProduto");
        var quantidade = document.getElementById("quantidadeProduto");
	var operador = document.getElementById("operadoresRetirada");
        var produtos = {};
        produtos[nome.value] = {"quantidade": -quantidade.value, "preco": parseInt(preco.value), "produtos": null}
        var stringProdutos = JSON.stringify(produtos);
        var stringNumero = operador.value;

        alterarEstoque(nome.value, quantidade.value);
        setarLog(stringProdutos, operador.value, operadoresBD[operador.value].caixa, "devolucao", parseInt(preco.value) * parseInt(quantidade.value));
        console.log(parseInt(preco.value) * parseInt(quantidade.value));
		preco.value = "";
		quantidade.value = "";
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
    function setarLog(stringRecebido, usuarioPagina, caixa, formaPagamento, valor){
		$.ajax({
			url: '../conexoes_bd/setarLog.php',
			type: "POST",
			dataType: "json",      
			data: { stringRecebido: stringRecebido, usuarioPagina: usuarioPagina, caixa: caixa, formaPagamento: formaPagamento, valor: valor }
		});
	}
</script>
