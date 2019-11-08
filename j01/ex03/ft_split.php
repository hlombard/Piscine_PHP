<?php
function ft_split($str)
{
    $tab = explode (" ", $str);
    $tab = array_filter($tab);
    sort($tab);
    return ($tab);
}
?>
