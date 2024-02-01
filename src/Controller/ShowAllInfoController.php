<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\UserSecurity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowAllInfoController extends AbstractController
{
    #[Route('/admin/show/all/info', name: 'app_show_all_info')]
    public function index(EntityManagerInterface $em): Response
    {
        $all_info = [];

        $userSecu_repo = $em->getRepository(UserSecurity::class);
        $info_repo = $em->getRepository(UserInfo::class);

        $users = $userSecu_repo->findAll();
        //dd($users);
        $infos = $info_repo->findAll();

        //dd($users);
        foreach ($users as $userI){
            //dd($userI);
            //dd($userI->getId());
            $hisInfo = $userI->getUserInfos()->last();
            //dd($hisInfo);
            $all_info[] = [
                'userid'=> $userI->getId(),
                'username'=>$userI->getUsername(),
                'role'=>$hisInfo->getRole(),
                'status'=>$hisInfo->getStatus(),
                'job'=>$hisInfo->getJob(),
                'yearOfExp'=>$hisInfo->getYearOfExp(),
                'gender'=> $hisInfo->getGender(),
                'location'=> $hisInfo->getLocation(),
            ];
        }


        //dd($infos);
        return $this->render('show_all_info/index.html.twig', [
            'controller_name' => 'ShowAllInfoController',
            'infos'=>$all_info,
        ]);
    }
}
