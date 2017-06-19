<?php
/**
 * //License information must not be removed.
 * PHP version 5.2x
 * 
 * @category ### Gripsell ###
 * @package ### Advanced ###
 * @arch ### Secured  ###
 * @author Development Team, Gripsell Technologies & Consultancy Services 
 * @copyright Copyright (c) 2010 {@URL http://www.gripsell.com Gripsell Tech}
 * @license http://www.gripsell.com Clone Portal
 * @version 4.3.1
 * @since 2011-06-14
 */
class Invoice {
    private static $options = array( 'template' => 'default_template' );
     public function Invoice()
    
    
    {
         $temp = func_get_args();
         call_user_func_array( array( 'Invoice', 'init' ), $temp );
         } 
    static public function init()
    
    
    {
         $args_num = func_num_args();
         $args = func_get_args();
         for( $i = 0;$i < $args_num;$i++ ) {
            if ( $i == 0 && is_array( $args[0] ) ) {
                foreach( $args[0] as $v => $val ) {
                    self :: $options[$v] = $val;
                     } 
                } 
            } 
        } 
    static public function display( $mode, $options = array(), $return = false )
    
    
    {
         if ( $mode == 'html' || $mode == 'pdf' ) {
            $function = '_generate_' . $mode;
             $generate = self :: $function( $options );
             if ( !$return ) {
                if ( $mode == 'pdf' ) {
                    header( 'Content-type: application/pdf' );
                     header( 'Content-Disposition: attachment; filename="' . self :: $options['savefile']['filename'] . '"' );
                     header( 'Cache-Control: private, max-age=0, must-revalidate' );
                     } 
                echo $generate;
                 return true;
                 } else {
                return $generate;
                 } 
            } 
        } 
    static public function apply_template( $template_name )
    
    
    {
         if ( !file_exists( DIR_BACKEND . '/invoice/tpl/' . $template_name . '.php' ) ) {
            trigger_error( 'Can\'t find template', E_USER_WARNING );
             return false;
             } else {
            self :: $options['template'] = $template_name;
             return true;
             } 
        } 
    static public function send_email( $subject, $message, $smtp = array(), $withAttachment = true )
    
    
    {
         require_once dirname( __FILE__ ) . '/class.phpmailer.php';
         $mail = new PHPMailer();
         if ( !empty( $smtp['host'] ) ) {
            $mail -> IsSMTP();
             $mail -> Host = $smtp['host'];
             $mail -> Port = ( ( !empty( $smtp['port'] ) ) ? intval( $smtp['port'] ) : 26 );
             if ( !empty( $smtp['username'] ) && !empty( $smtp['password'] ) ) {
                $mail -> Username = $smtp['username'];
                 $mail -> Password = $smtp['password'];
                 } 
            } 
        $mail -> SetFrom( self :: $options['company']['email'], self :: $options['company']['name'] );
         $mail -> AddReplyTo( self :: $options['company']['email'], self :: $options['company']['name'] );
         $mail -> Subject = $subject;
         $mail -> AltBody = 'Invoice from ' . self :: $options['company']['name'];
         $mail -> AddAddress( self :: $options['client']['email'], self :: $options['client']['name'] );
         if ( self :: $options['invoice']['sendBCC'] ) $mail -> AddBCC( self :: $options['company']['email'], self :: $options['company']['name'] );
         $mail -> MsgHTML( eregi_replace( "[\]", '', $message ) );
         if ( $withAttachment ) $mail -> AddStringAttachment( self :: _generate_pdf(), self :: $options['savefile']['filename'], 'base64', 'application/pdf' );
         if ( !$mail -> Send() ) {
            return 'phpmailer error: ' . $mail -> ErrorInfo;
             } else {
            return true;
             } 
        } 
    static private function _generate_pdf( $options )
    
    
    {
        /* if ( isset( $options['utf8'] ) ) {
            self :: $options = Invoice_encode_utf8( self :: $options );
             } 
        require_once( dirname( __FILE__ ) . '/fpdf.php' );
         $pdf = new FPDF();
         $pdf -> SetCompression( true );
         $pdf -> AddPage();
         $pdf -> SetFont( 'helvetica', '', 12 );*/
		 	require_once(dirname(__FILE__).'/tfpdf/tfpdf.php');
		$order= Table::Fetch('order', self::$options['invoice']['id']);	
		$pdf = new tFPDF();
		//$pdf->SetCompression(true);
		$pdf->AddPage();
		//$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
		$pdf->AddFont('georgia','','georgia.ttf',true);
                $pdf->SetFont('georgia','',14);
         $pdf -> SetAuthor( self :: $options['company']['name'] );
         $pdf -> SetCreator( 'Gripsell Invoicer 1.4' );
         $pdf -> SetSubject( self :: $options['invoice']['name'] );
         $pdf -> SetTitle( self :: $options['invoice']['name'] );
         $pdf -> Image( self :: $options['company']['logo'], 10, 8, 50 );
         $pdf -> MultiCell( 0, 5, self :: $options['company']['address'] . "\n" . self :: $options['company']['email'], 0, 'R' );
         $pdf -> Cell( 0, 1, '', 'B' );
         $pdf -> Ln();
         $pdf -> Cell( $pdf -> GetStringWidth( self :: $options['invoice']['name'] . ' (' . self :: $options['invoice']['date'] . ')' ), 8, self :: $options['invoice']['name'] . ' (' . self :: $options['invoice']['date'] . ')', 'B', 'L' );
         $pdf -> MultiCell( 0, 8, 'Invoice Due Date: ' . self :: $options['invoice']['due_date'], 'B', 'R' );
         $pdf -> Ln( 2 );
         $pdf -> MultiCell( 120, 5, 'Invoiced to' . "\n" . self :: $options['client']['address'] . "\n" . self :: $options['client']['email'], 0, 'L' );
         // Paid
        $pdf -> SetFont( 'georgia', '', 28 );
         $pdf -> SetTextColor( 100, 170, 70 );
         $pdf -> MultiCell( 0, 3, 'Paid', 0, 'R' );
         $pdf -> SetFont( 'georgia', '', 12 );
         $pdf -> SetTextColor( 0, 0, 0 );
         // Paid
        $pdf -> Ln( 2 );
         $pdf -> Cell( 120, 7, 'Item(s)', 1, 0, 'C' );
         $pdf -> Cell( 0, 7, 'Amount (' . self :: $options['invoice']['currency'] . ')', 1, 0, 'C' );
         $total = 0;
         foreach( self :: $options['items'] as $item_name => $item_detail ) {
            $pdf -> Ln();
             $x = $pdf -> GetX() + 120;
             $y = $pdf -> GetY();
             $pdf -> SetX( $x-120 );
             $pdf -> MultiCell( 120, 7, ( isset( $options['utf8'] ) ? Invoice_encode_utf8_string( $item_name ) : $item_name ) . "\n" . $item_detail['desc'] . $item_detail['option_desc'], 1, 'L' );
             $y2 = $pdf -> GetY();
             $pdf -> SetXY( $x, $y );
             $pdf -> Cell( 0, $y2 - $y, number_format( $item_detail['amount'], 2 ), 1, 0, 'C' );
             // $total += $item_detail['amount'];
        } 
        $pdf -> Ln();
         $pdf -> Cell( 120, 7, 'Quantity', 1, 0, 'R' );
         $pdf -> Cell( 0, 7, $item_detail['quantity'], 1, 0, 'C' );
         if ( self :: $options['settings']['discount'] > 1 ) self :: $options['settings']['discount'] / 100;
         if ( !empty( self :: $options['settings']['discount'] ) && self :: $options['settings']['discount'] < 1 ) {
            $pdf -> Ln();
             $pdf -> Cell( 120, 7, 'Discount (' . ( self :: $options['settings']['discount'] * 100 ) . '%)', 1, 0, 'R' );
             $pdf -> Cell( 0, 7, '-' . number_format( ( $total - ( $total * self :: $options['settings']['discount'] ) ), 2 ), 1, 0, 'C' );
             $total *= self :: $options['settings']['discount'];
             } 
        if ( !empty( self :: $options['settings']['VAT'] ) && self :: $options['settings']['VAT'] < 1 ) {
            $pdf -> Ln();
             $pdf -> Cell( 120, 7, 'VAT (' . ( self :: $options['settings']['VAT'] * 100 ) . '%)', 1, 0, 'R' );
             $pdf -> Cell( 0, 7, number_format( $total * self :: $options['settings']['VAT'], 2 ), 1, 0, 'C' );
             $total += ( $total * self :: $options['settings']['VAT'] );
             } 
        $pdf -> Ln();
         $pdf -> Cell( 120, 7, 'Total Amount', 1, 0, 'R' );
         $pdf -> Cell( 0, 7, number_format( $item_detail['amount'] * $item_detail['quantity'], 2 ), 1, 0, 'C' );
         if ( self :: $options['savefile']['save'] ) $pdf -> Output( self :: $options['savefile']['directory'] . '/' . self :: $options['savefile']['filename'], "F" );
         return $pdf -> Output( '', 'S' );
         } 
    static private function _generate_html( $options )
    
    
    {
         $template = file_get_contents( DIR_BACKEND . '/invoice/tpl/' . self :: $options['template'] . '.php' );
         $table = '<table width="100%"><thead><tr><th width="70%">Item(s)</th><th>Amount (' . self :: $options['invoice']['currency'] . ')</th></tr></thead><tbody>';
         $total = 0;
         foreach( self :: $options['items'] as $item_name => $item_detail ) {
            $table .= '<tr><td><b>' . $item_name . '</b><br />' . nl2br( $item_detail['desc'] ) . '</td><td class="table_amount">' . number_format( $item_detail['amount'], 2 ) . '</td></tr>';
             $total += $item_detail['amount'];
             } 
        $table .= '<tr><td align="right">Sub Total</td><td class="table_amount">' . $total . '</td></tr>';
         if ( !empty( self :: $options['settings']['discount'] ) && self :: $options['settings']['discount'] < 1 ) {
            $table .= '<tr><td align="right">Discount (' . ( self :: $options['settings']['discount'] * 100 ) . '%)</td><td class="table_amount">-' . number_format( ( $total - ( $total * self :: $options['settings']['discount'] ) ), 2 ) . '</td></tr>';
             $total *= self :: $options['settings']['discount'];
             } 
        if ( !empty( self :: $options['settings']['VAT'] ) && self :: $options['settings']['VAT'] < 1 ) {
            $table .= '<tr><td align="right">VAT (' . ( self :: $options['settings']['VAT'] * 100 ) . '%)</td><td class="table_amount">' . number_format( $total * self :: $options['settings']['VAT'], 2 ) . '</td></tr>';
             $total += ( $total * self :: $options['settings']['VAT'] );
             } 
        $table .= '<tr><td align="right">Total Amount</td><td class="table_amount">' . number_format( $total, 2 ) . '</td></tr></tbody></table>';
         $template = str_replace( array( '{company_name}', '{company_logo}', '{company_address}', '{company_email}',
                 '{client_name}', '{client_address}', '{client_email}',
                 '{invoice_name}', '{invoice_date}', '{invoice_due_date}',
                 '{items_table}' ),
             array( self :: $options['company']['name'], self :: $options['company']['logo'], nl2br( self :: $options['company']['address'] ), self :: $options['company']['email'],
                 self :: $options['client']['name'], nl2br( self :: $options['client']['address'] ), self :: $options['client']['email'],
                 self :: $options['invoice']['name'], self :: $options['invoice']['date'], self :: $options['invoice']['due_date'],
                 $table ), $template );
         return utf8_encode( $template );
         } 
    } 
