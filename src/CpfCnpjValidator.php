<?php
/**
 * @link https://github.com/yiibr/yii2-br-validator
 * @license https://github.com/yiibr/yii2-br-validator/blob/master/LICENSE
 */
namespace yiibr\brvalidator;

use yii\helpers\Json;
use Yii;

/**
 * CpfCnpjValidator checks if the attribute value is a valid CPF or CNPJ.
 *
 * @author Leandro Gehlen <leandrogehlen@gmail.com>
 */
class CpfCnpjValidator extends DocumentValidator
{

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
    protected function validateValue($value)
    {
        $valid = true;
        $cpfCnpj = preg_replace('/[^0-9]/', '', $value);

        for ($x=0; $x<10; $x++) {
            if ( $cpfCnpj == str_repeat($x, 11) || $cpfCnpj == str_repeat($x, 14) ) {
                $valid = false;
            }
        }
        if ($valid) {
            if (strlen($cpfCnpj) === 14) {
                for ($t = 12; $t < 14; $t ++) {
                    $d = 0;
                    $c = 0;
                    for ($m = $t - 7; $m >= 2; $m --, $c ++) {
                        $d += $cpfCnpj [$c] * $m;
                    }
                    for ($m = 9; $m >= 2; $m --, $c ++) {
                        $d += $cpfCnpj [$c] * $m;
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpfCnpj [$c] != $d) {
                        $valid = false;
                        break;
                    }
                }
            } else if (strlen($cpfCnpj) === 11) {
                for ($t = 9; $t < 11; $t ++) {
                    $d = 0;
                    for($c = 0; $c < $t; $c ++) {
                        $d += $cpfCnpj [$c] * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpfCnpj[$c] != $d) {
                        $valid = false;
                        break;
                    }
                }
            } else  {
                $valid = false;
            }
        }
        return ($valid) ? [] : [$this->message, []];
    }

    public function clientValidateAttribute($object, $attribute, $view)
    {
        $options = [
            'message' => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $object->getAttributeLabel($attribute),
            ], Yii::$app->language)
        ];

        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);
        return 'yiibr.validation.cpfCnpj(value, messages, ' . Json::encode($options) . ');';
    }
}
