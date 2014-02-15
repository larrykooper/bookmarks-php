<?php
require_once('linkcheckresult.php');
class LinkChecker
{
    public static function check_link($url) {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1); // get no body, only get header 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output=curl_exec($ch);
        $the_error=curl_error($ch);        
        
        $httpcode=curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        // Find Location if there is one 
        $pattern = '/[Ll]ocation: ([^\s]+)/';
        preg_match($pattern, $output, $matches);

        // echo '<div class="debug">';
        // echo 'MATCHES: <br>';
        // print_r($matches);
        // echo '<br>';
        // echo 'BEGINNING OF THE OUTPUT<br>';
        // echo $output;
        // echo '<br>';
        // echo 'END OF THE OUTPUT<br><br>';  
        // echo '</div>';
            
        // return an object 
        $myResult = new LinkCheckResult($the_error, $httpcode, $matches[1]);
        return $myResult;    
    }
}
?>
