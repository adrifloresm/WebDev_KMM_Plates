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

//Agregar Fecha INI
$editFormAction_ini = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction_ini .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$Ingreso_ini=$_POST['Date_ini']." ".$_POST['Hora_ini'].":".$_POST['Min_ini'];
if ((isset($_POST["MM_inicio"])) && ($_POST["MM_inicio"] == "inicio")) {
  $updateSQL_ini = sprintf("UPDATE Procesos SET FActual_Ini=%s WHERE Placa=%s and Proceso=%s and FEsperada_Ini=%s and FEsperada_Fin=%s",
                       GetSQLValueString($Ingreso_ini, "date"),
                       GetSQLValueString($_POST['Placa'], "text"),
                       GetSQLValueString($_POST['Proceso'], "text"),
		       GetSQLValueString($_POST['FEsperada_Ini'], "text"),
                       GetSQLValueString($_POST['FEsperada_Fin'], "text"));

  mysql_select_db($database_Base, $Base);
  $Result_ini = mysql_query($updateSQL_ini, $Base) or die(mysql_error());
}

//Agregar Fecha FIN
$editFormAction_fin = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction_fin .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$Ingreso_fin=$_POST['Date_fin']." ".$_POST['Hora_fin'].":".$_POST['Min_fin'];
if ((isset($_POST["MM_fin"])) && ($_POST["MM_fin"] == "fin")) {
  $updateSQL_fin = sprintf("UPDATE Procesos SET FActual_Fin=%s WHERE Placa=%s and Proceso=%s and FEsperada_Ini=%s and FEsperada_Fin=%s",
                       GetSQLValueString($Ingreso_fin, "date"),
                       GetSQLValueString($_POST['Placa'], "text"),
                       GetSQLValueString($_POST['Proceso'], "text"),
		       GetSQLValueString($_POST['FEsperada_Ini'], "text"),
                       GetSQLValueString($_POST['FEsperada_Fin'], "text"));

  mysql_select_db($database_Base, $Base);
  $Result_fin = mysql_query($updateSQL_fin, $Base) or die(mysql_error());
}

//Agregar Comm
$editFormAction_comm = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction_comm .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_comm"])) && ($_POST["MM_comm"] == "comm")) {
  $updateSQL_comm = sprintf("UPDATE Procesos SET Comentarios=%s WHERE Placa=%s and Proceso=%s and FEsperada_Ini=%s and FEsperada_Fin=%s",
                       GetSQLValueString($_POST['comentarios'],"text" ),
                       GetSQLValueString($_POST['Placa'], "text"),
                       GetSQLValueString($_POST['Proceso'], "text"),
		       GetSQLValueString($_POST['FEsperada_Ini'], "text"),
                       GetSQLValueString($_POST['FEsperada_Fin'], "text"));

  mysql_select_db($database_Base, $Base);
  $Result_comm = mysql_query($updateSQL_comm, $Base) or die(mysql_error());
}

//Borrar Comentario
if ((isset($_POST["MM_comm"])) && ($_POST["MM_comm"] == "borrar_comm")) {
  $updateSQL2 = sprintf("UPDATE Procesos SET Comentarios=%s WHERE Placa=%s and Proceso=%s and FEsperada_Ini=%s",
                       GetSQLValueString(NULL, "text"),
                       GetSQLValueString($_POST['Placa'], "text"),
                       GetSQLValueString($_POST['Proceso'], "text"),
		       GetSQLValueString($_POST['FEsperada_Ini'], "text"));

  mysql_select_db($database_Base, $Base);
  $Result2 = mysql_query($updateSQL2, $Base) or die(mysql_error());
}
//Borrar Agregado Inicio
if ((isset($_POST["MM_b_ini"])) && ($_POST["MM_b_ini"] == "borrar_ini")) {
  $updateSQL2 = sprintf("UPDATE Procesos SET FActual_Ini=%s WHERE Placa=%s and Proceso=%s and FEsperada_Ini=%s",
                       GetSQLValueString(NULL, "text"),
                       GetSQLValueString($_POST['Placa'], "text"),
                       GetSQLValueString($_POST['Proceso'], "text"),
		       GetSQLValueString($_POST['FEsperada_Ini'], "text"));

  mysql_select_db($database_Base, $Base);
  $Result2 = mysql_query($updateSQL2, $Base) or die(mysql_error());
}

