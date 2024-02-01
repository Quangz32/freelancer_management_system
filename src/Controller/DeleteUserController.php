<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\UserSecurity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteUserController extends AbstractController
{
    #[Route('/admin/delete/user/{userid}', name: 'admin_delete_user')]
    public function index($userid, EntityManagerInterface $em): Response
    {
        $user_to_delete = $em->getRepository(UserSecurity::class)->find($userid);
        //dd($user_to_delete);
        if ($user_to_delete) {
            //$em->remove($user_to_delete);
            //$em->getRepository(UserInfo::Class)->
            $user_info_d = $user_to_delete->getUserInfos()->last();
            $user_info_d->setStatus("deleted");
            $em->persist($user_info_d);
            $em->flush();
        }
        return $this->redirectToRoute('admin_show_user');
    }
}
