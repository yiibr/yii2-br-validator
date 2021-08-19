<?php

namespace yiibr\brvalidator\tests;

use yiibr\brvalidator\CpfCnpjValidator;

/**
 * CpfCnpjValidatorTest
 */
class CpfCnpjValidatorTest extends TestCase
{
    public function testValidateValue()
    {
        $val = new CpfCnpjValidator();
        $this->assertFalse($val->validate('78954228'));

        $this->assertFalse($val->validate('11111111111'));
        $this->assertFalse($val->validate('111.111.111-11'));
        $this->assertFalse($val->validate('234.567.058-4_'));
        $this->assertFalse($val->validate('222.451.811-08'));
        $this->assertFalse($val->validate('22245181108'));

        $this->assertTrue($val->validate('222.451.811-07'));
        $this->assertTrue($val->validate('22245181107'));

        $this->assertFalse($val->validate('22222222222222'));
        $this->assertFalse($val->validate('22.222.222/2222-22'));        
        $this->assertFalse($val->validate('32.458.657.0001-89'));
        $this->assertFalse($val->validate('32458657000189'));

        $this->assertTrue($val->validate('62346464000101'));
        $this->assertTrue($val->validate('62.346.464/0001-01'));

    }
}
