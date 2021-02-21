<?php

namespace App\Services;

use App\Entity\Lodging;
use App\Repository\BookingRepository;

class DateRangeHelper{

    /**
     * @var BookingRepository
     */
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Cette méthode retourne les plages de date réservés pour un hébergements et les convertie en string pour LitePicker.js
     */
    public function getBookedDateRangesForJS(Lodging $lodging) : array{
        $bookedRanges = $this->bookingRepository->findBookedDateRanges($lodging->getId());

        return  $this->convertToString($bookedRanges);
    }

    public function convertToString(array $dateRanges) : array{
        $bookedRanges = [];

        foreach ($dateRanges as $book){

            $range = [];
            foreach ($book as $date){
                $range[] = $date->format('Y-m-d');
            }
            $bookedRanges[] = $range;
        }

        return $bookedRanges;
    }
}