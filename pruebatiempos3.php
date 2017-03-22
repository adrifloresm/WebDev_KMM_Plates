<?php
$tproc=1.5;
$hini="8:00";
$hfin="9:00";

$tant="2010-03-05 08:00";
$ts_tant = strtotime($tant);
$dateparts = getdate($ts_tant);

$i = strtotime($hini, $ts_tant);
$d_i = date("Y-m-d H:i", $i);

$f = strtotime($hfin, $ts_tant);
$d_f = date("Y-m-d H:i", $f);

$suma=date('Y-m-d H:i', strtotime($tant)+3600*$tproc);
$ts_suma = strtotime($suma);


   if($ts_suma < $f)
   {
       echo $suma;
       echo "menor ";
       //Guarda FEINI-tant FE FIN-Suma
   }
   else
   {
       $restante=$ts_suma-$f;
       if($dateparts['weekday']=="Saturday"){
           $i = strtotime("+2days".$hini, $ts_tant);
           $d_i = date("Y-m-d H:i", $i);
       }
   }

?>
