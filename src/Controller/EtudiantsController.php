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

    #[Route('/etudiants_add/{id?0}', name: 'add_etudiants')]
    public function add(Request $request, Etudiant $etudiant= null): Response
    {
        if (!$etudiant) {
            $etudiant = new Etudiant();
            $new =true;
        } else $new=false;
        $form = $this->createForm(EtudiantType::class,$etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($etudiant);
            $this->manager->flush();
            if ($new) $this->addFlash("success", "Etudiant ajouté");
            else $this->addFlash("success", "Etudiant modifié");
            return $this->redirectToRoute('app_etudiants');
        }

        return $this->render('etudiants/form.html.twig', ['form'=>$form->createView()]);

    }

    #[Route('/etudiants_delete/{id}', name: 'delete_etudiant')]
    public function delete(Etudiant $etudiant): Response
    {
        $this->manager->remove($etudiant);
        $this->manager->flush();
        $this->addFlash("success", "Etudiant supprimé");
        return $this->redirectToRoute('app_etudiants');

    }
}
