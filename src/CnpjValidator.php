<?php
/**
 * @link https://github.com/yiibr/yii2-br-validator
 * @license https://github.com/yiibr/yii2-br-validator/blob/master/LICENSE
 */
namespace yiibr\brvalidator;

use Yii;
use yii\helpers\Json;

/**
 * CnpjValidator checks if the attribute value is a valid CNPJ.
 *
 * @author Leandro Gehlen <leandrogehlen@gmail.com>
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 * @author Matheus Evangelista Morais <thtmorais@hotmail.com>
 */
class CnpjValidator extends DocumentValidator
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
        
        $cnpj = strtoupper(preg_replace('/[-\/.\s]/', '', $value));

        if (strlen($cnpj) != 14) {
            $valid = false;
        } elseif (str_repeat($cnpj[0], 14) === $cnpj) {
            $valid = false;
        } else {
            $sum = 0;
            $pos = 5;
            for ($i = 0; $i < 12; $i++) {
                $val = ord($cnpj[$i]) - 48;
                $sum += $val * $pos;
                $pos--;
                if ($pos < 2) {
                    $pos = 9;
                }
            }
            $result = ($sum % 11) < 2 ? 0 : 11 - ($sum % 11);
            if ($cnpj[12] != $result) {
                $valid = false;
            }

            if ($valid) {
                $sum = 0;
                $pos = 6;
                for ($i = 0; $i < 13; $i++) {
                    $val = ord($cnpj[$i]) - 48;
                    $sum += $val * $pos;
                    $pos--;
                    if ($pos < 2) {
                        $pos = 9;
                    }
                }
                $result = ($sum % 11) < 2 ? 0 : 11 - ($sum % 11);
                if ($cnpj[13] != $result) {
                    $valid = false;
                }
            }
        }

        return ($valid) ? [] : [$this->message, []];
    }

    /**
     * @inheritdoc
     */
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
        return 'yiibr.validation.cnpj(value, messages, ' . Json::encode($options) . ');';
    }
}
