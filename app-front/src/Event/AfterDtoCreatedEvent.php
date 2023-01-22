<?php

namespace App\Event;

use App\DTO\PromotionEnquiryInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AfterDtoCreatedEvent extends Event
{
    public const NAME = 'dto.created';

    public function __construct(protected  $dto)
    {
    }

    public function getDto()
    {
        return $this->dto;
    }
}