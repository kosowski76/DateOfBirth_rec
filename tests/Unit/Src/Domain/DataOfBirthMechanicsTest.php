<?php
//
namespace Tests\Unit\Src\Domain;

use App\Domain\DateOfBirth\AgesRanges;
use App\Domain\DateOfBirth\DateOfBirth;
use DateTime;
use Exception;
use Tests\TestCase;

/* The TesterDateOfBirth class allows access to protected methods and properties
    without integration into the tested DateOfBirth class */
class TesterDateOfBirth extends DateOfBirth {

    public function getPersonDateTime(): DateTime {
        return $this->personDateTime; }
    public function setCurrentDateTime(string $dateTime): void {
        $this->currentDateTime->modify($dateTime); }
    public function getCurrentDateTime(): DateTime {
        return $this->currentDateTime; }

    public function yearsCalc(DateTime $personDateTime, DateTime $currentDateTime): int {
        return parent::yearsCalc($personDateTime, $currentDateTime); }

    public function daysCalc(DateTime $dateTimeBegin, DateTime $dateTimeEnd): int {
        return parent::daysCalc($dateTimeBegin, $dateTimeEnd); }

}

class DataOfBirthMechanicsTest extends TestCase {

    public DateOfBirth $personDOB;

    public function test_getPlainTextAgeShouldReturn_String(): void {

        $this->personDOB = new TesterDateOfBirth("2000-01-17");
        $this->personDOB->setCurrentDateTime("2011-01-15");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $isString = $this->personDOB->getPlainTextAge($currentDateTime);

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertIsString($isString);
    }

    public function testGivenWrongFormatDateOfBirth_yearsCalcShouldReturn_Exception(): void {

        $this->expectException(Exception::class);

        $this->personDOB = new TesterDateOfBirth("2020-01-c17");
        $currentDateTime = new DateTime("2024-01-15");
        $this->personDOB->yearsCalc(
            $this->personDOB->getPersonDateTime(),
            $currentDateTime);

        unset($this->personDOB);
        unset($currentDateTime);
    }

    public function testGivenDateOfBirthFromFuture_yearsCalcShouldReturn_Exception(): void {

        $this->expectException(Exception::class);

        $this->personDOB = new TesterDateOfBirth("2030-01-17");
        $currentDateTime = new DateTime("2024-01-15");
        $this->personDOB->yearsCalc(
            $this->personDOB->getPersonDateTime(),
            $currentDateTime);

        unset($this->personDOB);
        unset($currentDateTime);
    }

