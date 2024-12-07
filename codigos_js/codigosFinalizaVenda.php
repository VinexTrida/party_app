<?php?>

<script>
	$('#valorCliente').mask("#.##0,00", {reverse: true});
	
	var elementos;
	var precos;
	var subTotal;
	var troco;
	var precisaTroco;
	var caixa;
	var usuarioPagina;
	var resultado = {};
	var fmt = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });

	document.addEventListener('DOMContentLoaded', function() {
		usuarioPagina = "<?php echo $_SESSION['nome']?>";
		if(usuarioPagina == 'admin'){
			document.getElementById('cortesia').style.display = 'block';
		}
	    elementos = JSON.parse(localStorage.getItem('elementosString'));
	    precos = JSON.parse(localStorage.getItem('precosString'));
		for (const produto in elementos) {
			const quantidade = elementos[produto];
			const preco = precos[produto];
			if (preco !== undefined) {
				resultado[produto] = { quantidade: parseInt(quantidade), preco: parseFloat(preco), produtos: null };
			}
		}
	    conferirCaixa(usuarioPagina);
	    subTotal = 0;
	    for (var propriedade in elementos) {
	       	subTotal += elementos[propriedade] * precos[propriedade];
	    }
	    var precoFormatado = fmt.format(subTotal);
	    document.getElementById('subTotal').textContent = precoFormatado;
	    sessionStorage.setItem('carregaBody', 1);
	});

//-----------------------------------------------------------------------------------------------------------------------------//
	function conferirCaixa(usuarioPagina){
		$.ajax({
			url: '../conexoes_bd/conferirCaixa.php',
			type: "POST",
			dataType: "json",      
			data: {nome: usuarioPagina},
			success: function (response){
				caixa = response;
			}
		});
	}

//-----------------------------------------------------------------------------------------------------------------------------//
	var formaPagamento = "dinheiro";
	document.getElementById('dinheiro').addEventListener('click', function(){
		formaPagamento = "dinheiro";
		tornarPreto('dinheiro');
		tornarBranco('cartao');
		tornarBranco('pix');
		tornarBranco('cortesia');
		document.getElementById('dadosCliente').style.display = "block";
	});
	document.getElementById('cartao').addEventListener('click', function(){
		formaPagamento = "cartao";
		tornarPreto('cartao');
		tornarBranco('dinheiro');
		tornarBranco('pix');
		tornarBranco('cortesia');
		document.getElementById('dadosCliente').style.display = "none";
	});
	document.getElementById('pix').addEventListener('click', function(){
		formaPagamento = "pix";
		tornarPreto('pix');
		tornarBranco('cartao');
		tornarBranco('dinheiro');
		tornarBranco('cortesia');
		document.getElementById('dadosCliente').style.display = "none";
	});
	document.getElementById('cortesia').addEventListener('click', function(){
		formaPagamento = "cortesia";
		tornarPreto('cortesia');
		tornarBranco('cartao');
		tornarBranco('dinheiro');
		tornarBranco('pix');
		document.getElementById('dadosCliente').style.display = "none";
	});
//-----------------------------------------------------------------------------------------------------------------------------//
	function tornarPreto(elementId){
		document.getElementById(elementId).style.color = 'Black';
	}

//-----------------------------------------------------------------------------------------------------------------------------//
	function tornarBranco(elementId){
		document.getElementById(elementId).style.color = 'white';
	}
	
//-----------------------------------------------------------------------------------------------------------------------------//
	document.addEventListener('keydown', function(event) {
  		if (event.key === 'Enter' || event.keyCode === 13) {
			document.activeElement.blur();
    			pagamentoVenda();
  		}
	});

//-----------------------------------------------------------------------------------------------------------------------------//
	document.getElementById('finaliza').addEventListener('click', function(){
		pagamentoVenda();
	});

//-----------------------------------------------------------------------------------------------------------------------------//
	function pagamentoVenda(){
		var valorCliente = document.getElementById('valorCliente').value;
		var valorClienteConvertido = parseFloat(valorCliente.replace(',', '.'))
		var finaliza = document.getElementById('finaliza');
		if(formaPagamento === "dinheiro"){
			if(isNaN(valorClienteConvertido)){
				finaliza.style.display = 'none';
				precisaTroco = 0;
				conferirEstoque(usuarioPagina);
			}else{
				if(valorClienteConvertido == subTotal){
					finaliza.style.display = 'none';
					precisaTroco = 1;
					troco = 0;
					conferirEstoque(usuarioPagina);
				}else{
					if(valorClienteConvertido < subTotal){
						var resultado = document.getElementById('resultado');
						resultado.textContent = ("ERRO! Valor insuficiente");
					}
					else{
						finaliza.style.display = 'none';
						precisaTroco = 1;
						troco = valorClienteConvertido - subTotal;
						conferirEstoque(usuarioPagina);
					}
				}
			}
		}else{
			precisaTroco = 0;
			conferirEstoque(usuarioPagina);
			finaliza.style.display = 'none';
		}
	}

