<?php require_once('Connections/Base.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "cambiart")) {
    $client=$_POST["Clientee"];
    $proce=$_POST["Procesoo"];
 $updateSQL = sprintf("UPDATE tiempos SET $client=%s WHERE Proceso=%s",
                       GetSQLValueString($_POST["tiemponew"], "text"),
                        GetSQLValueString($proce, "text"));

  mysql_select_db($database_Base, $Base);
  $Result1 = mysql_query($updateSQL, $Base) or die(mysql_error());
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$proc=$_POST['Proceso'];
mysql_select_db($database_Base, $Base);
$query_TiemposID = sprintf("SELECT * FROM tiempos WHERE Proceso = %s", GetSQLValueString($proc, "text"));
$TiemposID = mysql_query($query_TiemposID, $Base) or die(mysql_error());
$row_TiemposID = mysql_fetch_assoc($TiemposID);
$totalRows_TiemposID = mysql_num_rows($TiemposID);
}
?>

<!--http://kmmreporte.hostzi.com/-->
<!--http://localhost/KMM_Placas/-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KME Control de Placas</title>
<link REL=StyleSheet HREF="css/divisiones.css" TITLE="Divisiones" />
<link rel="shortcut icon" href="imagenes/kme.ico" type="image/x-icon"/>
<link rel="icon" href="imagenes/kme.ico" type="image/x-icon" />

<script type="text/javascript">
function Oculta() {
 if (document.getElementById('NumUno') && document.getElementById('NumDos')) {
     document.getElementsByName("form1").style.display='none';
  document.getElementById('NumUno').style.display='none';
  document.getElementById('NumDos').style.display='block';
 }
}
</script>

</head>

<body>

<div id="main">
    <table align="center" bgcolor="purple;">
