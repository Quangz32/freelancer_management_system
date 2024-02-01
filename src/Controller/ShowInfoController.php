<?php

namespace App\Controller;

use App\Entity\UserSecurity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowInfoController extends AbstractController
{
    #[Route('/show/info/{userid}', name: 'show_info')]
    public function index($userid, EntityManagerInterface $em): Response
    {
        $user_scrt = $em->getRepository(UserSecurity::class);
        $user_to_show = $user_scrt->find($userid);
        $uts_info = $user_to_show->getUserInfos();
        $user_info = $uts_info->last(); //Lay du lieu moi nhat
        //dd($uts_info->last());  //Lay du lieu moi nhat


        if (!$user_info) {
            return $this->render('show_info/noInfo.html.twig',[
                'user_name' => $user_to_show->getUserName(),
                'user_id' =>$userid,
            ]);
        }
        else {return $this->render('show_info/index.html.twig', [
                'controller_name' => 'ShowInfoController',
                'user_info' => $user_info,
                'user_name' => $user_to_show->getUserName(),
                'user_id' =>$userid,
            ]);
        }
    }
}
