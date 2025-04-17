<?php

namespace App\Controller\API\Location\Delete;

use App\Controller\Security\RequireRole;
use App\Domain\ValueObject\UserRole;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[OA\Tag(name: 'Location')]
    #[OA\Delete(
        description: 'Deletes a location by ID',
        summary: 'Delete a location by ID',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, description: 'The ID of the location to delete'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Location deleted successfully'
            ),
            new OA\Response(
                response: 404,
                description: 'Location not found'
            ),
        ]
    )]
    #[RequireRole(roles: [UserRole::ROLE_ADMIN->value])]
    #[Route('/api/location/{id}', name: 'api_location_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(int $id): JsonResponse
    {
        $this->manager->deleteLocation($id);

        return $this->json(['message' => 'Location deleted successfully']);
    }
}
