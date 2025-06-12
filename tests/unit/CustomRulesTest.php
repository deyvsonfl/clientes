<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class CustomRulesTest extends CIUnitTestCase
{
    public function testValidCep(): void
    {
        $validation = service('validation');

        $this->assertTrue($validation->check('12345-678', 'valid_cep'));
        $this->assertTrue($validation->check('12345678', 'valid_cep'));
        $this->assertTrue($validation->check('00000-000', 'valid_cep'));

        $this->assertFalse($validation->check('1234-5678', 'valid_cep'));
        $this->assertFalse($validation->check('12345-6789', 'valid_cep'));
        $this->assertFalse($validation->check('1234567', 'valid_cep'));
        $this->assertFalse($validation->check('abcde-fgh', 'valid_cep'));
    }

    public function testValidPhone(): void
    {
        $validation = service('validation');

        $this->assertTrue($validation->check('(11) 99999-9999', 'valid_phone'));
        $this->assertTrue($validation->check('(21) 1234-5678', 'valid_phone'));
        $this->assertTrue($validation->check('11999999999', 'valid_phone'));

        $this->assertFalse($validation->check('123456789', 'valid_phone'));
        $this->assertFalse($validation->check('(11) 99999-99999', 'valid_phone'));
        $this->assertFalse($validation->check('abc', 'valid_phone'));
    }
}
