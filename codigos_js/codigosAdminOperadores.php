<?php?>
<script>
	var usuariosBD ={};
	var selecionado;
	usuarios();
	// Função que cria um objeto com os valores da tabela de usuarios do banco de dados
	function usuarios() {
		$.ajax({
			url: '../conexoes_bd/usuariosBD.php',
			type: "POST",
			dataType: "json",
			success: function (response) {
				usuariosBD = response;
				criaPagina();
			}
		});
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	// Função que cria as divs da página
	function criaPagina(){
		for (var nome in usuariosBD) {
			var container = document.getElementById("usuarios");;
			if (usuariosBD.hasOwnProperty(nome)) {
				var divUsuario = document.createElement('div');
				divUsuario.className = 'usuarios';
				divUsuario.id = 'id' + nome;

				divUsuario.innerHTML = `
					<center>
						<p id="id${nome}">${nome}</p> 
						<div class="botoes">
							<label>Caixa atual: ${usuariosBD[nome].caixa}</label>
							<button id="btncaixa${nome}" onclick="atualizaCaixa('${nome}')">Alterar Caixa</button>
						</div
					</center>
				`;
				
				container.appendChild(divUsuario);
			}			
		}
		criaListaOperadores();
	}

//-----------------------------------------------------------------------------------------------------------------------------//
	// Função que é chamada pelo botão de alterar o caixa vinculado ao operador
	function atualizaCaixa(nome){
		selecionado = nome;
		mostraAtualizaCaixa(1);
	}
	
	// Função chamada pelo botão de confirmação, que atualiza o caixa vinculado ao operador
	function atualizarOperador(){
		var caixa = document.getElementById('caixaNovoOperador').value;
		if(caixa >= 1){
			cadastroCaixa(selecionado, caixa)
			mostraAtualizaCaixa(0);
		} else {
			alert("Informe um caixa!");
		}
	}
	
	// Função que grava no banco de dados o novo caixa do operador
	function cadastroCaixa(nome, caixa){
		$.ajax({
			url: '../conexoes_bd/atualizaCaixa.php',
			type: "POST",
			dataType: "json",      
			data: { nome: nome, caixa: caixa },
			success: function (response) {
				location.reload();
			}
		});
	}
	
	// Função que mostra a div onde vai as informações para alterar o caixa vinculado ao operador
	function mostraAtualizaCaixa(recebido){
		if(recebido === 1){
			document.getElementById('usuarios').style.display = 'none';
			document.getElementById('cadastrarOperador').style.display = 'none';
			document.getElementById('removerOperador').style.display = 'none';
			document.getElementById('editarOperador').style.display = 'block';
			document.getElementById('menu').style.display = 'none';
		} else {
			document.getElementById('usuarios').style.display = 'block';
			document.getElementById('cadastrarOperador').style.display = 'none';
			document.getElementById('removerOperador').style.display = 'none';
			document.getElementById('editarOperador').style.display = 'none';
			document.getElementById('menu').style.display = 'block';
		}
	}
	
//-----------------------------------------------------------------------------------------------------------------------------//
	// Função chamada pelo botão de confirmação, que cria um novo usuario (FUNÇÃO DESATIVADA) 
	function realizarCadastro(recebido){
		var nome = document.getElementById('nomeOperador').value;
		var caixa = document.getElementById('caixaOperador').value;
		if(caixa >= 1){
			cadastroBanco(nome, caixa)
			adicionarOperador(0);
		} else {
			alert("Informe um caixa!");
		}
	}
	
	// Função que grava no banco de dados as informações do novo operador (FUNÇÃO DESATIVADA)
	function cadastroBanco(nome, caixa) {
		$.ajax({
			url: '../conexoes_bd/cadastroUsuarios.php',
			type: "POST",
			dataType: "json",      
			data: { nome: nome, caixa: caixa },
			success: function (response) {
				location.reload();
			}
		});
	}
	
	// Função que mostra a div onde vai as informações para cadastrar um novo usuario (FUNÇÃO DESATIVADA)
	function adicionarOperador(recebido){
		if(recebido === 1){
			document.getElementById('usuarios').style.display = 'none';
			document.getElementById('cadastrarOperador').style.display = 'block';
			document.getElementById('removerOperador').style.display = 'none';
			document.getElementById('editarOperador').style.display = 'none';
			document.getElementById('menu').style.display = 'none';
		} else {
			document.getElementById('usuarios').style.display = 'block';
			document.getElementById('cadastrarOperador').style.display = 'none';
			document.getElementById('removerOperador').style.display = 'none';
			document.getElementById('editarOperador').style.display = 'none';
			document.getElementById('menu').style.display = 'block';
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	var listaOperadores;
	// Função que cria as opções, com base em consulta prévia ao banco de dados, para o input de seleção que defini o operador que será removido (FUNÇÃO DESATIVADA)
	function criaListaOperadores(){
		var container = document.getElementById('listaOperadores');
	    	for (var nome in usuariosBD) {
				if (usuariosBD.hasOwnProperty(nome)) {
					var optionUsuarios = document.createElement('option');
					optionUsuarios.value = nome;
					optionUsuarios.id = nome;

					container.appendChild(optionUsuarios);
				}
	    	}
	}
	
	// Função chamada pelo botão de confirmação, que remove um usuario (FUNÇÃO DESATIVADA) 
	function realizarRemover(){
		var nome = document.getElementById('nomeRemover').value;
		removeBanco(nome);
		excluirOperador(0);
	}
	
	// Função que remove da tabela usuarios do banco de dados o usuario selecionado (FUNÇÃO DESATIVADA)
	function removeBanco(nome){
		$.ajax({
			url: '../conexoes_bd/removeUsuario.php',
			type: "POST",
			dataType: "json",      
			data: { nome: nome },
			success: function (response) {
				location.reload();
			}
		});
	}
	
	// Função que mostra a div onde vai as informações para remover um usuario (FUNÇÃO DESATIVADA)
	function excluirOperador(recebido){
		if(recebido === 1){
			document.getElementById('usuarios').style.display = 'none';
			document.getElementById('cadastrarOperador').style.display = 'none';
			document.getElementById('removerOperador').style.display = 'block';
			document.getElementById('editarOperador').style.display = 'none';
			document.getElementById('menu').style.display = 'none';
		} else {
			document.getElementById('usuarios').style.display = 'block';
			document.getElementById('cadastrarOperador').style.display = 'none';
			document.getElementById('removerOperador').style.display = 'none';
			document.getElementById('editarOperador').style.display = 'none';
			document.getElementById('menu').style.display = 'block';
		}
	}
</script>