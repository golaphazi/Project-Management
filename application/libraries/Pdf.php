<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf {
    
    function pdfn()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        require_once 'system/mpdf/mpdf.php';

        
         
        if ($params == NULL)
        {
            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';         
        }
         
        return new mPDF($param);
    }
}
//echo PDF_FILE_URL;exit;