    public function testGiven20240101and20240115_yearsCalcShouldReturn_0integer(): void {

        $this->personDOB = new TesterDateOfBirth("2024-01-01");
        $currentDateTime = new DateTime("2024-01-15");
        $expect = 0;
        $actual = $this->personDOB->yearsCalc(
            $this->personDOB->getPersonDateTime(),
            $currentDateTime);

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $actual);
    }

    public function testGivenDateTime_yearsCalcShouldReturn_23integer(): void {

        $this->personDOB = new TesterDateOfBirth("2000-01-17");
        $currentDateTime = new DateTime("2024-01-15");
        $expect = 23;
        $actual = $this->personDOB->yearsCalc(
            $this->personDOB->getPersonDateTime(),
            $currentDateTime);

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $actual);
    }

    public function testGiven20080117and20240115_getPlainTextAgeShouldReturn_Young(): void {

        $this->personDOB = new TesterDateOfBirth("2008-01-17");
        $currentDateTime = new DateTime("2024-01-15");
        $age = $this->personDOB->getPlainTextAge($currentDateTime);
        $expect = "Young";

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $age, "Young");
    }

    public function testGiven19980117and20240115_getPlainTextAgeShouldReturn_Adult(): void {

        $this->personDOB = new TesterDateOfBirth("1998-01-17");
        $currentDateTime = new DateTime("2024-01-15");
        $age = $this->personDOB->getPlainTextAge($currentDateTime);
        $expect = "Adult";

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $age, "Adult");
    }

    public function testGiven19980117and20170115_getPlainTextAgeShouldReturn_Senior(): void {

        $this->personDOB = new TesterDateOfBirth("1962-01-17");
        $currentDateTime = new DateTime("2024-01-15");
        $age = $this->personDOB->getPlainTextAge($currentDateTime);
        $expect = "Senior";

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $age, "Senior");
    }

    public function testGiven20240101and20170115_getPlainTextAgeShouldReturn_Young(): void {

        $this->personDOB = new TesterDateOfBirth("2024-01-01");
        $currentDateTime = new DateTime("2024-01-15");
        $age = $this->personDOB->getPlainTextAge($currentDateTime);
        $expect = "Young";

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $age, "Young");
    }

    public function testGiven20240101and20240114_daysCalcShouldReturn_2integer(): void {

        $this->personDOB = new TesterDateOfBirth("2024-01-01");
        $currentDateTime = new DateTime("2024-01-14");
        $expect = 13;
        $actual = $this->personDOB->daysCalc(
            $this->personDOB->getPersonDateTime(),
            $currentDateTime);

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $actual);
    }

    public function testGivenDateOfBirthFromFuture_daysCalcShouldReturn_Exception(): void {

        $this->expectException(Exception::class);

        $this->personDOB = new TesterDateOfBirth("2024-01-21");
        $currentDateTime = new DateTime("2024-01-15");
        $actual = $this->personDOB->daysCalc(
            $this->personDOB->getPersonDateTime(),
            $currentDateTime);

        unset($this->personDOB);
        unset($currentDateTime);
    }

    public function testGivenMonday20240101and20240115_countWeekDaysInPeriod_2integer(): void {

        $this->personDOB = new TesterDateOfBirth("2024-01-01");
        $this->personDOB->setCurrentDateTime("2024-01-15");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $count = $this->personDOB->countWeekDaysInPeriod("Monday");
        $expect = 2;

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $count);
    }

    public function testGivenMonday20231211and20240115_countWeekDaysInPeriod_5integer(): void {

        $this->personDOB = new TesterDateOfBirth("2023-12-11");
        $this->personDOB->setCurrentDateTime("2024-01-15");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $count = $this->personDOB->countWeekDaysInPeriod("Monday");
        $expect = 5;

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $count);
    }

    public function testGivenMonday20231229and20240114_countWeekDaysInPeriod_2integer(): void {

        //     $this->personDOB = new TesterDateOfBirth("2023-12-13");
        $this->personDOB = new TesterDateOfBirth("2023-12-29");
        $this->personDOB->setCurrentDateTime("2024-01-14");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $count = $this->personDOB->countWeekDaysInPeriod("Monday");
        $expect = 2;

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $count);
    }

    public function testGivenTuesday20231229and20240116_countWeekDaysInPeriod_3integer(): void {

        $this->personDOB = new TesterDateOfBirth("2023-12-29");
        $this->personDOB->setCurrentDateTime("2024-01-16");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $count = $this->personDOB->countWeekDaysInPeriod("Tuesday");
        $expect = 3;

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $count);
    }

    public function testGivenWednesday20231229and20240116_countWeekDaysInPeriod_2integer(): void {

        $this->personDOB = new TesterDateOfBirth("2023-12-29");
        $this->personDOB->setCurrentDateTime("2024-01-16");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $count = $this->personDOB->countWeekDaysInPeriod("Wednesday");
        $expect = 2;

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $count);
    }

    public function testGivenThursday20231229and20240116_countWeekDaysInPeriod_2integer(): void {

        $this->personDOB = new TesterDateOfBirth("2023-12-29");
        $this->personDOB->setCurrentDateTime("2024-01-16");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $count = $this->personDOB->countWeekDaysInPeriod("Thursday");
        $expect = 2;

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $count);
    }

    public function testGivenFriday20231229and20240116_countWeekDaysInPeriod_2integer(): void {

        $this->personDOB = new TesterDateOfBirth("2023-12-29");
        $this->personDOB->setCurrentDateTime("2024-01-16");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $count = $this->personDOB->countWeekDaysInPeriod("Friday");
        $expect = 2;

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $count);
    }

    public function testGivenSaturday20231229and20240116_countWeekDaysInPeriod_2integer(): void {

        $this->personDOB = new TesterDateOfBirth("2023-12-29");
        $this->personDOB->setCurrentDateTime("2024-01-16");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $count = $this->personDOB->countWeekDaysInPeriod("Saturday");
        $expect = 2;

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $count);
    }

    public function testGivenSunday20231229and20240116_countWeekDaysInPeriod_2integer(): void {

        $this->personDOB = new TesterDateOfBirth("2023-12-29");
        $this->personDOB->setCurrentDateTime("2024-01-16");
        $currentDateTime = $this->personDOB->getCurrentDateTime();
        $count = $this->personDOB->countWeekDaysInPeriod("Sunday");
        $expect = 2;

        unset($this->personDOB);
        unset($currentDateTime);

        $this->assertEquals($expect, $count);
    }
}
