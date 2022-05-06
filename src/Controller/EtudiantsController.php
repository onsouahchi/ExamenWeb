<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantsController extends AbstractController
{
    private $manager;
    private $repository;

    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
        $this->repository = $this->doctrine->getRepository(Etudiant::class);
    }

    #[Route('/etudiants', name: 'app_etudiants')]
    public function index(): Response
    {
        return $this->render('etudiants/index.html.twig', [
            'list' => $this->repository->findAll()
        ]);
    }

    #[Route('/etudiants/add/{id?0}', name: 'add_etudiants')]
    public function add(Request$request,$etudiant): Response
    {
        if (!$etudiant) $personne = new Etudiant();
        $form = $this->createForm(EtudiantType::class,$personne);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($personne);
            $this->manager->flush();
            return $this->redirectToRoute('app_etudiants');
        }

        return $this->render('etudiants/form.html.twig', ['form'=>$form->createView()]);

    }

    #[Route('/etudiants/delete/{id}', name: 'delete_etudiant')]
    public function delete(Request$request, Etudiant $etudiant): Response
    {
        $this->manager->remove($etudiant);
        $this->manager->flush();
        return $this->render('etudiants/index.html.twig');

    }
}
