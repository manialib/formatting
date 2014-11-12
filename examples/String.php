<?php

use Manialib\Formatting\String;

require_once '..\vendor\autoload.php';

$originalString = '$l[lien]$f09lien externe$l $tet$t $hlien interne$h';

//To modify styles in the string, we create a String object first
$string = new String($originalString);
//You can easily strip several styles at once with the fluent interface
echo $string->stripColors()->stripLinks();
//ouput: lien externe $tet$t lien interne