<?php?>
<script>
	$('#precoItem').mask("#.##0,00", {reverse: true});
	$('#precoCadastro').mask("#.##0,00", {reverse: true});
	$('#precoCombo').mask("#.##0,00", {reverse: true});
	objetos();
	var objetosBD ={};
	var quantidadeItens = {};
	var caixasProdutos = {};
	var selecionado;
	var fmt = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });
	function objetos() {
		$.ajax({
			url: '../conexoes_bd/objetoBD.php',
			type: "POST",
			dataType: "json",
			success: function (response) {
				objetosBD = response;
				criaPagina();
			}
		});
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function criaPagina(){
		for (var nomeProduto in objetosBD) {
			var container = document.getElementById("itens");;
			if (objetosBD.hasOwnProperty(nomeProduto)) {
				// Cria uma div para cada produto
				var divProduto = document.createElement('div');
				divProduto.className = 'item';
				divProduto.id = 'id' + nomeProduto; // Assume que o nome do produto não contém espaços

				// Conteúdo da div
				divProduto.innerHTML = `
					<div>
						<p id="${nomeProduto}">${nomeProduto} ${fmt.format(objetosBD[nomeProduto].preco)}</p>
						<button class="posicao" onclick="alteraPosicao('${nomeProduto}')">Altera Posição</button>
					</div>
					<div class="botoes">
						<span class="quantidade caixas" id="caixas${nomeProduto}"></span>
						<span class="quantidade botaoCaixas" onclick="alteraCaixa('${nomeProduto}')" id="">Alterar caixas</span>
						<span class="quantidade" id="quantidade${nomeProduto}"></span>
						
						<button id="btnquantidade${nomeProduto}">Alterar Quantidade</button>
						<button id="btnpreco${nomeProduto}">Alterar Preço</button>
						<button id="${nomeProduto}Visibilidade">Compra Disponível</button>
					</div>	
				`;
				container.appendChild(divProduto);
			}			
		}
		comandosPagina();
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function comandosPagina(){
		criaListaProdutos();
		for (var nomeProduto in objetosBD) {
			alteraVisibilidade(nomeProduto);
			alteraQuantidade(nomeProduto);
			alteraPreco(nomeProduto);
			timer();
			atualizarCaixas();
		}
	}
	
	function timer(){
		atualizarQuantidade();
		setInterval(atualizarQuantidade, 5000);
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function atualizarCaixas(){
		$.ajax({
			url: '../conexoes_bd/consultaCaixasProduto.php',
			type: "POST",
			dataType: "json",
			success: function (response) {
				caixasProdutos = response;
				console.log(response);
				for(var nomeProdutos in caixasProdutos){
					var produtos = document.getElementById("caixas"+ nomeProdutos);
					
					produtos.innerHTML = `
						${caixasProdutos[nomeProdutos]}
					`;
				}
			}
		});
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function alteraVisibilidade(nome){
		var elemento = document.getElementById(nome + "Visibilidade");
		if (objetosBD[nome].emUso > 0) {
			elemento.style.backgroundColor = 'green'; // Mostra o elemento
		} else {
			elemento.style.backgroundColor = '#ff2525'; // Oculta o elemento
		}
		
		elemento.addEventListener('click', function() {
			if(elemento.style.backgroundColor === 'green'){
				elemento.style.backgroundColor = '#ff2525';
				alterarVisibilidadeItem(nome, 0);
			} else {
				elemento.style.backgroundColor = 'green';
				alterarVisibilidadeItem(nome, 1);
			}
	    	});
	}
	
	function alterarVisibilidadeItem(nome, quantidade) {
		$.ajax({
			url: '../conexoes_bd/alteraVisibilidade.php',
			type: "POST",
			dataType: "json",      
			data: { nome: nome, quantidade: quantidade },
			success: function (response) {
			}
		});
	}
//-----------------------------------------------------------------------------------------------------------------------------//
//funções que servem para atualizar a quantidade disponivel de cada produto
	function atualizarQuantidade(){
		for (var nomeProduto in objetosBD) {
			quantidadeitem(nomeProduto);
		}
	}
		
	function quantidadeitem(nome) {
		$.ajax({
			url: '../conexoes_bd/atualizaDados.php',
			type: "POST",
			dataType: "json",      
			data: { nome: nome },
			success: function (response) {
				var elementoQuantidade = document.getElementById("quantidade"+ nome);
				quantidadeItens[nome] = response.text;
				if(response[nome].inerente === '1'){
					elementoQuantidade.textContent = "Ilimitado";
				} else {
					elementoQuantidade.textContent = response[nome].quantidade;
					elementoQuantidade.style.display = 'flex';
				}
				alterar_cor_quantidade();
			}
		});
	}

	function alterar_cor_quantidade(){
		for(var corItens in quantidadeItens){
			var elementoQuantidade = document.getElementById("quantidade" + corItens);
			if(elementoQuantidade.textContent === "0"){
				elementoQuantidade.style.color="#ff2525";
			}else{
				elementoQuantidade.style.color="black";
			}
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function alteraQuantidade(nomeProduto) {//Atualiza a quantidade do item desejado 
   		document.getElementById('btnquantidade' + nomeProduto).addEventListener('click', function() {
   			selecionado = nomeProduto;
   			mostraQuantidade(1);
    		});
	}
	
	function adicionarEstoque(){
		var alteracaoEstoque = document.getElementById('quantidadeEstoque').value;
		alterarEstoque(alteracaoEstoque);
		alteracaoEstoque = 0;
		mostraQuantidade(0);
	}
	function removerEstoque(){
		var alteracaoEstoque = document.getElementById('quantidadeEstoque').value;
		alteracaoEstoque = alteracaoEstoque * (-1);
		alterarEstoque(alteracaoEstoque);
		alteracaoEstoque = 0;
		mostraQuantidade(0);
	}
	function limitarEstoque(){
		var alteracaoEstoque = document.getElementById("quantidade" + selecionado);
		if (alteracaoEstoque.textContent === "Ilimitado"){
			limita_estoque(0);
		} else {
			limita_estoque(1);
		}
		mostraQuantidade(0);
	}
	function cancelarEstoque(){
		var alteracaoEstoque = document.getElementById('quantidadeEstoque').value;
		alteracaoEstoque = 0;
		mostraQuantidade(0);
	}
	
	function alterarEstoque(quantidade) {
		$.ajax({
			url: '../conexoes_bd/atualizaEstoque.php',
			type: "POST",
			dataType: "json",      
			data: { nome: selecionado, quantidade: quantidade },
			success: function (response) {
				
			}
		});
	}
	
	function limita_estoque(quantidade) {
		$.ajax({
			url: '../conexoes_bd/limitaEstoque.php',
			type: "POST",
			dataType: "json",      
			data: { nome: selecionado, quantidade: quantidade },
			success: function (response) {
				location.reload();
			}
		});
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function alteraPreco(nomeProduto) {//Atualiza a quantidade do item desejado 
   		document.getElementById('btnpreco' + nomeProduto).addEventListener('click', function() {
   			selecionado = nomeProduto;
   			mostraPreco(1);
    		});
	}
	function alterarPreco(){
		var alteracaoPreco = document.getElementById('precoItem').value;
		var alteracaoPrecoConvertido = parseFloat(alteracaoPreco.replace(',', '.'))
		alterarValorItem(alteracaoPrecoConvertido);
		alteracaoPreco = 0;
		mostraPreco(0);
	}
	function cancelarPreco(){
		var alteracaoPreco = document.getElementById('precoItem').value;
		alteracaoPreco = 0;
		mostraPreco(0);
	}
	function alterarValorItem(quantidade) {
		$.ajax({
			url: '../conexoes_bd/alteraValor.php',
			type: "POST",
			dataType: "json",      
			data: { nome: selecionado, quantidade: quantidade },
			success: function (response) {
				location.reload();	
			}
		});
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function realizarCadastro(){
		var nome = document.getElementById('nomeCadastro').value;
		var preco = document.getElementById('precoCadastro').value;
		preco = preco.replace('.','');
		var precoConvertido = parseFloat(preco.replace(',','.'));
		var quantidade = parseInt(document.getElementById('quantidadeCadastro').value);
		var ilimitado = document.getElementById('ilimitadoCadastro').checked;
		var emUso = document.getElementById('emUsoCadastro').checked;
		
		if(precoConvertido == ''){
			precoConvertido = 0;
		}
		if(quantidade == ''){
			quantidade = 0;
		}
		if(ilimitado === false){
			ilimitado = 0;
		} else {
			ilimitado = 1;
		}
		if(emUso === false){
			emUso = 0;
		} else {
			emUso = 1;
		}

		if(nome !== '' && precoConvertido >= 0){
			cadastrar(nome, precoConvertido, quantidade, ilimitado, emUso);
			mostraCadastrar(0);
		} else{
			alert("Faltam dados para cadastrar o produto!");
		}
	}
	function cancelarCadastro(){
		mostraCadastrar(0);
	}
	function cadastrar(nome, preco, quantidade, ilimitado, emUso){
		$.ajax({
			url: '../conexoes_bd/cadastrarProduto.php',
			type: "POST",
			dataType: "json",      
			data: { nome: nome, preco: preco, quantidade: quantidade, ilimitado: ilimitado, emUso: emUso, posicao: 0, combo: 0, itens: 1 },
			success: function (response) {
				location.reload();
			}
		});
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	var listaProdutos;
	function criaListaProdutos(){
		var container = document.getElementById('listaProdutos');
	    for (var nome in objetosBD) {
			if (objetosBD.hasOwnProperty(nome)) {
				var optionObjeto = document.createElement('option');
				optionObjeto.value = nome;
           			optionObjeto.id = nome;

				container.appendChild(optionObjeto);
			}
	    }
	}
	function realizarRemover(){
		var nome = document.getElementById('nomeRemover').value;
		var nome = nome.toLowerCase();
		remover(nome);
	}
	function cancelarRemover(){
		mostraRemover(0);
	}
	function remover(nome){
		$.ajax({
			url: '../conexoes_bd/removerProduto.php',
			type: "POST",
			dataType: "json",      
			data: { nome: nome },
			success: function (response) {
				location.reload();
			}
		});
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	var listaProdutosCombo = {};
	function adicionarProdutoCombo(){
		var itens = document.getElementById('inputItemCombo');
		var numero = document.getElementById('inputNumeroCombo');
		var lista = document.getElementById('itensCombo');

		if(itens.value != "" && numero.value != ''){
			listaProdutosCombo[itens.value] = numero.value;
			console.log(listaProdutosCombo);
			
			lista.innerHTML += `<span>${itens.value}: ${numero.value}</span><br>`;
		}
		itens.value = "";
		numero.value = "";
	}
	function realizarCombo(){
		var nome = document.getElementById('nomeCombo').value;
		var preco = document.getElementById('precoCombo').value;
		preco = preco.replace('.','');
		var precoConvertido = parseFloat(preco.replace(',','.'));
		var quantidade = document.getElementById('quantidadeCombo').value;
		var ilimitado = document.getElementById('ilimitadoCombo').checked;
		var emUso = document.getElementById('emUsoCombo').checked;
		var itens = JSON.stringify(listaProdutosCombo);

		if(ilimitado === false){
			ilimitado = 0;
		} else {
			ilimitado = 1;
		}
		if(emUso === false){
			emUso = 0;
		} else {
			emUso = 1;
		}
		if(nome != '' && precoConvertido != '' && Object.keys(listaProdutosCombo) != 0){
			$.ajax({
				url: '../conexoes_bd/cadastrarProduto.php',
				type: "POST",
				dataType: "json",      
				data: { nome: nome, preco: precoConvertido, quantidade: quantidade, ilimitado: ilimitado, emUso: emUso, posicao: 0, combo: 1, itens: itens },
				success: function (response) {
					location.reload();
				}
			});
		} else {
			alert("Faltam dados para cadastrar o combo!");
		}
	}
	function cancelarCombo(){
		mostraCombos(0);
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	var prosicaoAlterada;
	function alteraPosicao(recebido){
		mostraAlteraPosicao(1);
		prosicaoAlterada = recebido;
	}
	function realizarAlteraPosicao(){
		var chaves = Object.keys(objetosBD);
		var numero = document.getElementById("numeroPosicao").value - 1;

		if(numero < chaves.length && numero >= 0){
			for(var i = 0; i < chaves.length; i++){
				if(chaves[i] == prosicaoAlterada){
					chaves[i] = null;
					break;
				}
			}
			for(var i = 0; i < chaves.length - 1; i++){
				if(chaves[i] == null){
					chaves[i] = chaves[i + 1]
					chaves[i + 1] = null;
				}
			}
			for(var i = chaves.length - 2; i >= numero; i--){
				chaves[i + 1] = chaves[i];
			}
			chaves[numero] = prosicaoAlterada;

			for(var i = 0; i < chaves.length; i++){
				$.ajax({
					url: '../conexoes_bd/alteraPosicao.php',
					type: "POST",
					dataType: "json",      
					data: { chave: chaves[i], posicao: i },
					async: true,
					success: function (response) {
						location.reload();
					}
				});
			}
		} else{
			alert("valor invalido");
		}
	}
	function cancelarAlteraPosicao(){
		mostraAlteraPosicao(0);
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	var caixasProdutoAlterado;
	function alteraCaixa(recebido){
		caixasProdutoAlterado = recebido;
		console.log(recebido);
		mostraCaixasProduto(1);
		for(var i = 1; i <= 14; i++){
			if(objetosBD[recebido].caixas.includes(i + ",")){
				document.getElementById("caixasProdutos" + i).checked = true;
			}
		}
	}
	function realizarAlteraCaixa(){
		var caixasSelecionados = '';
		
		for(var i = 1; i <= 14; i++){
			if(document.getElementById("caixasProdutos" + i).checked){
				caixasSelecionados += i + ",";
			}
		}
		
		console.log(caixasSelecionados);
		
		$.ajax({
			url: '../conexoes_bd/atualizaCaixasProduto.php',
			type: "POST",
			dataType: "json",      
			data: { caixas: caixasSelecionados, nome: caixasProdutoAlterado },
			success: function (response) {
				telaOriginal();
			}
		});		
	}
	function cancelarAlteraCaixa(){
		mostraAlteraPosicao(0);
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function mostraQuantidade(recebido){
		if(recebido === 1){
			document.getElementById("menu").style.display = 'none';
			document.getElementById("itens").style.display = 'none';
			document.getElementById("editarEstoque").style.display = 'block';
		} else {
			telaOriginal();
		}
	}
	
	function mostraPreco(recebido){
		if(recebido === 1){
			document.getElementById("menu").style.display = 'none';
			document.getElementById("itens").style.display = 'none';
			document.getElementById("editarPreco").style.display = 'block';
		} else {
			telaOriginal();
		}
	}
	
	function mostraCadastrar(recebido){
		if(recebido === 1){
			document.getElementById("menu").style.display = 'none';
			document.getElementById("itens").style.display = 'none';
			document.getElementById("cadastrarItem").style.display = 'block';
		} else {
			telaOriginal();
		}
	}
	
	function mostraRemover(recebido){
		if(recebido === 1){
			document.getElementById("menu").style.display = 'none';
			document.getElementById("itens").style.display = 'none';
			document.getElementById("removerProduto").style.display = 'block';
		} else {
			telaOriginal();
		}
	}
	function mostraCombos(recebido){
		if(recebido === 1){
			document.getElementById("menu").style.display = 'none';
			document.getElementById("itens").style.display = 'none';
			document.getElementById("castrarCombos").style.display = 'block';
		} else {
			telaOriginal();
		}
	}
	function mostraAlteraPosicao(recebido){
		if(recebido === 1){
			document.getElementById("menu").style.display = 'none';
			document.getElementById("itens").style.display = 'none';
			document.getElementById("posicaoProduto").style.display = 'block';
		} else {
			telaOriginal();
		}
	}
	function mostraCaixasProduto(recebido){
		if(recebido === 1){
			document.getElementById("menu").style.display = 'none';
			document.getElementById("itens").style.display = 'none';
			document.getElementById("caixasProduto").style.display = 'block';
		} else {
			telaOriginal();
		}
	}
	function telaOriginal(){
		document.getElementById("menu").style.display = 'block';
		document.getElementById("itens").style.display = 'block';
		document.getElementById("removerProduto").style.display = 'none';
		document.getElementById("cadastrarItem").style.display = 'none';
		document.getElementById("editarPreco").style.display = 'none';
		document.getElementById("editarEstoque").style.display = 'none';
		document.getElementById("castrarCombos").style.display = 'none';
		document.getElementById("posicaoProduto").style.display = 'none';
		document.getElementById("caixasProduto").style.display = 'none';
		location.reload();
	}
</script>
