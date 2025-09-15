<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
  * Dev par Bonfils de Jésus
  Bujambura 15-03-2023
  */
 class Library_convertmount
 {
 	
 	protected $CI;

	public function __construct()
	{
	  $this->CI = & get_instance();
     
	}

	function convertNumberold($num = false)
	{
	    $num = str_replace(array(',', ''), '' , trim($num));
	    if(! $num) {
	        return false;
	    }
	    $num = (int) $num;
	    $words = array();
	    
	    // $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
	    //     'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
	    // );
	    // $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
	    // $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
	    //     'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
	    //     'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
	    // );

	    $list1 = array('', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze',
	    	'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'
	    );
	    $list2 = array('', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix', 'cent');
	    $list3 = array('', 'mille', 'million', 'milliard', 'billion', 'billiard', 'trillion', 'trilliard', 'quadrillion', 'quadrilliard',
	    	'quintillion', 'quintilliard', 'sextillion', 'sextilliard', 'septillion', 'septilliard',
	    	'octillion', 'octilliard', 'nonillion', 'nonilliard', 'décillion', 'décilliard', 'undécillion', 'undécilliard'
	    );

	    $num_length = strlen($num);
	    $levels = (int) (($num_length + 2) / 3);
	    $max_length = $levels * 3;
	    $num = substr('00' . $num, -$max_length);
	    $num_levels = str_split($num, 3);
	    for ($i = 0; $i < count($num_levels); $i++) {
	        $levels--;
	        $hundreds = (int) ($num_levels[$i] / 100);
	        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
	        $tens = (int) ($num_levels[$i] % 100);
	        $singles = '';
	        if ( $tens < 20 ) {
	            $tens = ($tens ? ' and ' . $list1[$tens] . ' ' : '' );
	        } elseif ($tens >= 20) {
	            $tens = (int)($tens / 10);
	            $tens = ' and ' . $list2[$tens] . ' ';
	            $singles = (int) ($num_levels[$i] % 10);
	            $singles = ' ' . $list1[$singles] . ' ';
	        }
	        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
	    } //end for loop
	    $commas = count($words);
	    if ($commas > 1) {
	        $commas = $commas - 1;
	    }
	    $words = implode(' ',  $words);
	    $words = preg_replace('/^\s\b(and)/', '', $words );
	    $words = trim($words);
	    $words = ucfirst($words);
	    $words = $words . ".";
	    return $words;
	}

	function convertNumber($num = false)
	{
		$num = str_replace(array(',', ''), '', trim($num));
		if(!$num) {
			return false;
		}
		$num = (int) $num;
		$words = array();
		$list1 = array('', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze',
			'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'
		);
		$list2 = array('', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix');
		$list3 = array('', 'mille', 'million', 'milliard', 'billion', 'billiard', 'trillion', 'trilliard', 'quadrillion', 'quadrilliard',
			'quintillion', 'quintilliard', 'sextillion', 'sextilliard', 'septillion', 'septilliard',
			'octillion', 'octilliard', 'nonillion', 'nonilliard', 'décillion', 'décilliard', 'undécillion', 'undécilliard'
		);

		$num_length = strlen($num);
		$levels = (int) (($num_length + 2) / 3);
		$max_length = $levels * 3;
		$num = substr('00' . $num, -$max_length);
		$num_levels = str_split($num, 3);
		for ($i = 0; $i < count($num_levels); $i++) {
			$levels--;
			$hundreds = (int) ($num_levels[$i] / 100);
			$tens = (int) ($num_levels[$i] % 100);
			$singles = '';
			if ($hundreds > 0) {
				$words[] = ($hundreds == 1 ? 'cent' : $list1[$hundreds] . ' cent');
			}
			if ($tens < 20) {
				$words[] = ($tens ? $list1[$tens] : '');
			} elseif ($tens >= 20) {
				$words[] = $list2[($tens / 10)];
				$singles = ($tens && ($num_levels[$i] % 10) ? '-' . $list1[($num_levels[$i] % 10)] : '');
				$words[] = $singles;
			}
			if ($levels && (int)($num_levels[$i])) {
				$words[] = $list3[$levels];
			}
		}
		$words = implode(' ', $words);
		$words = preg_replace('/^\s\b(and)/', '', $words);
		$words = trim($words);
		$words = ucfirst($words);
		$words = $words . ".";
		return $words;
	}


}
