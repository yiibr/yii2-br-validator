<?php

/**
 * @link https://github.com/leandrogehlen/yii2-br-validator
 * @license https://github.com/leandrogehlen/yii2-br-validator/blob/master/LICENSE
 */
namespace leandrogehlen\brvalidator;

use yii\validators\Validator;
use Yii;

/**
 * CnpjValidator checks if the attribute value is a valid CNPJ. 
 *
 * @author Leandro Gehlen <leandrogehlen@gmail.com>
 * @since 2.0
 */

class CnpjValidator extends Validator {
			
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		if ($this->message === null) {
			$this->message = Yii::t('yii', "{attribute} is invalid.");
		}
	}
		
	/**
	 * @inheritdoc
	 */
	protected function validateValue($value) {
		$valid = true;
        	$cnpj = str_pad(preg_replace('/[^0-9_]/', '', $value), 14, '0', STR_PAD_LEFT);
        
        	for ($x=0; $x<10; $x++) {
            		if ( $cnpj == str_repeat($x, 14) ) {
            			$valid = false;
            		}
        	}
                        
        	if ( $valid) {
        		if (strlen($cnpj) != 14) {
        			$valid = false;
        		} else  {
				for($t = 12; $t < 14; $t ++) {
					$d = 0;
					$c = 0;
					
					for($m = $t - 7; $m >= 2; $m --, $c ++) {
						$d += $cnpj {$c} * $m;
					}
					
					for($m = 9; $m >= 2; $m --, $c ++) {
						$d += $cnpj {$c} * $m;
					}
					
					$d = ((10 * $d) % 11) % 10;
					
					if ($cnpj {$c} != $d) {
						$valid = false;
						break;
					}
				}
        		}            
        	}
		
		return ($valid) ? [] : [$this->message, []];		
	}
}

?>
