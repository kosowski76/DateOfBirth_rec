<?php
//
namespace App\Domain\DateOfBirth;

use DateTime;
use DateTimeZone;
use Exception;

enum AgesRanges: string {

    case Young = "Young";
    case Adult = "Adult";
    case Senior = "Senior";
}

class DateOfBirth {

    protected DateTime $personDateTime;
    protected DateTime $currentDateTime;

    public function __construct(string $dateOfBirth) {

        /* todo: make to validation of input $dateOfBirth
           now is only checking format not compare $dataOfBirth
           to correct data from string: "2024-01-1r" goes to "2024-01-01" */
        if(!($this->personDateTime = new DateTime($dateOfBirth, new DateTimeZone('Europe/Warsaw')))) {
            throw new Exception("Data Format Exception"); }

        $this->currentDateTime = new DateTime('now', new DateTimeZone('Europe/Warsaw'));
    }

    /* method getPlainTextAge() was changed and 'DateTime' can get by argument,
        that is better for the tests, or get current time form other method  */
    public function getPlainTextAge($currentDateTime): string {

        // years calculations from $personDateTime and $currentDateTime
        $years = $this->yearsCalc($this->personDateTime, $currentDateTime);

        if($years <= 17) {
            $ageRange = AgesRanges::Young;
        } elseif($years > 17 && $years <= 60) {
            $ageRange = AgesRanges::Adult;
        } else {
            $ageRange = AgesRanges::Senior;
        }

        return $ageRange->value;
    }

    public function countWeekDaysInPeriod(string $day): int {

        // todo: funcktion for 'dateTime' order verification

        $personDayNameOfBirth = $this->personDateTime->format("l");
        if($day === $personDayNameOfBirth) {

            $totalDays = $this->daysCalc($this->personDateTime, $this->currentDateTime);

            return ($totalDays / 7);

        } else {

            $weekDayDateTime = new DateTime($this->personDateTime->format("Y-m-d"));
            $nextWeekDay = "next ". $day;
            $nextDateTime = $weekDayDateTime->modify($nextWeekDay);

            $totalDays = $this->daysCalc($nextDateTime, $this->currentDateTime);

            $intWeekDayDateTime = intval($weekDayDateTime->format("N"));
            $intPersonDayDateTime = intval($this->personDateTime->format("N"));
            if($intWeekDayDateTime < $intPersonDayDateTime) {
                return ($totalDays / 7) + 1;
            } else {
                return ($totalDays / 7);
            }
        }
    }

    // years calculations from $personDateTime
    protected function yearsCalc(DateTime $personDateTime, DateTime $currentDateTime): int {

        if ($currentDateTime < $personDateTime) {

            throw new Exception(
                sprintf('"%s" is not a valid date of birth.',
                    $personDateTime->format("Y-m-d")), 100);
        }

        $difference = $personDateTime->diff($currentDateTime);

        return $difference->y;
    }

    protected function daysCalc(DateTime $dateTimeBegin, DateTime $dateTimeEnd): int {

        if ($dateTimeEnd < $dateTimeBegin) {

            throw new Exception(
                sprintf('"%s" is not a valid date for count days.',
                    $dateTimeBegin->format("Y-m-d")), 100);
        }

        $difference = $dateTimeBegin->diff($dateTimeEnd);
        $days = $difference->days;

        return $days;
    }
}
