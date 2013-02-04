<?php
include "menu.php";
include "conexao.php";
?>
<script>
function mostra(id)
{
	switch (id)
	{
		case 1:
			document.getElementById("cadastro_ft").style.display = "block";
			document.getElementById("cadastro_falta").style.display = "none";
			document.getElementById("cadastro_ft_falta").style.display = "none";
			break;
		case 2:
			document.getElementById("cadastro_falta").style.display = "block";
			document.getElementById("cadastro_ft").style.display = "none";
			document.getElementById("cadastro_ft_falta").style.display = "none";
			break;
	}
}
</script>
<div id="conteudo">

<fieldset>
<legend>Cadastro de Coberturas e Faltas</legend>

Escolha uma das opções abaixo:<br /><br />

<input type="radio" name="cobertura" value="1" id="coberturaFt" onclick="mostra(1);" />SOMENTE cadastro de <b>FT</b>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="cobertura" value="2" id="coberturaFalta" onclick="mostra(2);" />SOMENTE cadastro de <b>Falta</b>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="cobertura" value="3" id="coberturaFtFalta" />Cadastro de <b>FT</b> com <b>Falta</b>.<br/><br/><br/>

<!-- FORMULÁRIO DE CADASTRO DE FT -->
<div id="cadastro_ft">
<?php
$frmFt_ok = $_POST['frmFt_ok'];

if ($frmFt_ok == 1)
{
	$colaborador = $_POST['colaborador'];
	$data = $_POST['data'];
	$dataEn = DataEn($data);
	$horario = $_POST['horario'];
	$cod_cidade = $_POST['cidade'];
	$cod_supervisor = $_POST['supervisor'];
	$obs = $_POST['obs'];
	
	if ($colaborador == "" or $data == "" or $horario == "" or $cod_cidade == "" or $cod_supervisor == "") {
		
		$erro_branco = "1";
		
	} else {
	
		$verif_ft = "SELECT colaborador,data FROM tab_ft WHERE colaborador = '$colaborador' AND data='$dataEn'";
		$exVerifFt = mysql_query($verif_ft);
		$numVerifFt = mysql_num_rows($exVerifFt);
		
		if($numVerifFt == 0) {
	
			$inserir_ft = "INSERT INTO tab_ft (colaborador,data,horario,cod_cidade,cod_supervisor,obs) VALUES ('$colaborador','$dataEn','$horario','$cod_cidade','$cod_supervisor','$obs')";

			mysql_query($inserir_ft) OR DIE ("Não foi possível cadastrar");

			$cad_ft = "cadastrado";
			
		}else{
			
			$erro_existe = 1;
			
		}
	}
}
?>
<div id="conteudo" style="float: left;">

<fieldset>
<legend>Cadastrar FT</legend>

<form action="cad_ft.php" method="post">
<ol>
	<li>
		<label for="colaborador">COLABORADOR:&nbsp;</label>
        <input type="text" name="colaborador" size="50" onkeyup="this.value = this.value.toUpperCase();"><br><br>
        
        <label for="data">DATA DA FT:&nbsp;</label>
        <input type="text" name="data" size="10" maxlength="10" onKeyPress="DataHora(event, this)"><br><br>
        
        <label for="horario">HOR&Aacute;RIO:&nbsp;</label>
        <input type="text" name="horario" size="10" /><br><br>
        
        <label for="cidade">CIDADE QUE &Eacute;:&nbsp;</label>
        <select name="cidade">
        	<option value="">Selecione a Cidade</option>
            <?php
            $sqlCidade = "SELECT * FROM tab_cidade ORDER BY cidade ASC";
			$rs_sqlCidade = mysql_query($sqlCidade);
			
			while ($cidadeFt = mysql_fetch_array($rs_sqlCidade))
			{
			?>
            <option value="<?php echo $cidadeFt['codigo']; ?>"><?php echo $cidadeFt['cidade']; ?></option>
            <?php
			}
			?>
        </select><br><br>
        
        <label for="supervisor">SUPERVISOR:&nbsp;</label>
        <select name="supervisor">
        	<option value="">Selecione o Supervisor</option>
            <?php
            $sqlSupervisor = "SELECT * FROM tab_supervisor ORDER BY supervisor ASC";
			$rs_sqlSupervisor = mysql_query($sqlSupervisor);
			
			while ($supervisorFt = mysql_fetch_array($rs_sqlSupervisor))
			{
			?>
            <option value="<?php echo $supervisorFt['codigo']; ?>"><?php echo $supervisorFt['supervisor']; ?></option>
            <?php
			}
			?>
        </select><br><br>
        
        <label for="observacao">OBSERVA&Ccedil;&Atilde;O:&nbsp;</label>
        <textarea name="obs" cols="50" rows="5" onkeyup="this.value = this.value.toUpperCase();"></textarea>
        
    </li>
</ol>

	<div align="center">
    <input type="hidden" name="frmFt_ok" value="1">
    <input type="submit" value="CADASTRAR FT">
    </div>
    </form>
    
	<?php
    if ($cad_ft == "cadastrado") {
    ?>
    <div id="aviso_ok">
        FT Cadastrada com Sucesso!
    </div>
    <?php
    }
    if ($cad_ft == "erro") {
    ?>
    <div id="aviso_erro">
        FT já esta Cadastrada. Cadastre Outra!
    </div>
    <?php
    }
	if ($erro_branco == "1") {
    ?>
    <div id="aviso_erro">
        Algum(s) campo(s) estava(m) em branco(s).
    </div>
    <?php
    }
	if ($erro_existe == "1") {
    ?>
    <div id="aviso_erro">
        Já existe esta FT cadastrada para esse colaborador.
    </div>
    <?php
    }
    ?>

</div>

