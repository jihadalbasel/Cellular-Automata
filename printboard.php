<?php
function printBoard($board)
{
    if(!sizeof($board))
    {
        echo "[]";
        return;
    }
    $toR = "[";
    foreach($board as $i=>$v)
        $toR .= ($v?1:0).",";
    return substr($toR,0,-1)."]";
}

function loadPage()
{
    $load = "0";
    $r = 38;
    $c = 38;
    if(isset($_GET['r']) && isset($_GET['c']))
    {
        if(isset($_GET['load']))
        {
            $load = $_GET['load'];
            if(!preg_match("/^[}{".alpha."]*\$/",$load))
            {
                echo "alert('error load data: $load');";
                $load = "0";
            }
        }
        $r = $_GET['r'];
        $c = $_GET['c'];
    }
    $pT = "            ";   // properTabbage
    $toR = "";
    $toR .= "var ALPHA = \"".alpha."\";\n";
    $toR .= $pT."var r = $r;\n";
    $toR .= $pT."var c = $c;\n";
    $toR .= $pT."var board = ".printBoard(decode($load,$r*$c)).".slice(0,r*c);   // php source code\n";
    echo $toR;
    return true;
}
?>