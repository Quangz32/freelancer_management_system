<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\UserSecurity;
use App\Form\UserInfoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SelfEditController extends AbstractController
{
    #[Route('/self/edit/{userid}/{username}', name: 'self_edit')]
    public function index($userid, $username, Security $security): Response
    {
        if ($userid != ($security->getUser()->getId())){
            return $this->redirectToRoute('app_start');
        }

        return $this->render('self_edit/index.html.twig', [
            'controller_name' => 'SELF_EditController',
            //'user_to_edit'=>$user_to_edit,
            'userid'=>$userid,
            'username'=>$username,
        ]);
    }

    #[Route('/self/edit/process', name: 'self_edit_process')]
    public function process(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Tạo một đối tượng UserInfo mới
            $userInfo = new UserInfo();

            // Gán giá trị cho các thuộc tính
            
            $userInfo->setJob($request->request->get('job'));
            //dd($request->request->get('YearOfExp'));
            $userInfo->setYearOfExp((int)$request->request->get('YearOfExp'));
            $userInfo->setGender($request->request->get('gender'));
            $userInfo->setLocation($request->request->get('location'));

            // Lấy một đối tượng UserSecurity từ cơ sở dữ liệu (ví dụ)
            $userSecurity = $entityManager->getRepository(UserSecurity::class)->find($request->request->get('userid'));

            foreach ($userSecurity->getRoles() as $a_role){
                $userInfo->setRole($a_role); //Mac dinh
            }
            
            if ($userSecurity->getUserInfos()->last()){
                $userInfo->setStatus($userSecurity->getUserInfos()->last()->getStatus());
            }
            else{
                $userInfo->setStatus('non_approved');
            }
            

            // Thêm đối tượng UserSecurity vào thuộc tính ManyToMany
            $userInfo->addUserId($userSecurity);

            //dd($userInfo);

            // Lưu đối tượng UserInfo vào cơ sở dữ liệu (ví dụ sử dụng Doctrine)
            $entityManager->persist($userInfo);
            $entityManager->flush();
        return $this->redirectToRoute('app_start');
    }
}
