<?php

/**
 * Month field.  Allows: * , / -
 */
class Cron_MonthField extends Cron_AbstractField
{
    public function isSatisfiedBy(DateTime $date, $value)
    {
        // Convert text month values to integers
        $value = str_ireplace(
            array(
                'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN',
                'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'
            ),
            range(1, 12),
            $value
        );

        return $this->isSatisfied($date->format('m'), $value);
    }

    public function increment(DateTime $date, $invert = false)
    {
        if ($invert) {
            $prevMonth = $date->format('n') - 1;
            $year = $date->format('Y');
            if ($prevMonth == 0) {
                $prevMonth = 12;
                $year--;
            }
            $monthDays = array(
                31,
                28 + ($year % 4 == 0 ? 1 : 0), // Support for leap years!
                31,
                30,
                31,
                30,
                31,
                31,
                30,
                31,
                30,
                31
            );
            $date->setDate($year, $prevMonth, $monthDays[$prevMonth - 1]);
            $date->setTime(23, 59);
        } else {
            $nextMonth = ($date->format('n') + 1) % 13;
            $year = $date->format('Y');
            if ($nextMonth == 0) {
                $nextMonth = 1;
                $year++;
            }
            $date->setDate($year, $nextMonth, 1);
            $date->setTime(0, 0);
        }

        return $this;
    }

    public function validate($value)
    {
        return (bool) preg_match('/^[\*,\/\-0-9A-Z]+$/', $value);
    }
}
