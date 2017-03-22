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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$Ingreso=$_POST['Date']." ".$_POST['Hora'].":".$_POST['Min'];
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE Procesos SET FActual=%s, Comentarios=%s WHERE Placa=%s and Proceso=%s and FEsperada=%s",
                       GetSQLValueString($Ingreso, "date"),
                       GetSQLValueString($_POST['Comentarios'], "text"),
                       GetSQLValueString($_POST['Placa'], "text"),
                       GetSQLValueString($_POST['Proceso'], "text"),
		       GetSQLValueString($_POST['FEsperada'], "text"));

  mysql_select_db($database_Base, $Base);
  $Result1 = mysql_query($updateSQL, $Base) or die(mysql_error());
}
if ((isset($_POST["MM_update2"])) && ($_POST["MM_update2"] == "submitform")) {
  $updateSQL2 = sprintf("UPDATE Procesos SET FActual=%s, Comentarios=%s WHERE Placa=%s and Proceso=%s and FEsperada=%s",
                       GetSQLValueString(NULL, "text"),
                       GetSQLValueString(NULL, "text"),
                       GetSQLValueString($_POST['Placa'], "text"),
                       GetSQLValueString($_POST['Proceso'], "text"),
		       GetSQLValueString($_POST['FEsperada'], "text"));

  mysql_select_db($database_Base, $Base);
  $Result2 = mysql_query($updateSQL2, $Base) or die(mysql_error());
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
$query_ProcesosDet = sprintf("SELECT * FROM Procesos WHERE Placa = %s ORDER BY FEsperada ASC, id ASC", GetSQLValueString($colname_ProcesosDet, "text"));
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

<link rel="shortcut icon" href="imagenes/kme.ico" type="image/x-icon">
<link rel="icon" href="imagenes/kme.ico" type="image/x-icon" />

<script type="text/javascript" src="js/jquery-1.3.2.min.js"> </script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"> </script>
<script type="text/javascript" src="js/ui/ui.core.js"></script>
<script type="text/javascript" src="js/ui/ui.datepicker.js"></script>
<script type="text/javascript" src="js/ui.datepicker-es.js"></script>


<script language="JavaScript">
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
 }
});
</script>

</head>

<body>


<div id="navbar2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
        <style type="text/css">
                 .mylink img{border:0}
        </style>
    <td>
        <div align="center"><a class="mylink" href="index.php"><img src="imagenes/kme-1.jpg" width="98" height="42" /></a></div></td>
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

 <table width="70%" border="0" cellspacing="0" cellpadding="0">
      <tr>
          <td colspan="6">
              &nbsp;
          </td>
      </tr>
  <tr>
    <td width="3%" class="B16">Placa:</td>
    <td width="12%" class="tituloPlacas"><?php echo $row_Detalles1['Placa']; ?></td>
    <td width="4%" class="B16">Especificaci&oacute;n:</td>
    <td width="10%" class="N16"><?php echo $row_Detalles1['Detalle']; ?></td>
    <td width="4%" class="B16">Cliente:</td>
    <td width="10%" class="N16"><?php echo $row_Detalles1['Cliente']; ?></td>
  </tr>
  <tr>
      <td width="3%" class="B16">Ingres&oacute;:</td>
    <td><?php echo $f1=date('d/M/y  H:i', strtotime($row_Detalles1['Ingreso'])); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<!--Tabla de detalles -->
 <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
   <tr>
     <td width="35%" class="B16">Proceso</td>
     <td width="15%" class="B16">F.Esperada</td>
     <td width="20%" class="B16">F.Actual</td>
     <td width="25%" class="B16">Comentarios</td>
     <td width="5%" class="B16">Submit</td>
   </tr>
   <?php $i=0;?>
   <?php do {
   $i=$i+1;
   $picker="datepicker".$i;

   switch ($row_ProcesosDet['FActual']) {
    case NULL:
	   $display = "text";
	   $display2= "submit";
           $clase= "style3";
      break;
    default:
	  $display = "hidden";
	  $display2= "hidden";
          $clase= "hide";
	  $fecha=date('d/M/y  H:i', strtotime($row_ProcesosDet['FActual']));
   	  break;
	}?>

   <tr>
<!--Desplegar Detalels -->
     <td width="35%"><?php echo $row_ProcesosDet['Proceso']; ?></td>
     <td width="15%"><?php echo $f1=date('d/M/y  H:i', strtotime($row_ProcesosDet['FEsperada'])); ?></td>

     <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
     <!--Columna de FActual -->
     <td width="22%" class="N16">
        <?php
            if( $row_ProcesosDet['FActual']!= NULL )
         {
             echo $fecha;
         }

         ?>

      <input type="<?php echo $display;?>" name="Date" id="<?php echo $picker;?>" size="6"/>

      <label class="<?php echo $clase;?>">H:
      <select name="Hora" id="Hora">
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

      <label class="<?php echo $clase;?>">M:
      <select name="Min" id="Min">
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


     <td width="175px" class="N16">
      <?php
	if( $row_ProcesosDet['FActual']!= NULL )
         {
             if (strlen($row_ProcesosDet['Comentarios']) < '31')
                 {
                     $altura='20px';
                 }
                 else
                 {
                     $altura='35px';
                 }
             ?>
                    <div style="width:270px; height:<?php echo $altura; ?>; overflow:auto;">
                      <?php echo $row_ProcesosDet['Comentarios'];?>
                    </div>
            <?php }?>
         <input type="<?php echo $display; ?>" name="Comentarios" value="" size="40" />
     </td>

     <td width="5%" class="N16">
         <div align="center"><input type="<?php echo $display2; ?>" value="Submit" STYLE="border-color:teal; color:teal"/>
            <?php
            if ($display2 == 'hidden')
            {
            ?>
             <form method="POST" action="<?php echo $editFormAction; ?>" id="submitform" name="submitform">
                <input type="Submit" name="Delete" value="Delete" onClick="return confirmSubmit()" STYLE="border-color:red; color:red"/>
                <input type="hidden" name="MM_update2" value="submitform" />
                <input type="hidden" name="Placa" value="<?php echo $row_ProcesosDet['Placa']; ?>" />
                <input type="hidden" name="Proceso" value="<?php echo $row_ProcesosDet['Proceso']; ?>" />
                <input type="hidden" name="FEsperada" value="<?php echo $row_ProcesosDet['FEsperada']; ?>" />
            </form>
            <?php
            }
            ?>
         </div>
     </td>

         <input type="hidden" name="MM_update" value="form1" />
         <input type="hidden" name="Placa" value="<?php echo $row_ProcesosDet['Placa']; ?>" />
         <input type="hidden" name="Proceso" value="<?php echo $row_ProcesosDet['Proceso']; ?>" />
         <input type="hidden" name="FEsperada" value="<?php echo $row_ProcesosDet['FEsperada']; ?>" />
     </form>
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