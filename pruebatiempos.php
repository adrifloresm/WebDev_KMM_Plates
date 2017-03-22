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

$t_tfin = 0;
$t_tini = 0;
$t_dateparts2 = 0;
$t_suma = 0;
$t_placa = 0;
$t_proc = 0;
$t_tant = 0;
$t_database_Base = 0;
$t_Base = 0;
$t_sumadias = 0;

function tiempos()
{
    $ts_tfin = strtotime($t_tfin);

    $ts_tini = strtotime($t_tini);

    $hm=$t_dateparts2['hours'].":".$t_dateparts2['minutes'];
    $ts_hm = strtotime($hm);

        if($ts_hm<$ts_tfin)
        {
            //Menor
            $tnuevo=$t_suma;
            //GUARDA
            guarda($t_placa, $t_proc, $t_tant, $t_tnuevo, $t_database_Base,  $t_Base);
            $t_tant=$tnuevo;
            return $t_tant;
        }
        else
        {
            //Mayor
            //Horas Restantes Suma- tfin
            $dif=$ts_hm-$ts_tfin;

            //hora sig dia
            $horainiseg = $ts_tini + $dif;
            $hora_sigdia=date('H:i', $horainiseg); //Checar si esta no se pasa Recursivo
            if($hora_sigdia<$t_tfin)
            {
                //Dia++
                $dianuevo=$t_dateparts2['mday']+$t_sumadias;
                $mes=dosnum($t_dateparts2['mon']);
                $dia=dosnum($dianuevo);

                $resultado=$t_dateparts2['year']."-".$mes."-".$dia." ".$hora_sigdia;
                $tnuevo=$resultado;
                //GUARDA
                guarda($t_placa, $t_proc, $t_tant, $tnuevo, $t_database_Base,  $t_Base);
                $t_tant=$tnuevo;
                return $t_tant;
            }
        }
}
function guarda($placa, $proc, $tant, $tnuevo, $database_Base,  $Base)
{
    $insertSQL1 = sprintf("INSERT INTO Procesos (Placa, Proceso, FEsperada_Ini, FEsperada_Fin) VALUES (%s, %s, %s, %s)",
    GetSQLValueString($placa, "text"),
    GetSQLValueString($proc,"text"),
    GetSQLValueString($tant, "date"),
    GetSQLValueString($tnuevo, "date"));

    mysql_select_db($database_Base, $Base);
    $Result1 = mysql_query($insertSQL1, $Base) or die(mysql_error());

}
function dosnum($var)
{
  if($var < 10)
  {
      $var="0".$var;
  }
  return $var;
}


//TOdos los Tiempos
mysql_select_db($database_Base, $Base);
$query_TiemposID1 = "SELECT * FROM tiempos ORDER BY id ASC";
$TiemposID1 = mysql_query($query_TiemposID1, $Base) or die(mysql_error());
$row_TiemposID1 = mysql_fetch_assoc($TiemposID1);
$totalRows_TiemposID1 = mysql_num_rows($TiemposID1);

$f_act="2010-03-05 08:00";
$placa="prueba2";
//Agregar  a Procesos
$tant=$f_act;
 // strtotime("tomorrow ".$horaincio."am",$dia)

    do { //Por cada tiempos
        //1Modulo Si Nikelado
        if($row_TiemposID1['NumProc']=='14')
        {
                //Normal
                $proc=$row_TiemposID1['Proceso'];
                $tproceso=$row_TiemposID1["Hylsa"];
                $resultado=date('Y-m-d H:i:s', strtotime($tant)+3600*$tproceso);
                $tnuevo=$resultado;
                //GUARDA
                guarda($placa, $proc, $tant, $tnuevo, $database_Base,  $Base);
                $tant=$tnuevo;

        }
        else //NO Proc Nikelado
            {
                $ts_tant = strtotime($tant);
                $dateparts = getdate($ts_tant);
                $weekday = $dateparts['weekday'];

                $tproceso=$row_TiemposID1["Hylsa"];
                $proc=$row_TiemposID1['Proceso'];

                $suma=date('Y-m-d H:i', strtotime($tant)+3600*$tproceso);
                $ts_suma = strtotime($suma);
                $dateparts2 = getdate($ts_suma);

                //2Modulo Si Sabado
                if($weekday=="Saturday") //SI SABDO
                {
                $tfin="13:00";
                $tini="8:00";
                //FUNCIOOON..........
                $t_tfin=$tfin;/*1pm*/
                $t_tini=$tini;/*del proc*/$t_dateparts2=$dateparts2;
                $t_suma=$suma;
                $t_placa=$placa;
                $t_proc=$proc;
                $t_tant=$tant;
                $t_database_Base=$database_Base;
                $t_Base=$Base;
                $t_sumadias=2;
                $tant=tiempos();
                //$tant=tiempos($tfin/*1pm*/,$tini/*del proc*/,$dateparts2, $suma, $placa, $proc, $tant, $database_Base, $Base,2);

                }
//---------------------------------------------------------------------------------------------------//
                else // DIa de Entre Semana
                {
                $tfin="13:00";/*del proc*/
                $tini="8:00";/*del proc*/
                //FUNCIOOON..........
                $t_tfin=$tfin;/*1pm*/
                $t_tini=$tini;/*del proc*/$t_dateparts2=$dateparts2;
                $t_suma=$suma;
                $t_placa=$placa;
                $t_proc=$proc;
                $t_tant=$tant;
                $t_database_Base=$database_Base;
                $t_Base=$Base;
                $t_sumadias=2;
                $tant=tiempos();
                //$tant=tiempos($tfin, $tini, $dateparts2, $suma, $placa, $proc, $tant, $database_Base, $Base,1);
                  
                }
//---------------------------------------------------------------------------------------------------//     
            }

    } while ($row_TiemposID1 = mysql_fetch_assoc($TiemposID1));

?>