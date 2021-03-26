<?php

namespace App\Data;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class SearchLodgingData
{
    /**
     * @var DateTime
     * @Assert\NotBlank
     */
    public $beginsAt;

    /**
     * @var DateTime
     * @Assert\NotBlank
     */
    public $endsAt;

    /**
     * @var int
     * @Assert\Positive
     */
    public $visitors = 1;

    /**
     * @var float
     */
    public $lat;

    /**
     * @var float
     */
    public $lng;

    /**
     * @var string
     */
    public $cityName;

}