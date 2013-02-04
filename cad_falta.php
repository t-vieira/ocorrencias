<?php
include "menu.php";
include "conexao.php";

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
					$data_fimEn = $data_inicioEn;
				} else {
					$data_fimEn = DataEn($data_fim);
				}
		
				$inserir_falta = "INSERT INTO tab_falta (colaborador,motivo,data_inicio,data_final,cod_cidade,cod_supervisor,obs) VALUES ('$colaborador','$motivo','$data_inicioEn','$data_fimEn','$cod_cidade','$cod_supervisor','$obs')";

				mysql_query($inserir_falta) OR DIE (mysql_error());

				$cad_falta = "cadastrado";
				
				$rs_cidadeFalta = mysql_query("SELECT cidade FROM tab_cidade WHERE codigo = $cod_cidade");
				while ($exCidadeFalta = mysql_fetch_array($rs_cidadeFalta)) {
					$cidadeFalta = $exCidadeFalta['cidade'];
				}
				
				// ENVIANDO E-MAIL DA FALTA
				
				$para = "smsribeirao@tejofran.com.br";
				
				require("phpmailer/class.phpmailer.php");
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Host = "host do seu e-mail";
				$mail->SMTPAuth = true;
				$mail->Username = "username do seu e-mail";
				$mail->Password= "senha do seu e-mail";
				$mail->From = "e-mail de quem esta enviando";
				$mail->AddAddress($para);
				$mail->WordWrap = 50;
				$mail->IsHTML(true);
				$mail->Subject = utf8_decode("Ocorrência de Falta/Atestado: ". $colaborador);
				$mail->Body = utf8_decode("<html><body><b>Colaborador</b>: " . $colaborador . "<br/><b>Motivo</b>: " . $motivo . "<br/>" .
				"<b>Data Inicio</b>: " . $data_inicio . "<br><b>Data Final</b>: " . $data_fim . "<br/><b>Cidade</b>: " . $cidadeFalta . "<br>" .
				"<b>Observação</b>: " . $obs . "<br/><br/><br/><br/>E-mail gerado automaticamente pelo sistema!" .
				" No fechamento dos cartões de ponto sempre consultar o sistema!</body></html>");
				$mail->Send();
			
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
        <input type="text" name="colaborador" size="50" onchange="javascript:this.value=this.value.toUpperCase();"><br><br>
        
        <label for="data">MOTIVO:&nbsp;</label>
        <select name="motivo">
        	<option value="">Selecione um Motivo</option>
        	<option value="FALTA">FALTA</option>
            <option value="ATESTADO">ATESTADO</option>
            <option value="LICENÇA MATRIMÔNIO">LICENÇA MATRIMÔNIO</option>
            <option value="LICENÇA PATERNIDADE">LICENÇA PATERNIDADE</option>
			<option value="LICENÇA ÓBITO">LICENÇA ÓBITO</option>
            <option value="SUSPENSÃO">SUSPENSÃO</option>
        </select><br><br>
        
        <label for="data_inicio">DATA INICIO:&nbsp;</label>
        <input type="text" name="data_inicio" id="data_inicio" size="10" maxlength="10"><br><br>
        
        <label for="data_fim">DATA FIM:&nbsp;</label>
        <input type="text" name="data_fim" id="data_fim" size="10" maxlength="10"><br><br>
        
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
        <textarea name="obs" cols="50" rows="5" onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
        
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