<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\UserSecurity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilterController extends AbstractController
{
    #[Route('/filter', name: 'app_filter')]
    public function index(): Response
    {
        return $this->render('filter/index.html.twig', [
            'controller_name' => 'FilterController',
            //'job'=>$job,
            //'minYearOfExp'=>$minYearOfExp,
        ]);
    }

    public function GPT_DRAFT_getUserMeetRequirement($job, $yoe, $gender, $location, $status, EntityManagerInterface $em): array{
        // Query the database to retrieve users that meet the requirements
        $query = $em->createQuery('SELECT * FROM UserInfo u WHERE u.job = :job AND u.yearsOfExperience >= :yoe AND u.gender = :gender AND u.location = :location AND u.status = :status');
        $query->setParameter('job', $job);
        $query->setParameter('yoe', $yoe);
        $query->setParameter('gender', $gender);
        $query->setParameter('location', $location);
        $query->setParameter('status', $status);
        $users = $query->getResult();
    
        // Construct an array with the desired information
        $result = [];
        dd($result);
        // foreach ($users as $user) {
        //     $result[] = [
        //         'id' => $user->getId(),
        //         'name' => $user->getName(),
        //         // Add more properties as needed
        //     ];
        // }
    
        // Return the array
        return $result;
    }

    #[Route('/filter_process', name: 'filter_process')]
    public function process(Request $request, EntityManagerInterface $em): Response{
        $job = $request->request->get('job');
        $minYearOfExp = $request->request->get('minYearOfExp');
        $gender = $request->request->get('gender');
        $location = $request->request->get('location');
        $status = $request->request->get('status');

        $userInfo_filted = $this->getUserMeetRequirement($job, $minYearOfExp, $gender, $location, $status, $em);
        // $userSecu_filted = [];
        // foreach ($userInfo_filted as $userIn4){
        //     $userSecu_filted[] = $userIn4->getUserId()->first();
        // }
        $fullInfo_s = [];

        foreach ($userInfo_filted as $userIn4){
            $userSecu = $userIn4->getUserId()->first();
            $fullInfo_s[] = [   'id'=>$userSecu->getId(),
                                'username'=>$userSecu->getUserName(),
                                'job'=>$userIn4->getJob(),
                                'yoe'=>$userIn4->getYearOfExp(),
                                'gender'=>$userIn4->getGender(),
                                'location'=>$userIn4->getLocation(),
                                'status'=>$userIn4->getStatus(),  
                            ];
        }

        //dd($fullInfo_s);



        //dd($pass_filter_user);

        //return $this->redirectToRoute('admin_show_user');
        return $this->render('filter/result.html.twig',[
            'fullInfo'=>$fullInfo_s,
        ]);
    }

    private function getUserMeetRequirement($job, $yoe, $gender, $location, $status, EntityManagerInterface $em): array{
        $result = [];

        $userSecu_s = $em -> getRepository(UserSecurity::class)->findAll();
        //$userInfo_s = $em -> getRepository(UserInfo::class)->findAll();

        //dd($userSecu_s);
        foreach ($userSecu_s as $userSecu){
            $thisUserInfo = $userSecu->getUserInfos()->last();
            if ($this->ok_info($job, $yoe, $gender, $location, $status,$thisUserInfo)){
                $result[] = $thisUserInfo;
            }
        }

        return $result;
    }

    private function ok_info($job, $yoe, $gender, $location, $status, $thisUserInfo):bool{

        //dd($thisUserInfo);

        //dd($job);
        //dd($thisUserInfo->getJob());
        //dd(($thisUserInfo->getJob() == $job));

        if (!(is_object($thisUserInfo) )){ //ktra class cua ThisUserInfo
            return false;
        }

        if (!($thisUserInfo->getJob() == $job)) {
            return false;
        }
        if ($thisUserInfo->getYearOfExp() < $yoe){  //NUMBERRR!!
            return false;
        }
        if ($thisUserInfo->getGender() != $gender){
            return false;
        }

        //check Location
        $loc = $thisUserInfo->getLocation();
        if (($loc == 'vietnam' and $location !='vietnam') or ($loc != 'vietnam' and $location=='vietnam')){
            return false;
        }

        //
        if ($thisUserInfo->getStatus() != $status){
            return false;
        }

        //dd($thisUserInfo);
        return true;
    }



}