//Borrar Agregado FIN
if ((isset($_POST["MM_b_fin"])) && ($_POST["MM_b_fin"] == "borrar_fin")) {
  $updateSQL22 = sprintf("UPDATE Procesos SET FActual_Fin=%s WHERE Placa=%s and Proceso=%s and FEsperada_Ini=%s",
                       GetSQLValueString(NULL, "text"),
                       GetSQLValueString($_POST['Placa'], "text"),
                       GetSQLValueString($_POST['Proceso'], "text"),
		       GetSQLValueString($_POST['FEsperada_Ini'], "text"));

  mysql_select_db($database_Base, $Base);
  $Result22 = mysql_query($updateSQL22, $Base) or die(mysql_error());
}

//Datos de Placas
$colname_Detalles1 = "-1";
if (isset($_GET['Placa'])) {
  $colname_Detalles1 = $_GET['Placa'];
}
mysql_select_db($database_Base, $Base);
$query_Detalles1 = sprintf("SELECT * FROM idPlacas WHERE Placa = %s", GetSQLValueString($colname_Detalles1, "text"));
$Detalles1 = mysql_query($query_Detalles1, $Base) or die(mysql_error());
$row_Detalles1 = mysql_fetch_assoc($Detalles1);
$totalRows_Detalles1 = mysql_num_rows($Detalles1);

//Datos de Procesos
$colname_ProcesosDet = "-1";
if (isset($_GET['Placa'])) {
  $colname_ProcesosDet = $_GET['Placa'];
}
mysql_select_db($database_Base, $Base);
$query_ProcesosDet = sprintf("SELECT * FROM Procesos WHERE Placa = %s ORDER BY id ASC", GetSQLValueString($colname_ProcesosDet, "text"));
$ProcesosDet = mysql_query($query_ProcesosDet, $Base) or die(mysql_error());
$row_ProcesosDet = mysql_fetch_assoc($ProcesosDet);
$totalRows_ProcesosDet = mysql_num_rows($ProcesosDet);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalles de Placa</title>
<link type="text/css" href="themes/blitzer/ui.all.css" rel="stylesheet" />
<link REL=StyleSheet HREF="css/divisiones.css" TITLE="Divisiones" />

<link rel="shortcut icon" href="imagenes/kme.ico" type="image/x-icon"/>
<link rel="icon" href="imagenes/kme.ico" type="image/x-icon" />

<script type="text/javascript" src="js/jquery-1.3.2.min.js"> </script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"> </script>
<script type="text/javascript" src="js/ui/ui.core.js"></script>
<script type="text/javascript" src="js/ui/ui.datepicker.js"></script>
<script type="text/javascript" src="js/ui.datepicker-es.js"></script>


<script  type="text/javascript">
function confirmSubmit()
{
var agree=confirm("¿Seguro que quiere Borrar?");
if (agree)
	return true ;
else
	return false ;
}
</script>

<script type="text/javascript">
$(function() {
 for(j=1;j<=<?php echo $totalRows_ProcesosDet;?>; j++)
 {
 $("#datepicker"+j).datepicker({dateFormat: 'yy-mm-dd', showButtonPanel: true});
 $("#datepickerr"+j).datepicker({dateFormat: 'yy-mm-dd', showButtonPanel: true});
 }
});
</script>

</head>

<body>


<div id="navbar">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
        <style type="text/css">
                 .mylink img{border:0}
        </style>
    <td>
        <div align="center"><a class="mylink" href="index.php"><img src="imagenes/kme-1.jpg" alt="KME" width="98" height="42" /></a></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><p><a href="ingreso.php">Ingreso</a> </p></td>
    </tr>
    <tr>
      <td><p><a href="placasactuales.php">Detalles</a></p></td>
    </tr>
      <tr>
      <td><p><a href="tiempos.php">Tiempos</a></p></td>
    </tr>
    <tr>
      <td><p><a href="index.php">Gant</a></p></td>
    </tr>
       <tr>
      <td>&nbsp;</td>
    </tr>
       <tr>
      <td height="540px" border-right-color="maroon">&nbsp;</td>
       </tr>
  </table>
</div>

