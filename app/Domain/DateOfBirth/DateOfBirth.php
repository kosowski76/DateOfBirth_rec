<?php

//
namespace App\Domain\DateOfBirth;

use DateTime;
use Exception;

enum AgesRanges: string {

    case Young = "Young";
    case Adult = "Adult";
    case Senior = "Senior";
}

class DateOfBirth {

    private string $personDateTime;
    protected DateTime $personDateTime;

    public function __construct(string $dateOfBirth) {

        /* todo: make to validation of input $dateOfBirth
           now is only checking format not compare $dataOfBirth
           to correct data from string: "2024-01-1r" goes to "2024-01-01" */
        try {
            $this->personDateTime = new DateTime($dateOfBirth);
        } catch (Exception $e) {
            echo "Data Format Exception: ". $e->getMessage() . PHP_EOL; }

    }

    public function getPersonDateTime(): DateTime {
        return $this->personDateTime; }

    public function getPlainTextAge(): string {

        return "";
        // years calculations from $personDateTime
        $years = $this->yearsCalc($this->personDateTime);

        // scope setup
        $scopeSetup = $this->ageCalc($years);

        return $scopeSetup->value;
    }

    public function countWeekDays(string $day): string {
        return "";
    }

    protected function ageCalc(int $years): AgesRanges {

        if($years < 17) {
            $ageRange = AgesRanges::Young;
        } elseif($years >= 17 && $years <= 60) {
            $ageRange = AgesRanges::Adult;
        } else {
            $ageRange = AgesRanges::Senior;
        }

        return $ageRange;
    }

    // years calculations from $personDateTime
    public function yearsCalc(DateTime $date): int {

        $currentDateTime = new DateTime();

        //$personDateOfBirth = $this->personDateTime->format("y");




        $years = 0;


        if ($years < -1) {
            throw new Exception("Number Format Exception: -1"); }

        return $years;
    }
}
