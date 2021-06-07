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
        }

        // Récupéartion de la table Categorie :
        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'ajout' => $form->createView(),
        ]);
    }
}
