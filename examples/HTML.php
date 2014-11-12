<?php

use Manialib\Formatting\Converters\HTML;

require '../vendor/autoload.php';
$originalString = '$f09couleur et $hlien$h';

//To convert this string into HTML.
//You have to create an HTML object first
$html = new HTML($originalString);
echo $html->getResult();
//output: <span style="color:#f09;">couleur et </span><a href="maniaplanet:///:lien" style="color:inherit;"><span style="color:#f09;">lien</span></a>