<tr id="NumUno" style="display:block; background-color:fuchsia">
<td>
        <!--TABLA 1-->
        <table align="center" border="1" cellpadding="0" cellspacing="0">
        <!--Form de Cliente y Proceso-->
        <tr>
            <td>
                <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" style="display:block;">
                    <!--Tabla de form de Cliente y Proc-->
                    <table align="center">
                        <tr valign="baseline">
                          <td nowrap="nowrap" align="right"><span class="style4">Cliente:</span></td>
                          <td>
                              <select name="Cliente">
                              <option value="-" <?php if (!(strcmp("-", ""))) {echo "SELECTED";} ?>>-</option>
                              <option value="AhmsaCC2" <?php if (!(strcmp("Ahmsa CC-2", ""))) {echo "SELECTED";} ?>>Ahmsa CC-2</option>
                              <option value="AhmsaCC3" <?php if (!(strcmp("Ahmsa CC-3", ""))) {echo "SELECTED";} ?>>Ahmsa CC-3</option>
                              <option value="Hylsa" <?php if (!(strcmp("Hylsa", ""))) {echo "SELECTED";} ?>>Hylsa</option>
                              <option value="Mittal" <?php if (!(strcmp("Mittal", ""))) {echo "SELECTED";} ?>>Mittal</option>
                              <option value="Angostas" <?php if (!(strcmp("Angostas", ""))) {echo "SELECTED";} ?>> Angostas</option>
                              </select>
                          </td>
                        </tr>
                          <tr valign="baseline">
                              <td nowrap="nowrap" align="right"><span class="style4">Proceso:</span></td>
                              <td>
                                <select name="Proceso">
                                  <option value="-" <?php if (!(strcmp("-", ""))) {echo "SELECTED";} ?>>-</option>
                                  <option value="1. Recepcion-Medicion y Pesado" <?php if (!(strcmp("1. Recepcion-Medicion y Pesado", ""))) {echo "SELECTED";} ?>>1. Recepcion-Medicion y Pesado</option>
                                  <option value="2. Desengrasado" <?php if (!(strcmp("2. Desengrasado", ""))) {echo "SELECTED";} ?>>2. Desengrasado</option>
                                  <option value="3. Enjuague y Sopleteado" <?php if (!(strcmp("3. Enjuague y Sopleteado", ""))) {echo "SELECTED";} ?>>3. Enjuague y Sopleteado</option>
                                  <option value="4. Prelimpieza y enderezado" <?php if (!(strcmp("4. Prelimpieza y enderezado", ""))) {echo "SELECTED";} ?>>4. Prelimpieza y enderezado</option>
                                  <option value="5. Refrescar cuerdas montar en dommy torqueo e inspeccion" <?php if (!(strcmp("5. Refrescar cuerdas montar en dommy torqueo e inspeccion", ""))) {echo "SELECTED";} ?>>5. Refrescar cuerdas montar en dommy torqueo e inspeccion</option>
                                  <option value="6. Maquinado de Preparacion (Caja)" <?php if (!(strcmp("6. Maquinado de Preparacion (Caja)", ""))) {echo "SELECTED";} ?>>6. Maquinado de Preparacion (Caja)</option>
                                  <option value="7. Desengrasado p/encintado" <?php if (!(strcmp("7. Desengrasado p/encintado", ""))) {echo "SELECTED";} ?>>7. Desengrasado p/encintado</option>
                                  <option value="8. Enjuague y Sopleteado p/encintado" <?php if (!(strcmp("8. Enjuague y Sopleteado p/encintado", ""))) {echo "SELECTED";} ?>>8. Enjuague y Sopleteado p/encintado</option>
                                  <option value="9. Limpieza y preparacion p/encintado" <?php if (!(strcmp("9. Limpieza y preparacion p/encintado", ""))) {echo "SELECTED";} ?>>9. Limpieza y preparacion p/encintado</option>
                                  <option value="10. Encintado de Placas" <?php if (!(strcmp("10. Encintado de Placas", ""))) {echo "SELECTED";} ?>>10. Encintado de Placas</option>
                                  <option value="11. Fabricacion de marcos tomacorriente" <?php if (!(strcmp("11. Fabricacion de marcos tomacorriente", ""))) {echo "SELECTED";} ?>>11. Fabricacion de marcos tomacorriente</option>
                                  <option value="12. Ensamblado de Placas pintado y silicon" <?php if (!(strcmp("12. Ensamblado de Placas pintado y silicon", ""))) {echo "SELECTED";} ?>>12. Ensamblado de Placas pintado y silicon</option>
                                  <option value="13. Activacion de placas" <?php if (!(strcmp("13. Activacion de placas", ""))) {echo "SELECTED";} ?>>13. Activacion de placas</option>
                                  <option value="14. Niquelado ( Electrodepositacion )" <?php if (!(strcmp("14. Niquelado ( Electrodepositacion )", ""))) {echo "SELECTED";} ?>>14. Niquelado ( Electrodepositacion )</option>
                                  <option value="15. Enjuague y Sopleteado" <?php if (!(strcmp("15. Enjuague y Sopleteado", ""))) {echo "SELECTED";} ?>>15. Enjuague y Sopleteado</option>
                                </select>
                              </td>
                            </tr>
                        <tr>
                                  <td>&nbsp;</td>
                                  <td><input type="submit" value="Checar Tiempo" /></td>
                        </tr>
                        </table>
                      <input type="hidden" name="MM_insert" value="form1" />
                  </form>
             </td>
        </tr>
        <tr>
            <td height="20px">
                &nbsp;
            </td>
        </tr>
        <!--Tabla de Resultado de Busqueda de tiempo-->
        <tr>
            <td>
                <table border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="pink">
                  <?php
                  if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
                    do {
                      $cl=$_POST['Cliente'];
                      $pr=$_POST['Proceso'];
                   ?>
                   <tr>
                       <td class="NegDer">Cliente: </td>
                       <td class="style3"><?php echo $cl; ?></td>
                   </tr>
                   <tr>
                        <td class="NegDer">Proceso: </td>
                       <td class="style3"><?php echo $pr?></td>
                   </tr>
                   <tr>
                        <td class="NegDer">Tiempo Actual: </td>
                        <td class="style3"><?php  printf("%10.2f", $row_TiemposID[$_POST['Cliente']]); ?></td>
                   </tr>
                      <form action="<?php echo $editFormAction2; ?>" method="post" name="cambiart" id="cambiart" onsubmit="Oculta();">
                   <tr>
                       <td class="NegDer">Nuevo Tiempo: </td>

                        <td>
                               <input type="text" name="tiemponew" value="" size="6"/>
                       </td>
                   </tr>
                   <tr>
                       <td colspan="2" align="center">
                           <input type="submit" value="Cambiar Tiempo"/>
                       </td>
                   </tr>
                      <input type="hidden" name="MM_update" value="cambiart" />
                      <input type="hidden" name="Clientee" value="<?php echo $cl;?>" />
                      <input type="hidden" name="Procesoo" value="<?php echo $pr;?>" />
                   </form>
                 <?php } while ($row_TiemposID = mysql_fetch_assoc($TiemposID)); }?>
                </table>
            </td>
        </tr>
        </table>
</td>
</tr>
<tr id="NumDos" style="display:none; background-color:green">
<td>
        <!--Tabla 2-->
        <!--Ya se cambio el tiempo-->
        <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                     Tiempo Cambiado:
                     </td>
                </tr>
                <tr>
                    <td>
                    <?php  echo $_POST["Clientee"];?>
                    </td>
                </tr>
                <tr>
                    <td>
                    <?php  echo $_POST["Procesoo"];?>
                    </td>
                </tr>
                <tr>
                    <td>
                    <?php  echo $_POST["tiemponew"];?>
                    </td>
                </tr>
            </table>
</td>
</tr>
</table>

</div>
</body>
</html>	