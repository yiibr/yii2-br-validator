<?php

namespace yiibr\brvalidator\tests;

use yiibr\brvalidator\CnpjValidator;

/**
 * CpfValidatorTest
 */
class CnpjValidatorTest extends TestCase
{
    public function testValidateValue()
    {
        $val = new CnpjValidator();
        $this->assertFalse($val->validate('789542284'));
        $this->assertFalse($val->validate('78O542S84A'));

        $this->assertFalse($val->validate('22222222222222'));
        $this->assertFalse($val->validate('22.222.222/2222-22'));

        $this->assertFalse($val->validate('32.458.657.0001-89'));
        $this->assertFalse($val->validate('32458657000189'));

        $this->assertTrue($val->validate('62.346.464/0001-01'));
        $this->assertTrue($val->validate('62346464000101'));

        $this->assertTrue($val->validate('GB.438.VHX/0001-03'));
        $this->assertTrue($val->validate('GB438VHX000103'));

        $this->assertTrue($val->validate('4V.O93.GK9/0001-92'));
        $this->assertTrue($val->validate('4VO93GK9000192'));

        $this->assertFalse($val->validate('4J.O93.GK9/0001-92'));
        $this->assertFalse($val->validate('4JO93GK9000192'));
    }
}
