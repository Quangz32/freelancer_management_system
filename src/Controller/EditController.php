<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\UserSecurity;
use App\Form\UserInfoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EditController extends AbstractController
{
    #[Route('/admin/edit/{userid}/{username}', name: 'admin_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function index($userid, $username): Response
    {
        /*        $userInfo = new UserInfo();
        //set som init

        $form = $this->createForm(UserInfoType::class, $userInfo);
        //dd($form);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $newUserInfo = $form->getData();

           //dd($newUserInfo);
           $entityManager->persist($newUserInfo);
           $entityManager->flush();

           // Xử lý dữ liệu, ví dụ: lưu vào cơ sở dữ liệu

           return $this->redirectToRoute('admin_show_user');  
        }
        */

        return $this->render('edit/index.html.twig', [
            'controller_name' => 'EditController',
            //'user_to_edit'=>$user_to_edit,
            'userid'=>$userid,
            'username'=>$username,
        ]);
    }

    #[Route('/admin/edit/process', name: 'edit_process')]
    #[IsGranted('ROLE_ADMIN')]
    public function process(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Tạo một đối tượng UserInfo mới
            $userInfo = new UserInfo();

            // Gán giá trị cho các thuộc tính
            $userInfo->setRole($request->request->get('role'));
            $userInfo->setStatus($request->request->get('status'));
            $userInfo->setJob($request->request->get('job'));
            //dd($request->request->get('YearOfExp'));
            $userInfo->setYearOfExp((int)$request->request->get('YearOfExp'));
            $userInfo->setGender($request->request->get('gender'));
            $userInfo->setLocation($request->request->get('location'));

            // Lấy một đối tượng UserSecurity từ cơ sở dữ liệu (ví dụ)
            $userSecurity = $entityManager->getRepository(UserSecurity::class)->find($request->request->get('userid'));

            // Thêm đối tượng UserSecurity vào thuộc tính ManyToMany
            $userInfo->addUserId($userSecurity);

            //dd($userInfo);

            // Lưu đối tượng UserInfo vào cơ sở dữ liệu (ví dụ sử dụng Doctrine)
            $entityManager->persist($userInfo);
            $entityManager->flush();
        return $this->redirectToRoute('app_start');
    }

}
