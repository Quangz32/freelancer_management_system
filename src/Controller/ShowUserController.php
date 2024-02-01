<?php

namespace App\Controller;

use App\Entity\UserSecurity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ShowUserController extends AbstractController
{
    //#[Route('/show/user', name: 'app_show_user')]
    public function index(): Response
    {
        return $this->render('show_user/index.html.twig', [
            'controller_name' => 'ShowUserController',
        ]);
    }
    // Trong Controller
//use App\Entity\User;

    #[Route('admin/show/user', name: 'admin_show_user')]
    #[IsGranted('ROLE_ADMIN')]
    public function showUsers(EntityManagerInterface $entityManager)
    {

        
        // Lấy dữ liệu từ cơ sở dữ liệu
        $userRepository = $entityManager->getRepository(UserSecurity::class);
        $users = $userRepository->findAll();
        //dd($users);

        // Truyền dữ liệu vào view template để hiển thị
        return $this->render('show_user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
