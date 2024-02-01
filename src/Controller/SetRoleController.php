<?php

namespace App\Controller;

use App\Entity\UserSecurity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SetRoleController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setUserRole(int $userId, array $roles)
    {
        $userRepository = $this->entityManager->getRepository(UserSecurity::class);
        $user = $userRepository->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $user->setRoles($roles);
        $this->entityManager->flush();

        // ...
    }

    #[Route('/set_role', name: 'app_set_role')]
    public function index(): Response
    {
        $this->setUserRole(1,['ROLE_ADMIN']);
        return $this->render('set_role/index.html.twig', [
            'controller_name' => 'SetRoleController',
        ]);
    }
}
