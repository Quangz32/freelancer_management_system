<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\UserSecurity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApproveController extends AbstractController
{
    #[Route('/admin/approve/{userid}', name: 'app_approve')]
    public function index(EntityManagerInterface $em, $userid): Response
    {

        $user_to_appove = $em->getRepository(UserSecurity::class)->find($userid);
        //dd($user_to_delete);
        if ($user_to_appove) {
            $user_info_d = $user_to_appove->getUserInfos()->last();
            $user_info_d->setStatus("approved");
            $em->persist($user_info_d);
            $em->flush();
        }

        return $this-> redirectToRoute('app_show_all_info');


        // //dd($infos);
        // return $this->render('show_all_info/index.html.twig', [
        //     'controller_name' => 'ShowAllInfoController',
        //     'infos'=>$all_info,
        // ]);
    }
}
