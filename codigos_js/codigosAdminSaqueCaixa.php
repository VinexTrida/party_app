<?php?>
<script>
	$('#valorRetirada').mask("#.##0,00", {reverse: true});
	var fmt = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });
	
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
	function geraSangria(){
		var usuario = document.getElementById('operadoresRetirada').value;
		var valor = document.getElementById('valorRetirada').value;
		valor=valor.replace('.', '');
		valor = parseFloat(valor.replace(',', '.'));
		console.log(valor);
		conferirCaixa(usuario, valor);
	}
	function setarLog(usuario, valor, caixa){
		$.ajax({
			url: '../conexoes_bd/setarLog.php',
			type: "POST",
			dataType: "json",      
			data: { stringRecebido: "sangria", usuarioPagina: usuario, caixa: caixa, formaPagamento: "sangria", valor: (valor * (-1)) },
			success: function (response){
				imprimir('SANGRIA', usuario, fmt.format(valor), caixa);
				var conteudo = document.getElementById('valorRetirada');
				conteudo.value = '';
			}
		});
	}
	function conferirCaixa(usuarioPagina, valor){
		$.ajax({
			url: '../conexoes_bd/conferirCaixa.php',
			type: "POST",
			dataType: "json",      
			data: {nome: 'admin'},
			async: false,
			success: function (response){
				caixa = response;
				setarLog(usuarioPagina, valor, caixa);
			}
		});
	}
	function imprimir(nome, usuario, preco, caixa){
		$.ajax({
			url: '../conexoes_bd/imprimir.php',
			type: "POST",
			dataType: "json",
			async: false, 
			data: { nome: nome, usuario: usuario, caixa: caixa, preco: preco, pagamento: 'SANGRIA', quantidadeTotal: 1, quantidadeAtual: 1 },
			success: function (response){
			}
		});
	}
</script>
