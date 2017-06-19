<?php
/**
 * //License information must not be removed.
 * 
 * PHP version 5.4x
 * 
 * @Category ### Gripsell ###
 * @Package ### Advanced ###
 * @Architecture ### Secured  ###
 * @Copyright Copyright (c) 2013 {@URL http://www.gripsell.com Gripsell Tech}
 * @License EULA License http://www.gripsell.com
 * @Author $Author: Gripsell $ 
 * @version $Version: 5.3.6 $
 * @Last Version $Date: 2013-15-05 18:26:21 +0530 (Wed, 15 May 2013) $
 */
require_once 'JSON/JSON.php';
function json_encode( $arg )



{
     global $services_json;
     if ( !isset( $services_json ) ) {
        $services_json = new Services_JSON();
         } 
    return $services_json -> encode( $arg );
     } 
function json_decode( $arg )



{
     global $services_json;
     if ( !isset( $services_json ) ) {
        $services_json = new Services_JSON();
         } 
    return $services_json -> decode( $arg );
     } 
?>
