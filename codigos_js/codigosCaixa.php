<?php?>
<script>
	var objetosBD ={};
	var quantidadeItens = {};
	var elementos = {};
	var conta = 0;
	var body = sessionStorage.getItem('carregaBody');
	var fmt = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });
	
	administrador(<?php echo $_SESSION['admin']?>);
	function administrador(recebido){
		if(recebido === 0){
			document.getElementById("dropdown").style.display = "none";
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//	
	objetos();
	setInterval(objetos, 1000);
	function objetos() {
		$.ajax({
			url: '../conexoes_bd/objetoBD.php',
			type: "POST",
			dataType: "json",
			success: function (response) {
				var objetoUm = Object.keys(objetosBD);
				var objetoDois = Object.keys(response);
				objetosBD = response;
				if(objetoUm.length !== objetoDois.length && conta == 1){
					location.reload(true);
				}
				if(conta == 0){
					criaPagina();
				}
				conta = 1;
			}
		});
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function criaPagina() {
	    	for (var nomeProduto in objetosBD) {
	    		var controleInterno = false;
	    		if(<?php echo $_SESSION['admin']?>){
	    			controleInterno = true;
	    		} else {
	    			var stringUsada = "<?php echo $_SESSION['nome']?>";
	    			if(objetosBD[nomeProduto].caixas.includes(stringUsada.replace(/\D/g, '') + ",")){
	    				controleInterno = true;
	    			}
	    		}
	    		if(controleInterno){
				var container = document.getElementById('itens');
				
				if (objetosBD.hasOwnProperty(nomeProduto)) {
					if (!document.getElementById('id' + nomeProduto)){
						var divProduto = document.createElement('div');
						
						divProduto.className = 'item';
						divProduto.id = 'id' + nomeProduto;

						divProduto.innerHTML = `
							<center>
								<p id="${nomeProduto}">${nomeProduto} <span class="preco" id="preco${nomeProduto}"></span></p> 
								<div class="botoes">
									<button class="menos" id="decrement${nomeProduto}">-</button>
									<input class="insert" id="counter${nomeProduto}" type="text" inputmode="decimal" value="0">
									<button class="mais" id="increment${nomeProduto}">+</button>
								</div>
								<span class="quantidade" id="quantidade${nomeProduto}"></span>
							</center>
						`;

						container.appendChild(divProduto);
					}
				}
			}
	    	}
	    	if(controleInterno){
		    	var precoFormatado = fmt.format(0);
		    	
			document.getElementById('subTotal').textContent = precoFormatado;
			comandosPagina();
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function comandosPagina(){
		if(body != 0 && body != null){
			var elementoSalvo = JSON.parse(localStorage.getItem('elementosString'));
			elementos = elementoSalvo;
			
			for(var nome in elementos){
				var counter = document.getElementById('counter' + nome);
				if(counter.value == null){
				counter.value = 0;
				}
				valorAtual = parseInt(counter.value) + elementos[nome];
				
				if(valorAtual <= objetosBD[nome].quantidade || objetosBD[nome].inerente === '1'){
					counter.value = parseInt(valorAtual);
					
					setar_valores(elementos);
				}
			}
			
			var precoFormatado = fmt.format(calcularSubTotal(elementoSalvo));
			document.getElementById('subTotal').textContent = precoFormatado;
			document.getElementById('enviaSubTotal').value = calcularSubTotal(elementoSalvo);
		}
		
		for (var nomeProduto in objetosBD) {
			incrementDecrement(nomeProduto);
		}
		atualizarValores();
		setInterval(atualizarValores, 2000);
	}
	
	function atualizarValores(){//Função que contem todas as chamadas dos itens para verirficar sua quantidade no estoque
		for (var nomeProduto in objetosBD) {
			visibilidade_quantidade_itens(nomeProduto);
			atualizar_preco(nomeProduto);
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function visibilidade_quantidade_itens(nome){
		var elementoVis = document.getElementById("id" + nome);
		var elementoQua = document.getElementById("quantidade" + nome);

		if(objetosBD[nome].combo == 1){
			var itensLista = JSON.parse(objetosBD[nome].itens);
			for(var itens in itensLista){
				if(objetosBD[nome].emUso === '1' && (objetosBD[nome].quantidade > '0' || objetosBD[nome].inerente === '1')){
					if(parseInt(objetosBD[itens].quantidade) >= parseInt(itensLista[itens]) || objetosBD[itens].inerente === '1'){
						elementoVis.style.display = 'flex';
					} else {
						elementoVis.style.display = 'none';
						break;
					}
				} else{
					elementoVis.style.display = 'none';
					break;
				}
			}
		}else{
			if (objetosBD[nome].emUso === '1' && (objetosBD[nome].quantidade > '0' || objetosBD[nome].inerente === '1')) {
				elementoVis.style.display = 'flex'; // Mostra o elemento
			} else {
				elementoVis.style.display = 'none'; // Oculta o elemento
			}
		}
		if (objetosBD[nome].inerente === '1'){
			elementoQua.style.display = 'none'
		} else {
			elementoQua.textContent = objetosBD[nome].quantidade;
			elementoQua.style.display = 'flex'
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function atualizar_preco(nome) {
    		var precoFormatado = fmt.format(objetosBD[nome].preco);
		document.getElementById("preco" + nome).textContent = precoFormatado;
	}
//-----------------------------------------------------------------------------------------------------------------------------//

        function incrementDecrement(nome) {//Atualiza a quantidade do item desejado 
	    	var valorAtual = 0;
	    	
	    	document.getElementById('counter' + nome).addEventListener('input', function() {
			var counter = document.getElementById('counter' + nome);
			var resultado = objetosBD[nome].quantidade - counter.value;

			if(resultado >= 0 || objetosBD[nome].inerente == '1') {
				
			    	elementos[nome] = parseInt(counter.value);
			    	
			    	if(isNaN(elementos[nome])){
			    		delete elementos[nome];
			    	}
			    	
			    	setar_valores(elementos);
			    	
			}else{
				counter.value = 0;
			    	delete elementos[nome];
			    	
			    	setar_valores(elementos);
			}
    		});
		
		document.getElementById('increment' + nome).addEventListener('click', function() {
			var counter = document.getElementById('counter' + nome);
			valorAtual = parseInt(counter.value) + 1;

			if(valorAtual <= objetosBD[nome].quantidade || objetosBD[nome].inerente == '1') {
			   	counter.value = valorAtual;
			    	elementos[nome] = valorAtual;
			    	
			    	setar_valores(elementos);
			}
    		});
    		
    		document.getElementById('decrement' + nome).addEventListener('click', function() {
			var counter = document.getElementById('counter' + nome);
			valorAtual = parseInt(counter.value) - 1;

			if(valorAtual >= 0) {
			   	counter.value = valorAtual;
			    	elementos[nome] = valorAtual;
			    	
			    	setar_valores(elementos);
			}
			if(valorAtual == 0) {
			   	counter.textContent = valorAtual;
			    	delete elementos[nome];
			    	
			    	setar_valores(elementos);
			}
    		});
	}
	function setar_valores(elementos){
		const precos = {};
    		for (const key in objetosBD) {
			if (objetosBD.hasOwnProperty(key)) {
		    		precos[key] = objetosBD[key].preco;
			}
    		}
		
		localStorage.setItem('elementosString', JSON.stringify(elementos));
		localStorage.setItem('precosString', JSON.stringify(precos));
		
    		var precoFormatado = fmt.format(calcularSubTotal(elementos));
		document.getElementById('subTotal').textContent = precoFormatado;
		document.getElementById('enviaSubTotal').value = calcularSubTotal(elementos);
	}

//-----------------------------------------------------------------------------------------------------------------------------//
	function calcularSubTotal(elementosST) {//Calcula o valor total do pedido comparado a quantidade de cada elemento com seu respectivo preço
	    	var subTotal = 0;
	    	for (var nomeProduto in elementosST) {
		    	if(elementosST[nomeProduto] == null){
		    		elementosST[nomeProduto] = 0;
		    	}
			subTotal += elementosST[nomeProduto] * objetosBD[nomeProduto].preco;
		}
	    	return subTotal;
	}

//-----------------------------------------------------------------------------------------------------------------------------//
	function validarEnvio(){//Verifica se o valor da compra é maior que zero quando o subtotal é pressionado, se não for, cancela o envio do formulário
		var subTotal = parseInt(document.getElementById('enviaSubTotal').value);
		
		for(var nome in elementos){
			if(elementos[nome] > objetosBD[nome].quantidade && objetosBD[nome].inerente == 0){
				elementos = {};
				alert('Faça o pedio novamente, estoque atualizado');
				setar_valores(elementos);
		    		return false;
		    		break;
			}
		}

		if (subTotal == 0) {
		    alert('Não é possível dar subtotal sem nenhum item selecionado.');
		    return false;
		}
		
		return true;
	}
</script>
