<?php

namespace yiibr\brvalidator\tests;

use yii\base\Model;
use yiibr\brvalidator\CeiValidator;
use yiibr\brvalidator\CnpjValidator;
use yiibr\brvalidator\DocumentValidator;

/**
 * DocumentValidatorTest
 */
class DocumentValidatorTest extends TestCase
{
    public function testValidateValue()
    {
        $person = new Person([
            'docnumber' => '1!@#$%¨&*()_-+2"`´[]?\/;, 3'
        ]);

        $person->validate();
        $this->assertEquals('123', $person->docnumber);
    }
}


class Person extends Model {

    public $docnumber;

    public function rules()
    {
        return [
            [['docnumber'], CnpjValidator::class, 'digitsOnly' => true]
        ];
    }
}
