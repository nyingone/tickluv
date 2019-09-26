<?php

namespace App\Interfaces;

class DateManager extends DateTime
{

    public function addMonth($num = 1)
    {
        $date = $this->format('Y-n-j');
        list($y, $m, $d) = explode('-', $date);

        $m += $num;
        while ($m > 12)
        {
            $m -= 12;
            $y++;
        }

        $last_day = date('t', strtotime("$y-$m-1"));
        if ($d > $last_day)
        {
            $d = $last_day;
        }

        $this->setDate($y, $m, $d);
    }

}