<!-- FORMULÁRIO DE CADASTRO DE FALTA -->

<div id="cadastro_falta">

<?php
$frmFalta_ok = $_POST['frmFalta_ok'];

if ($frmFalta_ok == 1)
{
	$colaborador = $_POST['colaborador'];
	$motivo =  $_POST['motivo'];
	$data_inicio = $_POST['data_inicio'];
	$data_inicioEn = DataEn($data_inicio);
	$data_fim = $_POST['data_fim'];
	$cod_cidade = $_POST['cidade'];
	$cod_supervisor = $_POST['supervisor'];
	$obs = $_POST['obs'];
	
	if ($colaborador == "" or $motivo == "" or $data_inicio == "" or $cod_cidade == "" or $cod_supervisor == "") {
		
		$erro_branco = "1";
		
	} else {
	
		if ($data_inicio == $data_fim) {
			
			$erro_data = "1";
			
		} else {
		
			$verifFalta = "SELECT colaborador,data_inicio FROM tab_falta WHERE colaborador = '$colaborador' AND data_inicio = '$data_inicioEn'";
			$exVerifFalta = mysql_query($verifFalta);
			$numVerifFalta = mysql_num_rows($exVerifFalta);
			
			if($numVerifFalta == 0) {
		
				if ($data_fim == "") {
					$data_fim = $data_inicioEn;
				} else {
					$data_fim = DataEn($data_fim);
				}
		
				$inserir_falta = "INSERT INTO tab_falta (colaborador,motivo,data_inicio,data_final,cod_cidade,cod_supervisor,obs) VALUES ('$colaborador','$motivo','$data_inicioEn','$data_fim','$cod_cidade','$cod_supervisor','$obs')";

				mysql_query($inserir_falta) OR DIE (mysql_error());

				$cad_falta = "cadastrado";
			
			} else {
			
				$erro_existe = 1;
			
			}
		
		}
	}
}
?>
<div id="conteudo">

<fieldset>
<legend>Cadastrar Falta</legend>

<form action="cad_falta.php" method="post">
<ol>
	<li>
		<label for="colaborador">COLABORADOR:&nbsp;</label>
        <input type="text" name="colaborador" size="50" onkeyup="this.value = this.value.toUpperCase();"><br><br>
        
        <label for="data">MOTIVO:&nbsp;</label>
        <select name="motivo">
        	<option value="">Selecione um Motivo</option>
        	<option value="FALTA">FALTA</option>
            <option value="ATESTADO">ATESTADO</option>
            <option value="LICENÇA MATRIMÔNIO">LICENÇA MATRIMÔNIO</option>
            <option value="LICENÇA PATERNIDADE">LICENÇA PATERNIDADE</option>
            <option value="SUSPENSÃO">SUSPENSÃO</option>
        </select><br><br>
        
        <label for="data_inicio">DATA INICIO:&nbsp;</label>
        <input type="text" name="data_inicio" size="10" maxlength="10" onKeyPress="DataHora(event, this)"><br><br>
        
        <label for="data_fim">DATA FIM:&nbsp;</label>
        <input type="text" name="data_fim" size="10" maxlength="10" onKeyPress="DataHora(event, this)"><br><br>
        
        <label for="cidade">CIDADE QUE &Eacute;:&nbsp;</label>
        <select name="cidade">
        	<option value="">Selecione a Cidade</option>
            <?php
            $sqlCidade = "SELECT * FROM tab_cidade ORDER BY cidade ASC";
			$rs_sqlCidade = mysql_query($sqlCidade);
			
			while ($cidadeFt = mysql_fetch_array($rs_sqlCidade))
			{
			?>
            <option value="<?php echo $cidadeFt['codigo']; ?>"><?php echo $cidadeFt['cidade']; ?></option>
            <?php
			}
			?>
        </select><br><br>
        
        <label for="supervisor">SUPERVISOR:&nbsp;</label>
        <select name="supervisor">
        	<option value="">Selecione o Supervisor</option>
            <?php
            $sqlSupervisor = "SELECT * FROM tab_supervisor ORDER BY supervisor ASC";
			$rs_sqlSupervisor = mysql_query($sqlSupervisor);
			
			while ($supervisorFt = mysql_fetch_array($rs_sqlSupervisor))
			{
			?>
            <option value="<?php echo $supervisorFt['codigo']; ?>"><?php echo $supervisorFt['supervisor']; ?></option>
            <?php
			}
			?>
        </select><br><br>
        
        <label for="observacao">OBSERVA&Ccedil;&Atilde;O:&nbsp;</label>
        <textarea name="obs" cols="50" rows="5" onkeyup="this.value = this.value.toUpperCase();"></textarea>
        
    </li>
</ol>

	<div align="center">
    <input type="hidden" name="frmFalta_ok" value="1">
    <input type="submit" value="CADASTRAR FALTA">
    </div>
    </form>
    
	<?php
    if ($cad_falta == "cadastrado") {
    ?>
    <div id="aviso_ok">
        Falta Cadastrada com Sucesso!
    </div>
    <?php
    }
    if ($cad_falta == "erro") {
    ?>
    <div id="aviso_erro">
        Falta já esta Cadastrada. Cadastre Outra!
    </div>
    <?php
    }
	    if ($erro_branco == "1") {
    ?>
    <div id="aviso_erro">
        Algum(s) campo(s) estava(m) em branco(s).
    </div>
    <?php
    }
	    if ($erro_data == "1") {
    ?>
    <div id="aviso_erro">
        Data de Início do Atestado não pode ser igual a data final do Atestado.
    </div>
    <?php
    }
	if ($erro_existe == "1") {
    ?>
    <div id="aviso_erro">
        Já existe esta falta cadastrada para esse colaborador.
    </div>
    <?php
    }
    ?>

</div>