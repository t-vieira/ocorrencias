<?php
Function DataEn ($data) {

    $data = substr($data, 6,4) . "-" . substr($data, 3,2) . "-" . substr($data, 0,2);
    return $data;
}

Function DataBr ($data) {

    $data = substr($data,8,2) . "/" . substr($data,5,2) . "/" . substr($data,0,4);
    return $data;
}

$fundo1 = "#F5F5F5"; //primeira cor de fundo da tabela
$fundo2 = "#F9F9F9"; //segunda cor de fundo da tabela
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Controle de Faltas e Fts para Lan&ccedil;amento Cart&atilde;o de Ponto</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="style.css" />
	
	<link type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />		
	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>
	<script type="text/javascript">
		$(function(){

			// Datepicker
			$( "#data" ).datepicker( $.datepicker.regional[ "pt-BR" ] );
			$( "#data_inicio" ).datepicker( $.datepicker.regional[ "pt-BR" ] );
			$( "#data_fim" ).datepicker( $.datepicker.regional[ "pt-BR" ] );
			
		});
	</script>

  <body>
      <div id="container">

          <div id="menu">
            <h4 class="cadastro">Cadastros</h4>
            <a href="cad_cidade.php">Cidade</a><br>
            <a href="cad_falta.php">Faltas</a><br>
            <a href="cad_ft.php">FT</a>

            <!--<h4 class="controle">Controles</h4>
            <a href="reciclagens.php">Reciclagens para Marcar</a><br>
            <a href="rec_marcadas.php">Reciclagens Marcadas</a>-->

            <h4 class="relatorio">Relat&oacute;rios</h4>
            <a href="rel_ocorrencia.php">Ocorr&ecirc;ncias por Data</a><br>
			<!--<a href="rel_reciclagens_ano.php">Reciclagens Anual</a>-->

            <h4 class="editar">Editar / Excluir</h4>
            <a href="del_ocorrencia.php">Deletar Ocorr&ecirc;ncias</a><br>
            <!--<a href="edit_posto.php">Postos</a><br>
            <a href="edit_colaborador.php">Colaborador</a>

            <h4 class="inativo">Inativos</h4>
            <a href="inat_colaborador.php">Colaboradores</a>-->
        </div>