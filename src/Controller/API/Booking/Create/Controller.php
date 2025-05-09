<?php

namespace App\Controller\API\Booking\Create;

use App\Controller\Security\RequireRole;
use App\Domain\ValueObject\UserRole;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[OA\Tag(name: 'Booking')]
    #[OA\Post(
        description: 'Creates a new booking with the provided data',
        summary: 'Create a new booking',
        requestBody: new OA\RequestBody(
            description: 'Booking data',
            required: true,
            content: new OA\JsonContent(
                ref: new Model(type: InputBookingDTO::class)
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Booking created successfully',
                content: new OA\JsonContent(ref: new Model(type: OutputBookingDTO::class))
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'type', type: 'string', example: 'error'),
                        new OA\Property(property: 'message', type: 'string', example: 'Error message'),
                    ]
                )
            ),
        ]
    )]
    #[RequireRole(roles: [UserRole::ROLE_PASSENGER->value])]
    #[Route('/api/booking', name: 'api_booking_create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] InputBookingDTO $dto): OutputBookingDTO
    {
        return $this->manager->create($dto);
    }
}