function Invoice_encode_utf8( &$s )


{
     if ( function_exists( 'iconv' ) && is_callable( 'iconv' ) ) {
        foreach( $s as $key => $value ) {
            if ( is_array( $s[$key] ) ) {
                Invoice_encode_utf8( $s[$key] );
                 } else {
                $s[$key] = iconv( 'UTF-8', 'ISO-8859-1', $value );
                 } 
            } 
        } elseif ( function_exists( 'mb_convert_encoding' ) && is_callable( 'mb_convert_encoding' ) ) {
        foreach( $s as $key => $value ) {
            if ( is_array( $s[$key] ) ) {
                Invoice_encode_utf8( $s[$key] );
                 } else {
                $s[$key] = mb_convert_encoding( $value, 'ISO-8859-1', 'UTF-8' );
                 } 
            } 
        } else {
        return $s;
         } 
    return $s;
     } 
function Invoice_encode_utf8_string( $s )


{
     if ( function_exists( 'iconv' ) && is_callable( 'iconv' ) ) {
        return iconv( 'UTF-8', 'ISO-8859-1', $s );
         } elseif ( function_exists( 'mb_convert_encoding' ) && is_callable( 'mb_convert_encoding' ) ) {
        return mb_convert_encoding( $s, 'ISO-8859-1', 'UTF-8' );
         } else {
        return $s;
         } 
    } 
?>