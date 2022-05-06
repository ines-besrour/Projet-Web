<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'etudiant')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Etudiant::class);
        $etudiants=$repository->findAll();
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }

    #[Route('/delete/{id}', name: 'etudiant.delete')]
    public function deleteEtudiant(Etudiant $etudiant = null , ManagerRegistry $doctrine): Response
    {
        if ($etudiant) {
            $manager=$doctrine->getManager();
            $manager->remove($etudiant);
            $manager->flush();
            $this->addFlash('success',"etudiant supprimé avec success");
        }else{
            $this->addFlash('error','la personne est innexistante');
        }
        return $this->redirectToRoute('etudiant');
    }

    #[Route('etudiant/edit/{id?id}', name: 'etudiant.edit')]
    public function form(Etudiant $etudiant = null,ManagerRegistry $doctrine , \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $new = false;
        //$this->getDoctrine() : Version Sf <= 5
        if (!$etudiant) {
            $new = true;
            $etudiant = new Etudiant();
        }

        // $personne est l'image de notre formulaire
        $form = $this->createForm(EtudiantFormType::class, $etudiant);
        // Mn formulaire va aller traiter la requete
        $form->handleRequest($request);
        //Est ce que le formulaire a été soumis
        if ($form->isSubmitted()){
            $manager=$doctrine->getManager();
            $manager->persist($etudiant);
            $manager->flush();
            if ($new){
                $this->addFlash('success',$etudiant->getNom()." a etait ajouté avec success");
            }else{
                $this->addFlash('success',$etudiant->getNom()." a etait modifié avec success");
            }
            return $this->redirectToRoute('etudiant');
        }else{
            return $this->render('etudiant/form.html.twig', [
                'form'=>$form->createView(),
            ]);
        }
    }
}
