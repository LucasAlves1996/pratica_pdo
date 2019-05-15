<?php

	function listarUsuarios($form){

		$pdo = new PDO('mysql:host=localhost;dbname=pratica_pdo','root','');

		$sql = $pdo->prepare("SELECT * FROM usuarios");

		$sql->execute();

		$lista_usuarios = $sql->fetchAll();

		if($form == "ver"){
			foreach ($lista_usuarios as $key => $usuario) {
				echo "
					<tr>
						<td>".$usuario["id"]."</td>
						<td>".$usuario["nome"]."</td>
						<td>".$usuario["email"]."</td>
						<td>".$usuario["telefone"]."</td>
						<td>".$usuario["data_nascimento"]."</td>
					</tr>
				";
			}
		}
		if($form == "excluir"){
			foreach ($lista_usuarios as $key => $usuario) {
				echo "
					<tr id=".$usuario["id"].">
						<td><input type='checkbox' name='usuario'></td>
						<td>".$usuario["id"]."</td>
						<td>".$usuario["nome"]."</td>
						<td>".$usuario["email"]."</td>
						<td>".$usuario["telefone"]."</td>
						<td>".$usuario["data_nascimento"]."</td>
					</tr>
				";
			}
		}

	}

	if(isset($_POST['excluir'])){

		$pdo = new PDO('mysql:host=localhost;dbname=pratica_pdo','root','');

		$sql = $pdo->prepare("DELETE FROM usuarios WHERE id=$id");

	}

	if(isset($_POST['submit'])){

		$pdo = new PDO('mysql:host=localhost;dbname=pratica_pdo','root','');

		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		$data_nascimento = $_POST['data_nascimento'];
		$telefone = $_POST['telefone'];

		$sql = $pdo->prepare("INSERT INTO usuarios VALUES(null,?,?,?,?,?)");

		$sql->execute(array($nome,$email,$senha,$telefone,$data_nascimento));

		echo "<script> alert('Cadastro efetuado com sucesso!'); </script>";

		header("Refresh:0");

	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Cadastro de usuário</title>
	<meta name="viewport" content="width=device-width">
	<style>
		body{
			background-color: rgb(150,150,150);
			margin: 0;
			padding: 0;
		}

		h1{
			width: 100%;
			color: rgb(90,0,70);
			font-size: 50px;
			text-align: center;
			padding: 50px 0px;
			margin: 0;
		}

		table{
			width: 100%;
		}

		th{
			padding: 10px 10px 10px 10px;
			color: rgb(255,255,255);
			background-color: rgb(90,0,70);
		}

		td{
			background-color: rgb(240,240,240);
			padding: 10px 10px 10px 10px;
		}

		#formCadastro{
			display: none;
			grid-template-columns: 50px auto 50px;
			background-color: rgb(220,220,220);
			width: 600px;
			height: 600px;
			margin: 150px auto 0px auto;
		}

		#listaUsuarios,#formAtualizacao,#formExclusao{
			display: none;
			background-color: rgb(220,220,220);
			width: 80%;
			height: 800px;
			margin: 30px auto 30px auto;
			box-shadow: 0px 0px 50px 5px rgb(0,0,0);
		}

		#table{
			overflow: auto;
			width: 90%;
			height: 500px;
			margin: auto;
			background-color: rgb(200,200,200);
			border: 3px ridge rgb(200,200,200);
		}

		#icon-pesquisa{
			width: 15px;
			height: 15px;
			padding: 9.1px 11.5px;
		}

		.campos-form{
			width: 100%;
			padding: 10px 0px;
			text-align: center;
			font-size: 18px;
			border: 1px solid rgb(200,200,200);
			border-radius: 5px;
			background-color: rgb(240,240,240);
			outline: none;
			margin-bottom: 10px;
		}

		.campos-form:hover{
			box-shadow: 0px 0px 30px 1px rgb(200,200,200);
		}

		.campos-form:focus{
			box-shadow: 0px 0px 30px 1px rgb(200,200,200);
		}

		.campo-pesquisa{
			width: 345px;
			padding: 8px 8px;
			font-size: 15px;
			border: none;
			border-radius: 0px 4px 4px 0px;
			background-color: rgb(240,240,240);
			border-left: 1px solid rgb(200,200,200);
			outline: none;
			float:right;
		}

		.bt-style{
			font-family: monospace;
			border: none;
			border-radius: 5px;
			background-color: rgb(90,0,70);
			color: rgb(255,255,255);
			cursor: pointer;
			outline: none;
		}

		.bt-style:hover{
			box-shadow: 0px 0px 30px 1px rgb(150,150,150);
		}

		.bt-form{
			font-size: 18px;
			float: right;
			padding: 10px 10px;
			margin-top: 10px;
		}

		.bt-menu{
			padding: 8px 0px;
			margin: 0px 5px;
			font-size: 15px;
		}

		.close{
			float: right;
			width: 50px;
			height: 50px;
			font-size: 22px;
			padding: 0;
			border: none;
			font-family: cursive;
			color: rgb(100,100,100);
			cursor: pointer;
			outline: none;
			font-weight: bold;
			background-color: transparent;
		}

		.menu{
			display: grid;
			grid-template-columns: auto auto auto auto;
			overflow: auto;
		}

		.menu-botao{
			margin: 10px 10px;
		}

		.pesquisa{
			background-color: rgb(90,0,70);
			height: 33.28px;
			margin-bottom: 15px;
			margin-left: 5%;
			border-radius: 5px;
			width: 400px;
			border: 1px solid rgb(200,200,200);
		}

		::-webkit-scrollbar-track {
    	background-color: #BEBEBE;
		}
		::-webkit-scrollbar {
		  width: 8px;
		  background: #BEBEBE;
		}
		::-webkit-scrollbar-thumb {
		  background: #303030;
		}

		@media(max-width: 760px){
			#listaUsuarios,#formAtualizacao,#formExclusao{
				width: 95%;
			}
		}

		@media(max-width: 650px){
			.bt-menu{
				width: 200px;
			}
		}

		@media(max-width: 605px){
			#formCadastro{
				width: 100%;
				margin: 50px auto 0px auto;
			}

			#listaUsuarios,#formAtualizacao,#formExclusao{
				width: 100%;
			}
		}

		@media(max-width: 450px){
			.pesquisa{
				width: 250px;
			}
			.campo-pesquisa{
				width: 195px;
			}
		}	

	</style>
