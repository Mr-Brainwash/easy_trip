<?php

namespace App\Controller\API\User\Update;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[Route('/api/user/{id}', name: 'api_user_update', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function __invoke(int $id, #[MapRequestPayload] InputUserDTO $dto): OutputUserDTO
    {
        return $this->manager->update($id, $dto);
    }
}
