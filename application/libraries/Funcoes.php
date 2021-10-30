<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Funcoes {

    public function primeirasMaiusculas($str) {
    	return ucwords(strtolower($str));
    }
    
    function mask($val, $mask) {
	   $maskared = '';
	   $k = 0;
	   for($i = 0; $i<=strlen($mask)-1; $i++) {
	       if($mask[$i] == '#') {
	           if(isset($val[$k])) {
	               $maskared .= $val[$k++];
	           }
	       } else {
	           if(isset($mask[$i])) {
	               $maskared .= $mask[$i];
	           }
	       }
	   }
	   return $maskared;
	}

}

?>