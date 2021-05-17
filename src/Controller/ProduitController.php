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
        $em = $this->getDoctrine()->getManager();

        $produit = new Produit();
        $form = $this->createForm(ProduitFormType::class, $produit);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $em->persist($produit);
            $em->flush();
        }

        $produits = $em->getRepository(Produit::class)->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'ajout' => $form->createView(),
        ]);
    }
}
