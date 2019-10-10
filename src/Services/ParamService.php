<?php

namespace App\Services;

use App\Interfaces\ParamRepositoryInterface;
use App\Entity\Param;
use DateTime;

class ParamService
{
    private $paramRepository;
    private $partTimeCodes = [0,1,2];
    private $maxVisitors = [];
    private $imperativeEndOfBooking ;
    private $endOfBooking ;
    private $startOfBooking ;
    private $maxBookingVisitors;
    
    private const KBON = "BookingOrderNumber";

    public function __construct(ParamRepositoryInterface $paramRepository)
    {
       $this->paramRepository = $paramRepository;
       $this->params = $this->paramRepository
       ->findAll();
       
        foreach($this->params as $param)
        {
            if($param->getRefCode() == "MaxVisitors")
            {
                $this->maxVisitors[] = $param;
            }else{
                if($param->getRefCode() == "MaxBookingOrderDly")
                {
                    $nbMonths = $param->getNumber();
                    $this->endOfBooking = new \DateTime('+'. $nbMonths . 'month');

                    if($param->getDayNum() !== ''):
                        $this->endOfBooking  = new \DateTime($this->endOfBooking ->format('Y-m-t'));
                    endif;
                } else{
                    if($param->getRefCode() == "ImperativeBookingEnd")
                    {
                        $date = $param->getExeNum() . "-" .  $param->getMonthNum() . "-" .  $param->getDayNum() ;
                        $this->imperativeEndOfBooking = new \Datetime($date);
                       
                    } else{
                        if($param->getRefCode() == "PartTimeCodes")
                        {
                            $this->partTimeCodes =  $param->getList();
                        } else{
                            if($param->getRefCode() == "MaxBookingVisitors")
                            {
                                $this->maxBookingVisitors =  $param->getNumber();
                            }
                        }
                    }
                }
            }
        
        }

     //  dd($this->params);

    }
   
    /**
     * Undocumented function
     *
     * @return string
     */
    public function allocateBookingNumber():string
    {
        return $this->paramRepository->saveNumber(KBON);
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function findPartTimeCodes():string
    {
        return $this->partTimeCodes;
    }

    /**
     * Undocumented function
     *
     * @return datetime
     */
    public function findEndOfBooking():datetime
    {
        if($this->endOfBooking <= $this->imperativeEndOfBooking):
            return  $this->endOfBooking;
        else:
            return $this->imperativeEndOfBooking;
        endif;
    }

    /**
     * Undocumented function
     *
     * @return datetime
     */
    public function findStartOfBooking():datetime
    {
        $this->startOfBooking = new \datetime();
        return  $this->startOfBooking;
    }

    /**
     * Undocumented function
     *
     * @return DateTime
     */
    public function findImperativeEndOfBooking():DateTime
    {
        return $this->imperativeEndOfBooking;
    }
    /**
     * Find "MaxVisitors" per day explicited by Year, ou yearMonth, or day
     *
     * @return 
     */
    public function findMaxVisitors():array
    {
        return $this->maxVisitors;
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    public function findMaxBookingVisitors():int
    {
        return $this->maxBookingVisitors;
    }
    
    
}