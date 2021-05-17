<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        // Connexion à la BDD
        $em = $this->getDoctrine()->getManager();
        // Récupéartion de la table Categorie :
        $categories = $em->getRepository(Categorie::class)->findAll();

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'ajout' => $form,
        ]);
    }
}
