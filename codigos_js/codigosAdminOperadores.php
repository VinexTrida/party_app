<?php?>
<script>
	var usuariosBD ={};
	var selecionado;
	usuarios();
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
	function atualizaCaixa(nome){
		selecionado = nome;
		mostraAtualizaCaixa(1);
	}
	
	function atualizarOperador(){
		var caixa = document.getElementById('caixaNovoOperador').value;
		if(caixa >= 1){
			cadastroCaixa(selecionado, caixa)
			mostraAtualizaCaixa(0);
		} else {
			alert("Informe um caixa!");
		}
	}
	
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
	
	function realizarRemover(){
		var nome = document.getElementById('nomeRemover').value;
		removeBanco(nome);
		excluirOperador(0);
	}
	
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
