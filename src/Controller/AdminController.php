<?php

namespace App\Controller;

use App\Entity\Dier;
use App\Form\DierType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser()->getFname();
        $dieren=$doctrine->getRepository(Dier::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'user' => $user, 'dieren' => $dieren,
        ]);
    }

        #[Route('/insert', name: 'app_insert')]
        public function insert(Request $request, EntityManagerInterface $entityManager):Response{

        $dier= new Dier();
        $form=$this->createForm(DierType::class, $dier);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($dier);
                $entityManager->flush();

                return $this->redirectToRoute('app_admin');
            }



        return $this->renderForm('admin/insert.html.twig', [
                'form' => $form,
            ]);




        }


}
