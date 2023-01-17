<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\NumberSanitizer;

class NumberSanitizerTest extends TestCase
{
    protected NumberSanitizer $numberSanitizer;

    public function setUp(): void
    {
        parent::setUp();
        $this->numberSanitizer = new NumberSanitizer;
    }

    public function test_check_valid_number()
    {
        $this->assertTrue($this->numberSanitizer->validate('27831234567'));
    }

    public function test_check_invalid_number()
    {
        $this->assertFalse($this->numberSanitizer->validate('1234'));
    }

    public function test_check_valid_modified_number()
    {
        $this->assertTrue($this->numberSanitizer->validateOrCorrect('1234567')['modified']);
    }

    public function test_check_modified_valid_number_with_deleted_part()
    {
        $this->assertTrue($this->numberSanitizer->validateOrCorrect('1234567_DELETED_12345')['modified']);
    }

    public function test_check_modified_invalid_number_with_deleted_part()
    {
        $this->assertFalse($this->numberSanitizer->validateOrCorrect('123_DELETED_12345')['valid']);
    }
}
