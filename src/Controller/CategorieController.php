<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(Request $request): Response
    {
        // Connexion à la BDD
        $em = $this->getDoctrine()->getManager();
        // Récupéartion de la table Categorie :
        // $categories = $em->getRepository(Categorie::class)->findAll();

        // Nouvel objet vide pour le formulaire
        $categorie = new Categorie();
        // Création du formulaire CategorieType avec l'objet vide
        $form = $this->createForm(CategorieType::class, $categorie);
        // Capte l'envoi du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($categorie); // Comme ->prepare()
            $em->flush(); // Comme ->execute()

            $this->addFlash('success', 'Catégorie ajoutée');
        }

        // Récupéartion de la table Categorie :
        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'ajout' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="une_categorie")
     */
    public function categorie(Categorie $categorie = null, Request $request){
        if($categorie == null){
            $this->addFlash('danger', 'Catégorie introuvable');
            return $this->redirectToRoute('categorie');
        }

        // Création du formulaire CategorieType avec l'objet vide
        $form = $this->createForm(CategorieType::class, $categorie);
        // Capte l'envoi du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie); // Comme ->prepare()
            $em->flush(); // Comme ->execute()

            $this->addFlash('success', 'Catégorie modifiée');
        }

        return $this->render('categorie/categorie.html.twig', [
            'categorie' => $categorie,
            'edit' => $form->createView()
        ]);
    }

    /**
     * @Route("/categorie/delete/{id}", name="deleteCategorie")
     */

     public function deleteCategorie(Categorie $categorie = null){
         if($categorie == null){
             $this->addFlash('danger', 'Categorie introuvable');
             return $this->redirectToRoute('categorie');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        $this->addFlash('warning', 'Catégorie supprimée');
        return $this->redirectToRoute('categorie');
    }

}
