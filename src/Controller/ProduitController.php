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

            // Ajout d'un message flash :
            $this->addFlash('success', 'Produit ajouté');
        }

        // Récupération de la table
        $produits = $em->getRepository(Produit::class)->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'ajout' => $form->createView(),
        ]);
    }


    /**
     * @Route("/produits/{id}", name="un_produit")
     */
    public function produit(Produit $produit = null, Request $request){
        if($produit == null){
            $this->addFlash("danger", "produit introuvable");
            return $this->redirectToRoute('produits');
        }

        $form = $this->createForm(ProduitFormType::class, $produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            $this->addFlash('success', 'Produit modifié');
        }

        return $this->render('produit/produit.html.twig', [
            'produit' => $produit,
            'edit' => $form->createView()
        ]);
    }

    /**
     * @Route("/produit/delete/{id}", name="deleteProduit")
     */
    public function deleteProduit(Produit $produit = null){
        if($produit == null){
            $this->addFlash('danger', 'Produit introuvable');
            return $this->redirectToRoute('produit');
        }

        // Récupération de doctrine (connexion à la BDD)
        $em = $this->getDoctrine()->getManager();
        // Préparation de la suppression
        $em->remove($produit);
        // Execution de la suppression
        $em->flush();

        // Message flash
        $this->addFlash('warning', 'Produit supprimé');
        return $this->redirectToRoute('produits');
    }
}