<div id="main">

 <!--Infoo General-->
 <table width="70%" border="0" cellspacing="0" cellpadding="0">
      <tr>
          <td colspan="6">
              &nbsp;
          </td>
      </tr>
  <tr>
    <td width="3%" class="B12">Placa:</td>
    <td width="12%" class="tituloPlacas2"><?php echo $row_Detalles1['Placa']; ?></td>
    <td width="4%" class="B12">Especificaci&oacute;n:</td>
    <td width="10%" class="N12"><?php echo $row_Detalles1['Detalle']; ?></td>
    <td width="4%" class="B12">Cliente:</td>
    <td width="10%" class="N12"><?php echo $row_Detalles1['Cliente']; ?></td>
  </tr>
  <tr>
      <td width="3%" class="B12">Ingres&oacute;:</td>
    <td class="N12"><?php echo $f1=date('d/M/y  H:i', strtotime($row_Detalles1['Ingreso'])); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<!--Tabla de detalles -->
 <table width="100%" border="1" cellpadding="0" cellspacing="0">
   <tr>
     <td  class="B12">Proceso</td>
     <td  class="B12">F.Esperada Ini</td>
     <td  class="B12">F.Esperada Fin</td>
     <td  class="B12">F.Actual Ini</td>
     <td  class="B12">F.Actual Fin</td>
     <td  class="B12">Comentarios</td>

   </tr>
   <?php $i=0;?>
   <?php do {
   $i=$i+1;
   $picker="datepicker".$i;
   $picker2="datepickerr".$i;
   //Factual INI
   switch ($row_ProcesosDet['FActual_Ini']) {
    case NULL:
	   $display_t_ini = "text";
	   $display_s_ini= "submit";
           $clase_ini= "N12";
      break;
    default:
	  $display_t_ini = "hidden";
	  $display_s_ini= "hidden";
          $clase_ini= "hide";
	  $fecha_ini=date('d/M/y  H:i', strtotime($row_ProcesosDet['FActual_Ini']));
   	  break;
	}
    //Factual FIN
    Switch ($row_ProcesosDet['FActual_Fin']) {
    case NULL:
	   $display_t_fin = "text";
	   $display_s_fin= "submit";
           $clase_fin= "N12";
      break;
    default:
	  $display_t_fin = "hidden";
	  $display_s_fin= "hidden";
          $clase_fin= "hide";
          $fecha_fin=date('d/M/y  H:i', strtotime($row_ProcesosDet['FActual_Fin']));
   	  break;
	}
     //Commentarios
    Switch ($row_ProcesosDet['Comentarios']) {
    case NULL:
	   $display_s_comm= "submit";
           $t_comm="block";
      break;
    default:
	  $display_s_comm= "hidden";
          $t_comm="none";
   	  break;
	}
        ?>

   <tr>
<!--Desplegar Detalels -->
    <!--Proceso-->
     <td class="N12"><?php echo $row_ProcesosDet['Proceso']; ?></td>

     <!--FEsperada Ini-->
     <td width="110px" class="N12"><?php echo $f1=date('d/M/y  H:i', strtotime($row_ProcesosDet['FEsperada_Ini'])); ?></td>
    <!--FEsperada Fin-->
     <td width="110px" class="N12"><?php echo $f1=date('d/M/y  H:i', strtotime($row_ProcesosDet['FEsperada_Fin'])); ?></td>


    <!--Columna de FActual INI -->
     <td class="N12">
        <form action="<?php echo $editFormAction_ini; ?>" method="post" name="inicio" id="inicio">
            <table cellpadding="0" cellspacing="0" border="0" align="center">
             <tr>
                 <!--fecha-->
                 <td>
                        <?php
                            if( $row_ProcesosDet['FActual_Ini']!= NULL )
                         {
                             echo $fecha_ini;
                         }

                         ?>

                      <input type="<?php echo $display_t_ini;?>" name="Date_ini" id="<?php echo $picker;?>" size="6"/>
                 </td>
                 <!--Submit-->
                 <td>
                     <input type="<?php echo $display_s_ini; ?>" value="Submit"/>
                 </td>
             </tr>
             <tr>
                    <?php
                        if ($display_s_ini == 'hidden')
                        {
                        ?>
                        <td>
                         <!--Borrar-->
                         <form method="POST" action="<?php echo $editFormAction_ini; ?>" id="borrar_ini" name="borrar_ini">
                             <center><input type="Submit" name="Delete" value="Delete" onClick="return confirmSubmit()"/></center>
                            <input type="hidden" name="MM_b_ini" value="borrar_ini" />
                            <input type="hidden" name="Placa" value="<?php echo $row_ProcesosDet['Placa']; ?>" />
                            <input type="hidden" name="Proceso" value="<?php echo $row_ProcesosDet['Proceso']; ?>" />
                            <input type="hidden" name="FEsperada_ini" value="<?php echo $row_ProcesosDet['FEsperada_ini']; ?>" />
                        </form>
                            </td>
                        <?php
                        } else{
                        ?>
                             <!--H-->
                             <td>
                                  <label class="<?php echo $clase_ini;?>">H:
                                  <select name="Hora_ini" id="Hora_ini">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                    <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                    <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                    <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                    <option value="19">19</option>
                                        <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                        <option value="24">24</option>
                                  </select>
                                  </label>
                             </td>
                             <!--M-->
                             <td>
                                <label class="<?php echo $clase_ini;?>">M:
                                  <select name="Min_ini" id="Min_ini">
                                <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                    <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                    <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                    <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                    <option value="19">19</option>
                                        <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                        <option value="24">24</option>
                                    <option value="25">25</option>
                                        <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                    <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                    <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                    <option value="39">39</option>
                                        <option value="40">40</option>
                                        <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                        <option value="44">44</option>
                                        <option value="45">45</option>
                                    <option value="46">46</option>
                                        <option value="47">47</option>
                                        <option value="48">48</option>
                                    <option value="49">49</option>
                                        <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                        <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                        <option value="59">59</option>
                                  </select>
                                  </label>
                             </td>
                      <?php } ?>
             </tr>
         </table>
         <input type="hidden" name="MM_inicio" value="inicio" />
         <input type="hidden" name="Placa" value="<?php echo $row_ProcesosDet['Placa']; ?>" />
         <input type="hidden" name="Proceso" value="<?php echo $row_ProcesosDet['Proceso']; ?>" />
         <input type="hidden" name="FEsperada_Ini" value="<?php echo $row_ProcesosDet['FEsperada_Ini']; ?>" />
         <input type="hidden" name="FEsperada_Fin" value="<?php echo $row_ProcesosDet['FEsperada_Fin']; ?>" />
        </form>
     </td>

     <!--FActual FIN-->
     <td  class="N12">
       <form action="<?php echo $editFormAction_fin; ?>" method="post" name="fin" id="fin">
         <table cellpadding="0" cellspacing="0" border="0" align="center">
             <tr>
                 <!--fecha-->
                 <td>
                       <?php
                            if( $row_ProcesosDet['FActual_Fin']!= NULL )
                         {
                             echo $fecha_fin;
                         }

                         ?>

                      <input type="<?php echo $display_t_fin;?>" name="Date_fin" id="<?php echo $picker2;?>" size="6"/>
                 </td>
                 <!--Submit-->
                 <td>
                     <input type="<?php echo $display_s_fin; ?>" value="Submit"/>
                 </td>
             </tr>
             <tr>
                 <?php
                        if ($display_s_fin == 'hidden')
                        {
                        ?>
                        <td>
                         <!--Borrar-->
                         <form method="POST" action="<?php echo $editFormAction_fin; ?>" id="borrar_fin" name="borrar_fin">
                             <center><input type="Submit" name="Delete" value="Delete" onClick="return confirmSubmit()"/></center>
                            <input type="hidden" name="MM_b_fin" value="borrar_fin" />
                            <input type="hidden" name="Placa" value="<?php echo $row_ProcesosDet['Placa']; ?>" />
                            <input type="hidden" name="Proceso" value="<?php echo $row_ProcesosDet['Proceso']; ?>" />
                            <input type="hidden" name="FEsperada_ini" value="<?php echo $row_ProcesosDet['FEsperada_ini']; ?>" />
                        </form>
                            </td>
                        <?php
                        } else{
                        ?>
                             <!--H-->
                             <td>
                                  <label class="<?php echo $clase_fin;?>">H:
                                  <select name="Hora_fin" id="Hora_fin">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                    <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                    <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                    <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                    <option value="19">19</option>
                                        <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                        <option value="24">24</option>
                                  </select>
                                  </label>
                             </td>
                             <!--M-->
                             <td>
                                <label class="<?php echo $clase_fin;?>">M:
                                  <select name="Min_fin" id="Min_fin">
                                <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                    <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                    <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                    <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                    <option value="19">19</option>
                                        <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                        <option value="24">24</option>
                                    <option value="25">25</option>
                                        <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                    <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                    <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                    <option value="39">39</option>
                                        <option value="40">40</option>
                                        <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                        <option value="44">44</option>
                                        <option value="45">45</option>
                                    <option value="46">46</option>
                                        <option value="47">47</option>
                                        <option value="48">48</option>
                                    <option value="49">49</option>
                                        <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                        <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                        <option value="59">59</option>
                                  </select>
                                  </label>
                             </td>
                      <?php } ?>
             </tr>
         </table>
         <input type="hidden" name="MM_fin" value="fin" />
         <input type="hidden" name="Placa" value="<?php echo $row_ProcesosDet['Placa']; ?>" />
         <input type="hidden" name="Proceso" value="<?php echo $row_ProcesosDet['Proceso']; ?>" />
         <input type="hidden" name="FEsperada_Ini" value="<?php echo $row_ProcesosDet['FEsperada_Ini']; ?>" />
         <input type="hidden" name="FEsperada_Fin" value="<?php echo $row_ProcesosDet['FEsperada_Fin']; ?>" />
        </form>
     </td>

     <!--COMENTARIOS-->
     <td class="N12">
         <form action="<?php echo $editFormAction_comm; ?>" method="post" name="comm" id="comm">
             <table cellpadding="0" cellspacing="0" border="0">
             <tr>
                 <td>
                    <?php if( $row_ProcesosDet['Comentarios']!= NULL )
                             {
                                 if (strlen($row_ProcesosDet['Comentarios']) < '20')
                                     {
                                         $altura='25px';
                                     }
                                     else
                                     {
                                         $altura='40px';
                                     }
                                 ?>
                                        <div style="width:152px; height:<?php echo $altura; ?>; overflow:auto;">
                                          <?php echo $row_ProcesosDet['Comentarios'];?>
                                        </div>
                                <?php }?>
                     <textarea name="comentarios" cols="16" rows="2" style="display:<?php echo $t_comm;?>;"></textarea>
                 </td>
                 <td>
                    <?php if ($row_ProcesosDet['Comentarios']!= NULL)
                      {
                      ?>
                        <!--Borrar-->
                        <form method="POST" action="<?php echo $editFormAction_fin; ?>" id="borrar_comm" name="borrar_comm">
                         <center><input type="Submit" name="Delete" value="Borrar" onClick="return confirmSubmit()"/></center>
                         <input type="hidden" name="MM_comm" value="borrar_comm" />
                         <input type="hidden" name="Placa" value="<?php echo $row_ProcesosDet['Placa']; ?>" />
                         <input type="hidden" name="Proceso" value="<?php echo $row_ProcesosDet['Proceso']; ?>" />
                         <input type="hidden" name="FEsperada_ini" value="<?php echo $row_ProcesosDet['FEsperada_ini']; ?>" />
                        </form>
                        <?php
                       } else{
                      ?>
                        <input type="<?php echo $display_s_comm; ?>" value="Agregar"/>
                      <?php }?>
                 </td>
             </tr>
         </table>
        <input type="hidden" name="MM_comm" value="comm" />
         <input type="hidden" name="Placa" value="<?php echo $row_ProcesosDet['Placa']; ?>" />
         <input type="hidden" name="Proceso" value="<?php echo $row_ProcesosDet['Proceso']; ?>" />
         <input type="hidden" name="FEsperada_Ini" value="<?php echo $row_ProcesosDet['FEsperada_Ini']; ?>" />
         <input type="hidden" name="FEsperada_Fin" value="<?php echo $row_ProcesosDet['FEsperada_Fin']; ?>" />
        </form>
     </td>
   </tr>
   <?php } while ($row_ProcesosDet = mysql_fetch_assoc($ProcesosDet)); ?>

 </table>

</div>
</body>
</html>

<?php
mysql_free_result($Detalles1);
mysql_free_result($ProcesosDet);
?>