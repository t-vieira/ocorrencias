<?php
include "menu.php";
include "conexao.php";

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
			
			$rs_cidadeFalta = mysql_query("SELECT cidade FROM tab_cidade WHERE codigo = $cod_cidade");
			while ($exCidadeFalta = mysql_fetch_array($rs_cidadeFalta)) {
				$cidadeFalta = $exCidadeFalta['cidade'];
			}
			
			// ENVIANDO E-MAIL DA FT
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
				$vr = $_POST['vr'];
				if ($vr == 1) {
					$mail->AddAddress("e-mail do rh para pagando do VR e VT");
				}
				$mail->WordWrap = 50;
				$mail->IsHTML(true);
				$mail->Subject = utf8_decode("Ocorrência de FT: ". $colaborador);
				$mail->Body = utf8_decode("<html><body><b>Colaborador</b>: " . $colaborador . "<br/><b>Data</b>: " . $data . "<br/>" .
				"<b>Horário</b>: " . $horario . "<br><b>Cidade</b>: " . $cidadeFalta . "<br>" .
				"<b>Observação</b>: " . $obs . "<br/><br/><br/><br/>E-mail gerado automaticamente pelo sistema!" .
				" No fechamento dos cartões de ponto sempre consultar o sistema!</body></html>");
				$mail->Send();
			
		}else{
			
			$erro_existe = 1;
			
		}
	}
}
?>
<div id="conteudo">

<fieldset>
<legend>Cadastrar FT</legend>

<form action="cad_ft.php" method="post">
<ol>
	<li>
		<label for="colaborador">COLABORADOR:&nbsp;</label>
        <input type="text" name="colaborador" size="50" onchange="javascript:this.value=this.value.toUpperCase();" autofocus><br><br>
        
        <label for="data">DATA DA FT:&nbsp;</label>
        <input type="text" name="data" id="data" size="10" maxlength="10"><br><br>
        
        <label for="horario">HOR&Aacute;RIO:&nbsp;</label>
        <input type="text" name="horario" size="10" /><br><br>
		
		<label for="">PAGAR VR / VT:&nbsp;</label>
		<input type="checkbox" name="vr" value="1"><br><br>
        
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