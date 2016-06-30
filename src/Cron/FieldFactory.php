<?php

/**
 * CRON field factory implementing a flyweight factory
 * @link http://en.wikipedia.org/wiki/Cron
 */
class Cron_FieldFactory
{
    /**
     * @var array Cache of instantiated fields
     */
    private $fields = array();

    /**
     * Get an instance of a field object for a cron expression position
     *
     * @param int $position CRON expression position value to retrieve
     *
     * @return Cron_FieldInterface
     * @throws InvalidArgumentException if a position is not valid
     */
    public function getField($position)
    {
        if (!isset($this->fields[$position])) {
            switch ($position) {
                case 0:
                    $this->fields[$position] = new Cron_MinutesField();
                    break;
                case 1:
                    $this->fields[$position] = new Cron_HoursField();
                    break;
                case 2:
                    $this->fields[$position] = new Cron_DayOfMonthField();
                    break;
                case 3:
                    $this->fields[$position] = new Cron_MonthField();
                    break;
                case 4:
                    $this->fields[$position] = new Cron_DayOfWeekField();
                    break;
                case 5:
                    $this->fields[$position] = new Cron_YearField();
                    break;
                default:
                    throw new InvalidArgumentException(
                        $position . ' is not a valid position'
                    );
            }
        }

        return $this->fields[$position];
    }
}
