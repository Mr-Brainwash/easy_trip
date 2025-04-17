<?php

namespace App\Controller\API\User\Create;

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

    #[OA\Tag(name: 'User')]
    #[OA\Post(
        description: 'Creates a new user with the provided data',
        summary: 'Create a new user',
        requestBody: new OA\RequestBody(
            description: 'User data',
            required: true,
            content: new OA\JsonContent(
                ref: new Model(type: InputUserDTO::class)
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'User created successfully',
                content: new OA\JsonContent(ref: new Model(type: OutputUserDTO::class))
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
    #[RequireRole(roles: [UserRole::ROLE_USER->value])]
    #[Route('/api/user', name: 'api_user_create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] InputUserDTO $dto): OutputUserDTO
    {
        return $this->manager->create($dto);
    }
}
