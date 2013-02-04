<?php
include "menu.php";
include "conexao.php";

$frmCidade_ok = $_POST['frmCidade_ok'];

if ($frmCidade_ok == 1)
{
	$cidade = $_POST['cidade'];
		
	$verif_cidade = "SELECT cidade FROM tab_cidade WHERE cidade = '$cidade'";
	$ex_verif_cidade = mysql_query($verif_cidade);
	
	if (mysql_num_rows($ex_verif_cidade) > 0)
	{

      $cad_cidade = "erro";

    }
    else
	{

        $inserir_cidade = "INSERT INTO tab_cidade (cidade) VALUES ('$cidade')";

        mysql_query($inserir_cidade) OR DIE ("Não foi possível cadastrar");

        $cad_cidade = "cadastrado";
        
    }

}
?>
<div id="conteudo">

<fieldset>
<legend>Cadastrar Cidade</legend>

<form action="cad_cidade.php" method="post">
<ol>
	<li>
		<label for="cidade">CIDADE:&nbsp;</label>
        <input type="text" name="cidade" size="30" onchange="javascript:this.value=this.value.toUpperCase();"><br><br />
    </li>
</ol>

	<div align="center">
    <input type="hidden" name="frmCidade_ok" value="1">
    <input type="submit" value="CADASTRAR CIDADE">
    </div>
    </form>
    
	<?php
    if ($cad_cidade == "cadastrado") {
    ?>
    <div id="aviso_ok">
        Cidade Cadastrada com Sucesso!
    </div>
    <?php
    }
    if ($cad_cidade == "erro") {
    ?>
    <div id="aviso_erro">
        Cidade já esta Cadastrada. Cadastre Outra!
    </div>
    <?php
    }
    ?>