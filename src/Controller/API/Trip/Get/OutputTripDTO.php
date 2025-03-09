<?php

namespace App\Controller\API\Trip\Get;

use App\Controller\DTO\OutputDTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

class OutputTripDTO implements OutputDTOInterface
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Positive]
        public int $id,

        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $driver_id,

        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $start_location_id,

        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $end_location_id,

        #[Assert\NotBlank]
        public \DateTime $departure_time,

        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $available_seats,

        #[Assert\NotBlank]
        #[Assert\PositiveOrZero]
        public string $price_per_seat,

        #[Assert\NotBlank]
        #[Assert\Choice(['planned', 'in_progress', 'completed', 'cancelled'])]
        public string $status,
    ) {
    }
}
