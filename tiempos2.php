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

function identificaCol($colConClase,$numCol){
    if( $colConClase == $numCol )
        return "selecionado";
    else
        return "";
}

//TOdos los Tiempos
mysql_select_db($database_Base, $Base);
$query_TiemposID1 = "SELECT * FROM tiempos ORDER BY id ASC";
$TiemposID1 = mysql_query($query_TiemposID1, $Base) or die(mysql_error());
$row_TiemposID1 = mysql_fetch_assoc($TiemposID1);
$totalRows_TiemposID1 = mysql_num_rows($TiemposID1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KME Control de Placas</title>
<link REL=StyleSheet HREF="css/divisiones.css" TITLE="Divisiones" />
<link rel="shortcut icon" href="imagenes/kme.ico" type="image/x-icon"/>
<link rel="icon" href="imagenes/kme.ico" type="image/x-icon" />
</head>

<body>
<div id="navbar">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td>
        <style type="text/css">
                 .mylink img{border:0}
        </style>
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
    </table>
</div>
<div id="main">
<div id="col1">
<div id="header" class="titulos">
Administracion de Tiempos
</div>
<div id="parte1">
    <table border="0" cellpadding="3" cellspacing="0" align="center">
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="B16" colspan="2" align="center">Tiempo Cambiado</td>
                    </tr>

                  <tr>
                       <td class="NegDer">Cliente: </td>
                       <td class="style3"><?php  echo $_GET['C'];?></td>
                   </tr>
                   <tr>
                        <td class="NegDer">Proceso: </td>
                       <td class="style3"><?php  echo $_GET['P'];?></td>
                   </tr>
                   <tr>
                        <td class="NegDer">Tiempo Nuevo: </td>
                        <td class="style3"><?php  printf("%10.2f",$_GET['Tn']); ?></td>
                   </tr>
              </table>
</div>
</div>
<div id="col2">
        <div id="header" class="titulos">
        Todos los Tiempos
        </div>
        <div id="parte1">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>
            <td class="style4">Proceso</td>
            <td width="117" height="20" class="style4"><div align="center">Ahmsa CC-2</div></td>
            <td width="117" class="style4"><div align="center">Ahmsa CC-3</div></td>
            <td width="117" class="style4"><div align="center">Hylsa</div></td>
            <td width="117" class="style4"><div align="center">Mittal</div></td>
            <td width="117" class="style4"><div align="center">Angostas</div></td>
          </tr>
          <?php  do {
              if ($row_TiemposID1['Proceso']== "Total:")
                  {
                      $clase="style4";
                      $al="right";
                  }
                  else
                      {
                          $clase="style3";
                          $al="left";
                      }


                          $cl=$_GET['C'];
                          $pr=$_GET['P'];

                       if($row_TiemposID1['Proceso']==$pr)
                      {
                          $clase2="selecionado";
                      }
                      else
                      {
                              $clase2="";
                      }

                       switch ($cl) {
                        case "AhmsaCC2":
                            $colACambiar=1;
                            break;
                        case "AhmsaCC3":
                            $colACambiar=2;
                            break;
                        case "Hylsa":
                            $colACambiar=3;
                            break;
                        case "Mittal":
                            $colACambiar=4;
                            break;
                        case "Angostas":
                            $colACambiar=5;
                            break;
                       }
                  
              ?>

          <tr class="<?php echo $clase2;?>" >
            <td width="473" align="<?php echo $al;?>"class="<?php echo $clase; ?>">
            <?php echo $row_TiemposID1['Proceso']; ?>
            </td>
            <td width="117" height="20" class="<?php echo $clase; ?>">
                <div align="center" class="<?php echo identificaCol($colACambiar,1);?>">
                <?php printf("%10.2f", $row_TiemposID1['AhmsaCC2']); ?>
                </div></td>
            <td width="117" class="<?php echo $clase;?>">
                <div align="center" class="<?php echo identificaCol($colACambiar,2); ?>">
                <?php printf("%10.2f", $row_TiemposID1['AhmsaCC3']); ?>
                </div></td>
            <td width="117" class="<?php echo $clase; ?>">
                <div align="center" class="<?php echo identificaCol($colACambiar,3); ?>">
                <?php printf("%10.2f", $row_TiemposID1['Hylsa']); ?>
                </div></td>
            <td width="117" class="<?php echo $clase; ?>">
                <div align="center" class="<?php echo identificaCol($colACambiar,4); ?>">
                <?php printf("%10.2f", $row_TiemposID1['Mittal']); ?>
                </div></td>
            <td width="117" class="<?php echo $clase; ?>">
                <div align="center" class="<?php echo identificaCol($colACambiar,5); ?>">
                <?php printf("%10.2f", $row_TiemposID1['Angostas']); ?>
                </div></td>
          </tr>
         <?php } while ($row_TiemposID1 = mysql_fetch_assoc($TiemposID1)); ?>
        </table>
        </div>
    </div>
</div>

</body>
</html>

<?php
mysql_free_result($TiemposID1);
?>