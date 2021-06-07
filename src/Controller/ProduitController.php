<?php

namespace App\Controller;
use App\Entity\Produit;
use App\Form\ProduitFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     */
    public function index(Request $request): Response
    {
        // Récupération du gesitonnaire de BDD
        $em = $this->getDoctrine()->getManager();

        // Création de l'objet vide pour le formulaire
        $produit = new Produit();
        // Création du formulaire
        $form = $this->createForm(ProduitFormType::class, $produit);

        // Détecte quand le formulaire est envoyé 
        $form->handleRequest($request);
        // Si le formulaire a été envoyé :
        if($form->isSubmitted() && $form->isValid()){
            // prépare la sauvegarde de l'objet
            $em->persist($produit);
            // Execute la sauvegarde
            $em->flush();
        }

        // Récupération de la table
        $produits = $em->getRepository(Produit::class)->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'ajout' => $form->createView(),
        ]);
    }
}