</head>
<body>
	<nav class="menu">
		<button onclick="formCadastro()" class="bt-style bt-menu menu-botao">Cadastrar usuários</button>
		<button onclick="listaUsuarios()" class="bt-style bt-menu menu-botao">Ver usuários</button>
		<button onclick="formAtualizacao()" class="bt-style bt-menu menu-botao">Atualizar usuários</button>
		<button onclick="formExclusao()" class="bt-style bt-menu menu-botao">Deletar usuários</button>
	</nav>

	<div id="formCadastro">
		<div></div>
		<div>
			<h1>Cadastro</h1>
			<form method="POST">
				<input type="text" class="campos-form" id="nome" name="nome" placeholder="Digite seu nome" required>
				<input type="text" class="campos-form" id="email" name="email" placeholder="Digite um email" required>
				<input type="password" class="campos-form" id="senha" name="senha" placeholder="Escolha uma senha" required>
				<input type="date" class="campos-form" id="data_nascimento" name="data_nascimento" required>
				<input type="text" class="campos-form" id="telefone" name="telefone" placeholder="Digite seu telefone" required>
				<input type="submit" class="bt-style bt-form" name="submit" value="Cadastrar" title="Finalizar cadastro">
			</form>
		</div>
		<button onclick="fechaFormCadastro()" class="close" title="Fechar">X</button>
	</div>

	<div id="listaUsuarios">
		<button onclick="fechaListaUsuarios()" class="close" title="Fechar">X</button>
		<h1>Lista de usuários</h1>
		<div class="pesquisa">
			<img src="search.png" id="icon-pesquisa" style="">
			<input type="text" class="campo-pesquisa" name="pesquisar">
		</div>
		<div id="table">
			<table>
				<tr>
					<th>Id</th>
					<th>Nome</th>
					<th>Email</th>
					<th>Telefone</th>
					<th>Data de nascimento</th>
				</tr>
				<?php listarUsuarios("ver"); ?>
			</table>
		</div>
	</div>

	<div id="formAtualizacao">
		<button onclick="fechaFormAtualizacao()" class="close" title="Fechar">X</button>
		<h1>Atualização</h1>
		<div class="pesquisa">
			<img src="search.png" id="icon-pesquisa" style="">
			<input type="text" class="campo-pesquisa" name="pesquisar">
		</div>
		<div id="table">
			<table>
				<tr>
					<th>Id</th>
					<th>Nome</th>
					<th>Email</th>
					<th>Telefone</th>
					<th>Data de nascimento</th>
				</tr>
				<?php listarUsuarios("atualizar"); ?>
			</table>
		</div>
	</div>

	<div id="formExclusao">
		<button onclick="fechaFormExclusao()" class="close" title="Fechar">X</button>
		<h1>Exclusão</h1>
		<div class="pesquisa">
			<img src="search.png" id="icon-pesquisa" style="">
			<input type="text" class="campo-pesquisa" name="pesquisar">
		</div>
		<form method="POST">
			<div id="table">
				<table>
					<tr>
						<th style="padding: 8px 0px 4px 0px"><img src="lixeira.png" width="22px" height="22px"></th>
						<th>Id</th>
						<th>Nome</th>
						<th>Email</th>
						<th>Telefone</th>
						<th>Data de nascimento</th>
					</tr>
					<?php listarUsuarios("excluir"); ?>
				</table>
			</div>
			<input type="submit" class="bt-style bt-form" name="excluir" value="Excluir" title="Excluir usuário(s) selecionado(s)" style="margin-right: 75px;">
		</form>
	</div>
</body>
<script>
	function formCadastro(){
		document.getElementById("formCadastro").style.display = "grid";
	}

	function fechaFormCadastro(){
		document.getElementById("formCadastro").style.display = "none";
	}

	function listaUsuarios(){
		document.getElementById("listaUsuarios").style.display = "block";
	}

	function fechaListaUsuarios(){
		document.getElementById("listaUsuarios").style.display = "none";
	}

	function formAtualizacao(){
		document.getElementById("formAtualizacao").style.display = "block";
	}

	function fechaFormAtualizacao(){
		document.getElementById("formAtualizacao").style.display = "none";
	}

	function formExclusao(){
		document.getElementById("formExclusao").style.display = "block";
	}

	function fechaFormExclusao(){
		document.getElementById("formExclusao").style.display = "none";
	}

	function selecionaUsuario(id){

	}	

</script>
</html>