//-----------------------------------------------------------------------------------------------------------------------------//
	var quantidadeItens = {};
	function conferirEstoque(usuarioPagina) {
	    $.ajax({
		url: '../conexoes_bd/atualizaDados.php',
		type: "POST",
		dataType: "json",
		success: function (response) {
		    quantidadeItens = response;
		    var cont = 0;

		    for (var nome in elementos) {
			if ((parseInt(quantidadeItens[nome].quantidade) >= elementos[nome]) || quantidadeItens[nome].inerente == '1') {
		            cont = 1;
		        } else {
		            cont = 0;
		            break;
		        }

		        if (quantidadeItens[nome].combo == 1) {
			    cont = 0;
		            var itensLista = JSON.parse(quantidadeItens[nome].itens);
		            for (var itens in itensLista) {
		                if ((itensLista[itens] * elementos[nome]) <= parseInt(quantidadeItens[itens].quantidade) || quantidadeItens[itens].inerente == 1) {
		                    cont = 1;
		                } else {
		                    cont = 0;
		                    break;
		                }
		            }
		            if (cont == 0) {
		                break;
		            }
				for(var itens in itensLista){
					itensLista[itens] = { quantidade: itensLista[itens] * elementos[nome], preco: nome};
				}
				quantidadeItens[nome].itens = JSON.stringify(itensLista);
				resultado[nome].produtos = quantidadeItens[nome].itens;
		        }
		    }

		    if (cont === 1) {
		        setarLog(JSON.stringify(resultado), usuarioPagina, caixa, subTotal);
		        confirmar();
		    } else {
		        sessionStorage.setItem('carregaBody', 0);
		        alert("Algum dos itens selecionados não se encontra mais em tal quantidade no estoque. \nRefaça o pedido.");
		    }
		}
	    });
	}
	
//-----------------------------------------------------------------------------------------------------------------------------//
	function setarLog(stringRecebido, usuarioPagina, caixa, valor){
		$.ajax({
			url: '../conexoes_bd/setarLog.php',
			type: "POST",
			dataType: "json",      
			data: { stringRecebido: stringRecebido, usuarioPagina: usuarioPagina, caixa: caixa, formaPagamento: formaPagamento, valor: valor }
		});
	}

//-----------------------------------------------------------------------------------------------------------------------------//
	function confirmar(){
	   	var resultado = document.getElementById('resultado');
	   	var sair = document.getElementById('sair');
	   		
	   	sessionStorage.setItem('carregaBody', 0);
	   		
	   	if(precisaTroco === 1){
	   		if(troco === 0){
	   			resultado.textContent = "Não é preciso troco.";
	   		} else {
	   			resultado.textContent = "Troco " + fmt.format(troco);
	   		}
	   	} else {
	   		resultado.textContent = "Venda finalizada.";
	   	}
		sair.name = "sair";
			
		for(var nome in elementos){
			if(quantidadeItens[nome].combo == 1){
				var itensLista = JSON.parse(quantidadeItens[nome].itens);
				for (var itens in itensLista) {
					//Reduz estoque dos produtos do combo
					if(!(quantidadeItens[itens].inerente === '1')){
						reduzir_estoque(itens, itensLista[itens].quantidade * parseInt(elementos[nome]), nome, (quantidadeItens[itens].quantidade - itensLista[itens].quantidade), 2);
					}else{
						reduzir_estoque(itens, itensLista[itens].quantidade, nome, quantidadeItens[itens].quantidade, 2);
					}
				}
				//Redeuz estoque do combo
				if(!(quantidadeItens[nome].inerente === '1')){
					reduzir_estoque(nome, null, null, (quantidadeItens[nome].quantidade - elementos[nome]), 0);
				}else{
					reduzir_estoque(nome, null, null, quantidadeItens[nome].quantidade, 0);
				}

			} else {
				//Reduz estoque dos produtos unitarios
				if(!(quantidadeItens[nome].inerente === '1')){
					reduzir_estoque(nome, null, null, (quantidadeItens[nome].quantidade - elementos[nome]), 1);
				}else{
					reduzir_estoque(nome, null, null, quantidadeItens[nome].quantidade, 1);
				}
			}
		}
	}
	
//-----------------------------------------------------------------------------------------------------------------------------//
	function reduzir_estoque(nome, itens, nomePreco, quantidade, recebido){
		$.ajax({
			url: '../conexoes_bd/reduzirEstoque.php',
			type: "POST",
			dataType: "json",
			async: false,  
			data: { nome: nome, quantidade: quantidade},
			success: function (response) {
				//Itens unitarios
				if(recebido == 1){
					for(var i = 1; i <= elementos[nome]; i++){
						imprimir(quantidadeItens[nome].id, nome.toUpperCase(), usuarioPagina.toLowerCase(), fmt.format(precos[nome]), elementos[nome], i);
					}
				}
				//Itens de combo
				if(recebido == 2){
					for(var i = 1; i <= (itens * elementos[nomePreco]); i++){
						imprimir(quantidadeItens[nome].id, nome.toUpperCase(), usuarioPagina.toLowerCase(), nomePreco, (itens * elementos[nomePreco]), i);
					}
				}
			}
		});
	}

//-----------------------------------------------------------------------------------------------------------------------------//
	function imprimir(id, nome, usuario, preco, qtdTotal, qtdAtual){
		$.ajax({
			url: '../conexoes_bd/imprimir.php',
			type: "POST",
			dataType: "json",
			async: false, 
			data: { id: id, nome: nome, usuario: usuario, caixa: caixa, preco: preco, pagamento: formaPagamento.toUpperCase(), quantidadeTotal: qtdTotal, quantidadeAtual: qtdAtual }
		});
	}
</script>
