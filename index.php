<style>
@import url("https://fonts.googleapis.com/css?family=Raleway:400,700");
*, *:before, *:after {
  box-sizing: border-box;
}

body {
  margin: 0%;
  min-height: 100vh;
  background-color: #212127;
  color: #98ABB4;
  font-family: "Raleway", sans-serif;
}


.container {
  position: absolute;
  width: 100%;
  height: 100%;
  overflow: hidden;
}
.container:hover .top:before, .container:hover .top:after, .container:hover .bottom:before, .container:hover .bottom:after, .container:active .top:before, .container:active .top:after, .container:active .bottom:before, .container:active .bottom:after {
  margin-left: 200px;
  transform-origin: -200px 50%;
  transition-delay: 0s;
}
.container:hover .center, .container:active .center {
  opacity: 1;
  transition-delay: 0.2s;
}

.top:before, .top:after, .bottom:before, .bottom:after {
  content: "";
  display: block;
  position: absolute;
  width: 200vmax;
  height: 200vmax;
  top: 50%;
  left: 50%;
  margin-top: -100vmax;
  transform-origin: 0 50%;
  transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
  z-index: 10;
  opacity: 0.65;
  transition-delay: 0.2s;
}

.top:before {
  transform: rotate(45deg);
  background: #363432;
}
.top:after {
  transform: rotate(135deg);
  background: #ffffff;
}

.bottom:before {
  transform: rotate(-45deg);
  background: #90A19D;
}
.bottom:after {
  transform: rotate(-135deg);
  background: #e11e25;
}

.center {
  position: absolute;
  width: 400px;
  height: 400px;
  top: 50%;
  left: 50%;
  margin-left: -200px;
  margin-top: -200px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 30px;
  opacity: 0;
  transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
  transition-delay: 0s;
  color: #333;
}
.center input {
  width: 100%;
  padding: 15px;
  margin: 5px;
  border-radius: 1px;
  border: 1px solid #ccc;
  font-family: inherit;
}
.btn {

box-sizing: border-box;
appearance: none;
background-color: transparent;
border: 2px solid #6697FF;
border-radius: 0.6em;
color: #6697FF;
cursor: pointer;
display: flex;
align-self: center;
font-size: 13px;
font-weight: 400;
line-height: 1;
margin: 5px;
padding: 1.2em 2.8em;
text-decoration: none;
text-align: center;


font-family: 'Montserrat', sans-serif;
font-weight: 700;

&:hover,
&:focus {
    color: rgba(255, 255, 255, 0.9);
    outline: 0;
}
}

.first {
transition: box-shadow 300ms ease-in-out, color 300ms ease-in-out;

&:hover {
    box-shadow: 0 0 40px 40px #6697FF inset;
}
}
.color_white{
  color: #fff;
}
</style>

  <script>
  window.console = window.console || function(t) {};
  sessionStorage.clear();
</script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  
  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>

<title>Login</title>
</head>

<body translate="no">
<form method="post" action="../conexoes_bd/login.php">
  <div class="container" onclick="onclick">
  <div class="top"></div>
  <div class="bottom"></div>
  <div class="center">
    <h2 class="color_white">Login</h2>
    <?php
    session_start();
                        if(isset($_SESSION['nao_autenticado'])):
                    ?>
                    <div class="notification is-danger">
                      <p class="color_white">ERRO: Usuário ou senha inválidos.</p>
                    </div>
                    <?php
                        endif;
                        unset($_SESSION['nao_autenticado']);
                    ?><?php
                        if(isset($_SESSION['nao_prenchido'])):
                    ?>
                    <div class="notification is-danger">
                        <p class="color_white">ERRO: Preenchimento do usuario e da senha obrigatorios.</p>
                    </div>
                    <?php
                        endif;
                        unset($_SESSION['nao_prenchido']);
                    ?>
    <input name="nome" type="text" placeholder="nome" list="listaOperadores">
    <datalist id="listaOperadores">
    </datalist>
    <input name="senha" type="password" placeholder="senha">
    <button class="first btn" role="button" type="submit">Entrar</button>
    <h2>&nbsp;</h2>
  </div>
</div>
</form>
  <script src="https://codepen.io/banik/pen/ReNNrO/3f837b2f0085b5125112fc455941ea94.js"></script>
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
  <script>
  	var operadoresBD = {};
	usuarios();
	function usuarios() {
		$.ajax({
			url: 'conexoes_bd/usuariosBD.php',
			type: "POST",
			dataType: "json",
			success: function (response) {
				operadoresBD = response;
				criaListaOperadores();
			}
		});
	}
	function criaListaOperadores() {
		var container = document.getElementById('listaOperadores');
	    	for (var nome in operadoresBD) {
			if (operadoresBD.hasOwnProperty(nome) && !document.getElementById(nome)) {
				var optionOperador = document.createElement('option');
				optionOperador.value = nome;
           			optionOperador.id = nome;

				container.appendChild(optionOperador);
			}
	    	}
	}
  </script>

</body></html>
