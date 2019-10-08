<?php
namespace App\Services;

class DatComparator
{


    public function  convert($datx)
    {
        if($datx == null): 
            $datx = new \DateTime();
        endif;
       return (date($datx->format('Ymd')));   
    }

    public function  dayOfWeek($dat0)
    {
        $time = $this->convert($dat0);
        return date('S' , $time ) ;
    }

    public function  isEqual($dat = null, $datref= null)
    {
        $dat0 = $this->convert($dat);
        $datr = $this->convert($datref);

        if($dat0 = $datr):
            return true;
        else:
            return false;
        endif;
    }


   public function  isHigherOrEqual($dat, $datref)
    {
        $dat0 = $this->convert($dat);
        $datr = $this->convert($datref);

        if($dat0 >= $datr):
            return true;
        else:
            return false;
        endif;
    }


    public function  isLowerOrEqual($dat= null, $datref= null)
    {
        $dat0 = $this->convert($dat);
        $datr = $this->convert($datref);

        if($dat0 <= $datr):
            return true;
        else:
            return false;
        endif;
    }

        
}