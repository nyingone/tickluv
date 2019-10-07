<?php

namespace App\Services;

use App\Interfaces\ParamRepositoryInterface;
use App\Entity\Param;

class ParamService
{
    private $paramRepository;
    private $partTimeCodes = [0,1,2];
    private $maxVisitors = [];
    private $imperativeEndOfBooking ;
    private $endOfBooking ;
    private const KBON = "bookingOrderNumber";

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
                if($param->getRefCode() == "maxBookingOrderDly")
                {
                    $nbMonths = $param->getNumber();
                    $this->EndOfBooking = new \DateTime('+'. $nbMonths . 'month');
                    if($param->getDayNum() !== ''):

                    endif;
                } else{
                    if($param->getRefCode() == "ImperativeBookingEnd")
                    {
                        $date = $param->getExeNum() . "-" .  $param->getMonthNum() . "-" .  $param->getDayNum() ;
                        $this->imperativeEndOfBooking = new \Datetime($date);
                       
                    } else{
                        if($param->getRefCode() == "partTimeCodes")
                        {

                        }
                    }
                }
            }
        
        }

     //  dd($this->params);

    }

   
    public function getBookingNumber()
    {
        return $this->paramRepository->saveNumber(KBON);
    }

    public function findPartTimeCode()
    {
        return $this->partTimeCodes;
       dd($this->params);
    }
    
    /**
     * Find "MaxVisitors" per day explicited by Year, ou yearMonth, or day
     *
     * @return void
     */
    public function findMaxVisitor()
    {
        return $this->partTimeCodes;
    }
    
}