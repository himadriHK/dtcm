<?php
$name='Georgia';
$type='TTF';
$desc=array (
  'Ascent' => 917,
  'Descent' => -219,
  'CapHeight' => 917,
  'Flags' => 4,
  'FontBBox' => '[-173 -217 1167 912]',
  'ItalicAngle' => 0,
  'StemV' => 87,
  'MissingWidth' => 1000,
);
$up=-88;
$ut=49;
if($_SERVER['REMOTE_ADDR']!='127.0.0.1')
$ttffile=DIR_FRONT.'/functions/include/library/tfpdf/font/unifont/georgia.ttf';
else
$ttffile=DIR_FRONT.'\functions\include\library\tfpdf\font\unifont\georgia.ttf';
$originalsize=155068;
$fontkey='georgia';
?>