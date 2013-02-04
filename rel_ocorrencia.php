<?php
include "menu.php";
include "conexao.php";

$frmOcorrencia = $_POST['frmOcorrencia_ok'];
?>
<div id="conteudo">

<?php
if ($frmOcorrencia == "")
{
?>

<fieldset>
<legend>Relat&oacute;rio por Ocorr&ecirc;ncia</legend>

<form action="rel_ocorrencia.php" method="post">
<ol>
	<li>
    	<label for="datas">DATA</label>
        <input type="text" name="data_inicio" id="data_inicio" size="10" maxlength="10"> &agrave; 
        <input type="text" name="data_fim" id="data_fim" size="10" maxlength="10">&nbsp;&nbsp;
        
        <select name="supervisor">
        	<option value="">Selecione o Supervisor</option>
			<option value="0">TODOS</option>
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
        </select>
        
        <input type="hidden" name="frmOcorrencia_ok" value="1">
        <input type="submit" value="OK">
    </li>
</ol>
</form>
<?php
}

if ($frmOcorrencia == "1")
{
	$data_inicio = $_POST['data_inicio'];
	$data_inicio_en = DataEn($data_inicio);
	$data_fim = $_POST['data_fim'];
	$data_fim_en = DataEn($data_fim);
	$rel_supervisor = $_POST['supervisor'];
	
	if ($rel_supervisor != 0)
	{
	
		$supervisores = "SELECT * FROM tab_supervisor WHERE codigo = '$rel_supervisor'";
		$ex_supervisores = mysql_query($supervisores);
		
		while ($supervisores = mysql_fetch_array($ex_supervisores))
		{		
			$supervisor = $supervisores['codigo'];		
	?>
	<div id="form">
		<table cellpadding="0" cellspacing="0" border="0" width="885">
			<tr>
				<td colspan="5" bgcolor="#494949" height="25" align="center">
					<font size="2" color="#FFFFFF"><b><?php echo $supervisores['supervisor'];?></b></font>
				</td>
			</tr>
			<tr>
				<td height="5" colspan="5"></td>
			</tr>
			<tr>
				<td colspan="5" align="center" bgcolor="#4B7AA3">
					<font size="2" color="#FFF"><b>FOLGAS TRABALHADAS
				</td>
			</tr>
			<tr>
				<td height="5" colspan="5"></td>
			</tr>
			<tr>
				<th align="center" width="300">Colaborador</th>
				<th align="center" width="100">Data</th>
				<th align="center" width="100">Hor&aacute;rio</th>
				<th align="center" width="200">Cidade</th>
				<th align="center" width="285">OBS</th>
			</tr>
				<?php
				$ocorrencias = "SELECT * FROM tab_ft WHERE cod_supervisor = '$supervisor' AND data BETWEEN '$data_inicio_en' AND '$data_fim_en' ORDER BY data ASC";
				$ex_ocorrencias = mysql_query($ocorrencias);
				
				$i = "1";       
				while ($ocorrencias = mysql_fetch_array($ex_ocorrencias))
				{
					
					if (($i % 2) == 1) { $fundo = $fundo1; } else { $fundo = $fundo2; }
			?>
			 <tr>
				<td bgcolor="<?php echo $fundo; ?>" height="30">
					&nbsp;<?php echo $ocorrencias['colaborador']; ?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php echo DataBr($ocorrencias['data']); ?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php echo $ocorrencias['horario']; ?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php 
					$cidade = $ocorrencias['cod_cidade'];
					$rs_cidade = "SELECT cidade FROM tab_cidade WHERE codigo = '$cidade'";
					$ex_cidade = mysql_query($rs_cidade);
					$cidade = mysql_fetch_array($ex_cidade);
					
					echo $cidade['cidade'];
					?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php if($ocorrencias['obs'] != ""){?>
					<textarea cols="30" rows="3"><?php echo $ocorrencias['obs']; ?></textarea>
					<?php
					}
					else
					{
						echo $ocorrencias['obs'];
					}
					?>
				</td>
			 </tr>
				<?php
				$i++;
				}
		?>
		</table>
		<table cellpadding="0" cellspacing="0" border="0" width="885">
			<tr>
				<td height="5" colspan="5"></td>
			</tr>
			<tr>
				<td colspan="5" align="center" bgcolor="#BF3B3B">
					<font size="2" color="#FFF"><b>FALTAS
				</td>
			</tr>
			<tr>
				<td height="5" colspan="5"></td>
			</tr>
			<tr>
				<th align="center" width="300">Colaborador</th>
				<th align="center" width="100">Motivo</th>
				<th align="center" width="100">Data</th>
				<th align="center" width="185">Cidade</th>
				<th align="center" width="200">OBS</th>
		   </tr>
			<?php
				$faltas = "SELECT * FROM tab_falta WHERE cod_supervisor = '$supervisor' AND data_inicio BETWEEN '$data_inicio_en' AND '$data_fim_en' ORDER BY data_inicio ASC";
				$ex_faltas = mysql_query($faltas);
				
				$i = "1";         
				while ($faltas = mysql_fetch_array($ex_faltas))
				{
					
					if (($i % 2) == 1) { $fundo = $fundo1; } else { $fundo = $fundo2; }
			?>
			 <tr>
				<td bgcolor="<?php echo $fundo; ?>" height="30">
					&nbsp;<?php echo $faltas['colaborador']; ?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php echo $faltas['motivo']; ?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php echo DataBr($faltas['data_inicio']); ?> <?php if($faltas['data_final'] == $faltas['data_inicio']){ }else{ echo " a " . DataBr($faltas['data_final']); } ?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php 
					$cidadeFalta = $faltas['cod_cidade'];
					$rs_cidadeFalta = "SELECT cidade FROM tab_cidade WHERE codigo = '$cidadeFalta'";
					$ex_cidadeFalta = mysql_query($rs_cidadeFalta);
					$cidadeFalta = mysql_fetch_array($ex_cidadeFalta);
					
					echo $cidadeFalta['cidade'];
					?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php if($faltas['obs'] != ""){?>
					<textarea cols="30" rows="3"><?php echo $faltas['obs']; ?></textarea>
					<?php
					}
					else
					{
						echo $faltas['obs'];
					}
					?>
				</td>
			 </tr>
				<?php
				$i++;
				}
		?>
		</table>
	</div>
	<?php
		}
	}
	else
	{
	?>
	<div id="form">
		<table cellpadding="0" cellspacing="0" border="0" width="885">
			<tr>
				<td colspan="5" bgcolor="#494949" height="25" align="center">
					<font size="2" color="#FFFFFF"><b><?php echo $supervisores['supervisor'];?></b></font>
				</td>
			</tr>
			<tr>
				<td height="5" colspan="5"></td>
			</tr>
			<tr>
				<td colspan="5" align="center" bgcolor="#4B7AA3">
					<font size="2" color="#FFF"><b>FOLGAS TRABALHADAS
				</td>
			</tr>
			<tr>
				<td height="5" colspan="5"></td>
			</tr>
			<tr>
				<th align="center" width="300">Colaborador</th>
				<th align="center" width="100">Data</th>
				<th align="center" width="100">Hor&aacute;rio</th>
				<th align="center" width="200">Cidade</th>
				<th align="center" width="285">OBS</th>
			</tr>
			<?php
			$rs_fts = mysql_query("SELECT * FROM tab_ft WHERE data BETWEEN '$data_inicio_en' AND '$data_fim_en' ORDER BY data ASC");
			$i = 1;
			while ($ex_rs_ft = mysql_fetch_array($rs_fts))
			{
				if (($i % 2) == 1) { $fundo = $fundo1; } else { $fundo = $fundo2; }
			?>
			<tr>
				<td bgcolor="<?php echo $fundo; ?>" height="30">
					&nbsp;<?php echo $ex_rs_ft['colaborador']; ?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php echo DataBr($ex_rs_ft['data']); ?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php echo $ex_rs_ft['horario']; ?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php 
					$cidade = $ex_rs_ft['cod_cidade'];
					$rs_cidade = "SELECT cidade FROM tab_cidade WHERE codigo = '$cidade'";
					$ex_cidade = mysql_query($rs_cidade);
					$cidade = mysql_fetch_array($ex_cidade);
					
					echo $cidade['cidade'];
					?>
				</td>
				<td bgcolor="<?php echo $fundo; ?>" align="center">
					<?php if($ex_rs_ft['obs'] != ""){?>
					<textarea cols="30" rows="3"><?php echo $ex_rs_ft['obs']; ?></textarea>
					<?php
					}
					else
					{
						echo $ex_rs_ft['obs'];
					}
					?>
				</td>
			 </tr>
			<?php
			$i++;
			}
			?>
			</table>
			<table cellpadding="0" cellspacing="0" border="0" width="885">
				<tr>
					<td height="5" colspan="5"></td>
				</tr>
				<tr>
					<td colspan="5" align="center" bgcolor="#BF3B3B">
						<font size="2" color="#FFF"><b>FALTAS
					</td>
				</tr>
				<tr>
					<td height="5" colspan="5"></td>
				</tr>
				<tr>
					<th align="center" width="300">Colaborador</th>
					<th align="center" width="100">Motivo</th>
					<th align="center" width="100">Data</th>
					<th align="center" width="185">Cidade</th>
					<th align="center" width="200">OBS</th>
			   </tr>
			   <?php
				$rs_faltas = mysql_query("SELECT * FROM tab_falta WHERE data_inicio BETWEEN '$data_inicio_en' AND '$data_fim_en' ORDER BY data_inicio ASC");
				$i = 1;
				while ($ex_rs_faltas = mysql_fetch_array($rs_faltas))
				{
					if (($i % 2) == 1) { $fundo = $fundo1; } else { $fundo = $fundo2; }
				?>
				<tr>
					<td bgcolor="<?php echo $fundo; ?>" height="30">
						&nbsp;<?php echo $ex_rs_faltas['colaborador']; ?>
					</td>
					<td bgcolor="<?php echo $fundo; ?>" align="center">
						&nbsp;<?php echo $ex_rs_faltas['motivo']; ?>
					</td>
					<td bgcolor="<?php echo $fundo; ?>" align="center">
						<?php echo DataBr($ex_rs_faltas['data_inicio']); ?> <?php if($ex_rs_faltas['data_final'] == $ex_rs_faltas['data_inicio']){ }else{ echo " a " . DataBr($ex_rs_faltas['data_final']); } ?>
					</td>
					<td bgcolor="<?php echo $fundo; ?>" align="center">
						<?php 
						$cidade = $ex_rs_faltas['cod_cidade'];
						$rs_cidade = "SELECT cidade FROM tab_cidade WHERE codigo = '$cidade'";
						$ex_cidade = mysql_query($rs_cidade);
						$cidade = mysql_fetch_array($ex_cidade);
						
						echo $cidade['cidade'];
						?>
					</td>
					<td bgcolor="<?php echo $fundo; ?>" align="center">
						<?php if($ex_rs_faltas['obs'] != ""){?>
						<textarea cols="30" rows="3"><?php echo $ex_rs_faltas['obs']; ?></textarea>
						<?php
						}
						else
						{
							echo $ex_rs_faltas['obs'];
						}
						?>
					</td>
				</tr>
				<?php
				$i++;
				}
	}	
}
?>
</div>