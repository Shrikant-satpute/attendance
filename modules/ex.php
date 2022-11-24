<?php
 //global $a;
 $a=10;

 function asd()
 {
    global $a;
    //echo $a;
    function zxc()
    {
        global $a;
        echo $a;
    }
    zxc();
 }
 asd();



?>

<?php
$b=20;
function asw()
{
    global $a,$b;

    echo $a , $b;
}
    asw();
?>