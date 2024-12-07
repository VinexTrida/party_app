<?php?>
<script>
	$('#hora-inicio').mask('00:00');
	$('#hora-fim').mask('00:00');
	
	var operadoresBD = {};
	usuarios();
	function usuarios() {
		$.ajax({
			url: '../conexoes_bd/usuariosBD.php',
			type: "POST",
			dataType: "json",
			success: function (response) {
				operadoresBD = response;
				// criaPagina();
			}
		});
	}
	// function criaPagina() {
	//     	for (var nome in operadoresBD) {
	// 		var container = document.getElementById('lista-operadores');
	// 		if (operadoresBD.hasOwnProperty(nome) && !document.getElementById('id' + nome)) {
	// 			var divOperador = document.createElement('div');

	// 			divOperador.innerHTML = `
	// 				<center>
	// 					<button id="operador${nome}" value="${nome}" onclick="selecionaOperador('${nome}')">${nome}</button>
	// 				</center>
	// 			`;

	// 			container.appendChild(divOperador);
				
	// 		}
	//     	}
	//     	selecionaOperador(-1);
	// }
//-----------------------------------------------------------------------------------------------------------------------------//
	var tipo;
	selecionaTipo(1);
	function selecionaTipo(recebido){
		if(recebido === 1){
			tipo = 1;
		}else{
			tipo = 2;
		}
		
		if(tipo === 1){
			document.getElementById("tipo1").style.color = "green";
			document.getElementById("tipo2").style.color = "black";
		}else{
			document.getElementById("tipo1").style.color = "black";
			document.getElementById("tipo2").style.color = "green";
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	var caixas = [];
	function selecionaCaixa(recebido){
		if(recebido < 0){
			if(document.getElementById("caixa0").style.color === "green"){
				for(var i = 0; i <= 14; i++){
					var cor = document.getElementById("caixa" + i);
					cor.style.color = "black";
				}
				caixas = [];
			}else{
				for(var i = 0; i <= 14; i++){
					var cor = document.getElementById("caixa" + i);
					cor.style.color = "green";
				}
				caixas = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
			}
		}else{
			var cor = document.getElementById("caixa" + recebido);
			if(cor.style.color === "green"){
				cor.style.color = "black";
			}else{
				cor.style.color = "green";
			}

			var tamanho = caixas.length;
			var removido = true;
			for (var i = 0; i <= tamanho; i++) {
				if (caixas[i] === recebido) {
					caixas.splice(i, 1);
					removido = false;
					break;
				}
			}
			if(removido){
				caixas.push(recebido);
			}
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	// var operadores = [];
	// function selecionaOperador(recebido){
	// 	if(recebido < 0){
	// 		var quantidade = Object.keys(operadoresBD).length;
	// 		var todos = document.getElementById("operador0");
	// 		if(todos.style.color === "green"){
	// 			todos.style.color = "black";
	// 			for(var nome in operadoresBD){
	// 				var cor = document.getElementById("operador" + nome);
	// 				cor.style.color = "black";
	// 			}
	// 			operadores = [];
	// 		}else{
	// 			todos.style.color = "green";
	// 			for(var nome in operadoresBD){
	// 				var cor = document.getElementById("operador" + nome);
	// 				cor.style.color = "green";
	// 			}
	// 			operadores = Object.keys(operadoresBD);
	// 		}
	// 	}else{
	// 		var cor = document.getElementById("operador" + recebido);
	// 		if(cor.style.color === "green"){
	// 			cor.style.color = "black";
	// 		}else{
	// 			cor.style.color = "green";
	// 		}

	// 		var tamanho = operadores.length;
	// 		var removido = true;
	// 		for (var i = 0; i <= tamanho; i++) {
	// 			if (operadores[i] === recebido) {
	// 				operadores.splice(i, 1);
	// 				removido = false;
	// 				break;
	// 			}
	// 		}
	// 		if(removido){
	// 			operadores.push(recebido);
	// 		}
	// 	}
	// }
//-----------------------------------------------------------------------------------------------------------------------------//
	var pagamentos = [];
	function selecionaPagamento(recebido){
		if(recebido < 0){
			var todos = document.getElementById("pagamento0");
			if(todos.style.color === "green"){
				todos.style.color = "black";
				document.getElementById("pagamentocartao").style.color = "black";
				document.getElementById("pagamentodinheiro").style.color = "black";
				document.getElementById("pagamentopix").style.color = "black";
				document.getElementById("pagamentocortesia").style.color = "black";
				pagamentos = [];
			}else{
				todos.style.color = "green";
				document.getElementById("pagamentocartao").style.color = "green";
				document.getElementById("pagamentodinheiro").style.color = "green";
				document.getElementById("pagamentopix").style.color = "green";
				document.getElementById("pagamentocortesia").style.color = "green";
				pagamentos = ["cartao","dinheiro","pix","cortesia"];
			}
		}else{
			var cor = document.getElementById("pagamento" + recebido);
			if(cor.style.color === "green"){
				cor.style.color = "black";
			}else{
				cor.style.color = "green";
			}
			
			var removido = true;
			for(var id in pagamentos){
				if (pagamentos[id] == recebido) {
					pagamentos.splice(id, 1);
					removido = false;
					break;
				}
			}
			
			if(removido){
				pagamentos.push(recebido);
			}
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	var saidasCaixa = [];
	function selecionaSaida(recebido){
		if(recebido < 0){
			var todos = document.getElementById("saida0");
			if(todos.style.color === "green"){
				todos.style.color = "black";
				document.getElementById("saidasangria").style.color = "black";
				document.getElementById("saidadevolucao").style.color = "black";
				saidasCaixa = [];
			}else{
				todos.style.color = "green";
				document.getElementById("saidasangria").style.color = "green";
				document.getElementById("saidadevolucao").style.color = "green";
				saidasCaixa = ["sangria","devolucao"];
			}
		} else {
			var cor = document.getElementById("saida" + recebido);
			if(cor.style.color === "green"){
				cor.style.color = "black";
			}else{
				cor.style.color = "green";
			}
			
			var removido = true;
			for(var id in saidasCaixa){
				if (saidasCaixa[id] == recebido) {
					saidasCaixa.splice(id, 1);
					removido = false;
					break;
				}
			}
			
			if(removido){
				saidasCaixa.push(recebido);
			}
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------//
	function chamarRelatorio(){
		var tipoR = tipo;
		
		var caixaR = "(";
		for(var id in caixas){
			if(id != 0){
				caixaR += ",";
			}
			caixaR += "'" + caixas[id] + "'";
		}
		caixaR += ")";
		if(caixaR == "()"){
			alert("Selecione pelo menos um caixa!");
			return false;
		}
		
		// var operadorR = "(";
		// for(var id in operadores){
		// 	if(id != 0){
		// 	operadorR += ",";
		// 	}
		// 	operadorR += "'" + operadores[id] + "'";
		// }
		// operadorR += ")";
		// if(operadorR == "()"){
		// 	alert("Selecione pelo menos um operador!");
		// 	return false;
		// }
		
		var pagamentoR = "(";
		for(var id in pagamentos){
			if(id != 0){
				pagamentoR += ",";
			}
			pagamentoR += "'" + pagamentos[id] + "'";
		}
		if(pagamentoR == "("){
			alert("Selecione pelo menos um pagamento!");
			return false;
		}
		for(var id in saidasCaixa){
			pagamentoR += ",";
			pagamentoR += "'" + saidasCaixa[id] + "'";
		}
		pagamentoR += ")";
		console.log(pagamentoR);
		
		var dataInicio = document.getElementById("data-inicio").value;
		
		var dataFim = document.getElementById("data-fim").value;
		
		if(dataInicio == "" || dataFim == ""){
			alert("Preencha todos os campos de data!");
			return false;
		}
		
		var horaInicio = document.getElementById("hora-inicio").value;
		var [horas, minutos] = horaInicio.split(':');
		var horasInicioNumero = parseInt(horas, 10);
		var minutosInicioNumero = parseInt(minutos, 10);
		
		if(horaInicio == ""){
			horaInicio = "00:00";
		}

		var horaFim = document.getElementById("hora-fim").value;
		var [horas, minutos] = horaInicio.split(':');
		var horasFimNumero = parseInt(horas, 10);
		var minutosFimNumero = parseInt(minutos, 10);
		
		if(horaFim == ""){
			horaFim = "23:59";
		}
		
		if (horasInicioNumero < 0 || horasInicioNumero > 23 || minutosInicioNumero < 0 || minutosInicioNumero > 59 || horasFimNumero < 0 || horasFimNumero > 23 || minutosFimNumero < 0 || minutosFimNumero > 59) {
			alert("Horário não permitido, informe um horário valido!");
			return false;
		}
		
		document.getElementById("enviaTipo").value = tipoR;
		document.getElementById("enviaCaixas").value = caixaR;
		// document.getElementById("enviaOperadores").value = operadorR;
		document.getElementById("enviaPagamentos").value = pagamentoR;
		document.getElementById("enviaDataInicio").value = dataInicio;
		document.getElementById("enviaDataFim").value = dataFim;
		document.getElementById("enviaHoraInicio").value = horaInicio;
		document.getElementById("enviaHoraFim").value = horaFim;
		 
		return true;
	}
</script>
