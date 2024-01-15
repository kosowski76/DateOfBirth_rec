<?php
//
namespace Tests\Unit\Src\Domain;

use App\Domain\DateOfBirth\DateOfBirth;
use DateTime;
//use Exception;
use Tests\TestCase;

class DataOfBirthMechanicsTest extends TestCase {

    public DateOfBirth $personDOB;


    public function test_getPlainTextAgeReturn_String(): void {

        $this->personDOB = new DateOfBirth("2024-01-17");
        $this->assertIsString($this->personDOB->getPlainTextAge());

        unset($this->personDOB);
    }

    public function test_givenDateTimeShouldReturn_Integer(): void {

        $this->personDOB = new DateOfBirth("2000-01-17");
        $expect = 23;
        $actual = $this->personDOB->yearsCalc($this->personDOB->getPersonDateTime());
        $this->assertEquals($expect, $actual);

        unset($this->personDOB);
    }

    public function testGiven17YearsAgoShouldReturn_Young(): void {

        // $this->dateTime = new DateTime(now());
        // $this->assertIsString($this->currentDateTime);

        $this->assertTrue(false);
    }

    public function testGiven17YearsAgoWithoutDayReturn_Young(): void {

        $this->dateTime = new DateTime(now());

        $this->assertTrue(false);
    }
    public function testGiven17YearsAgoWithoutSecondReturn_Young(): void {

        $this->dateTime = new DateTime(now());

        $this->assertTrue(false);
    }

    public function testGiven12152022shouldReturn_Young(): void {

        $this->dateTime = new DateTime(now());

        $this->assertTrue(false);
    }
    public function testGiven17YearsAgoAndDayShouldReturn_Adult(): void {

        $this->dateTime = new DateTime(now());

        $this->assertTrue(false);
    }
    public function testGiven17YearsAgoAndSecondShouldReturn_Adult(): void {

        $this->dateTime = new DateTime(now());

        $this->assertTrue(false);
    }
    public function testGiven12152005shouldReturn_Adult(): void {

        $this->assertTrue(false);
    }
    public function testGiven12151962shouldReturn_Senior(): void {

        $this->assertTrue(false);
    }
    public function testGivenNowShouldReturn_Exeption(): void {

        $this->assertTrue(false);
    }
    public function testGivenDateFromFutureShouldReturn_Exeption(): void {

        $this->assertTrue(false);
    }


}
