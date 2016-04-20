<?php

namespace View\Engine\Util;


/**
 * @license Apache
 * @author Nike Madrid
 * @copyright Nike Madrid
 */


class Block
{
    
	/**
	 * @static metodo
	 * @param string $b_c block content
	 * @return string|array|bool
	 */
	 
	public static function content($b_c)
	{
		if(preg_match_all('/((\\%\{[block?]*\s(.*)?\}))/iU', $b_c, $mblock)){
			
			$func = array_shift($mblock);
			$nameBlock = array_pop($mblock);
			
			$arr = 'array(';
			$keyArr = '__INICIALIZE_BLOCK__';
			$endKeyArr = '__END_BLOCK__';
			
			$quitIdenteHtml = Quote::space($b_c);	
			$convertArrBlock = str_replace('__QUOTE_OBJECT__', '->',$quitIdenteHtml);
			
			foreach($func as $index => $func_b){
				$startBlock = str_replace($func_b, '\'' . $keyArr . Quote::quotationMarks($nameBlock[$index]) . '\' => \'', $convertArrBlock);
				$convertArrBlock = str_replace('%{endblock}', ' \',', $startBlock);
			}
			$arr .= substr($convertArrBlock, 0, -1) . ');';
			 
			 unset($mBlock);
			 
			return @eval(" return {$arr}");
		}
		return $b_c;
	}
	
}