<?php

/**
 * @link https://github.com/leandrogehlen/yii2-br-validator
 * @license https://github.com/leandrogehlen/yii2-br-validator/blob/master/LICENSE
 */
namespace leandrogehlen\brvalidator;


use yii\validators\Validator;
use Yii;

/**
 * CpfValidator checks if the attribute value is a valid CPF. 
 *
 * @author Leandro Gehlen <leandrogehlen@gmail.com>
 * @since 2.0
 */

class CpfValidator extends Validator {
	
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
		$cpf = str_pad(preg_replace('/[^0-9_]/', '', $value ), 11, '0', STR_PAD_LEFT);
		
		
		for($x = 0; $x < 10; $x ++) {
			if ($cpf == str_repeat ( $x, 11 )) {
				$valid = false;
			}
		}
					
		if ($valid) {
			if (strlen ( $cpf ) != 11) {
				$valid = false;
								
			} else {
				for($t = 9; $t < 11; $t ++) {
					$d = 0;
					
					for($c = 0; $c < $t; $c ++) {
						$d += $cpf {$c} * (($t + 1) - $c);
					}
					
					$d = ((10 * $d) % 11) % 10;
					
					if ($cpf{$c} != $d) {
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
