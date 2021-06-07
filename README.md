**Etape 1**
> Vérifier la version de PHP

```php -v```

Symhphony fonctionne à partir de la version 7.2.5, sauf sur la version 7.4.0

Pour mettre à jour PHP : https://brew.sh/index_fr



**Etape 2**
> Installer Composer

https://getcomposer.org/download/

Sur mac, utiliser les commandes décrites. Sur Windows, utiliser l'executable

Terminer par la commande : ```mv composer.phar /usr/local/bin/composer```



**Etape 3**

> Installer Symphony

https://symfony.com/download

Pareil que pour Composer : Lignes de commandes sur Mac, executable sur Windows

Pour finaliser, utiliser la commande donnée commençant par ```mv``` (après "Or install it globally on your system:")



**Etape 4**
> Créer un nouveau projet Symfony

```symfony new nomDuDossierCréé --full```



**Etape 5**
> Créer la base de donnée

Dans le fichier ```.env```, mettre la ligne 31 en commentaire et décommenter la ligne 30. Modifier la ligne avec les informations de la bdd voulue

Une fois fait, utiliser la commande ```php bin/console doctrine:database:create````



**Etape 6**
> Créer le serveur Symfony

```symfony server:start```



**Etape 7**
> Créer un controller par défaut 

```php bin/console make:controller````

Un nouveau fichier va se créer : *src/Controller/DefaultController.php*



**Etape 8**
> Dans ce nouveau fichier, on peut changer les informations dans le @Route en commentaire.

Pour que le Controller s'affiche sur la page d'accueil du serveur, il faut les informations suivantes : ```@Route("/", name="home")```


-------------------------

**Modification d'une page**
> Ajouter une nouvelle page dans *templates/default* portant le nom ```maPage.html.twig````

> étendre le fichier `base.html.twig` --> ```{% extends 'base.html.twig' %}```

> Créer un nouveau block body --> ```{% block body %}```& ```{% endblock %}```

> dans le fichier `DefaultController.php`, créer une fonction pour accéder à notre page (voir modèle de la page home)

> Modifier la route (en suivant le modèle de la fonction de base) avec ces informations : ```@Route(/nomDuNouveauFichier, name="nomDuNouveauFichier")```

-------------------------

**COURS DU 17/05 - CRÉATION DU CategorieController** 

**Etape 1** 
> Ajouter une *entité* (table) à la base de donnée --> ```php bin/console make:entity [nom]````

> Répondre aux questions qui sont posées dans le terminal, qui concernent l'ajout de propriétés dans l'entité

> Utiliser la commande fournie --> ```php bin/console make:migration```. Cela prépare la requeête pour mettre à jour la BDD

> Exécuter la nouvelle commande fournée --> ```php bin/console doctrine:migrations:migrate```, et écrire "yes" lorsque le terminal demande une confirmation


**Etape 2** 
> On travaille dans le fichier du controller que l'on vient de créer (ici `CategorieController.php`)

> Faire l'import --> ```use App\Entity\Categorie;```

> Se connecter à la BDD --> ```$em = $this->getDoctrine()->getManager();```

> Selectionner et récupérer une table --> ```$categories = $em->getRepository(Categorie::class)->findAll();```

> On choisit les variables qu'on envoi à la vue --> ```'categories' => $categories,```


**Etape 3** 
> On travaille dans la vue, le fichier `index.html.twig` généré avec le controller

> On enlève tous ce qui est dans le block `body`et on test avec la ligne suivante --> ```{{ dump(categories) }}```

> OPTIONNEL 
> Créer une condition en twig --> ```{% if %}``` ```{% else %}``` ```{% endif %}```


**Etape 4**
> Création d'un formulaire en Symfony --> ```php bin/console make:form````

> Remplir ce qui est demandé dans le terminal : Nom du formulaire, table sur laquelle on se base pour créer les champs du formulaire

> Dans le nouveau fichier qui s'est créé (`Form/NomDuFormulaire.php`), ajouter un bouton d'envoi après tous les champs suite au `$builder`--> ```->add('Envoyer', SubmitType::class)```


**Etape 5**
> Créer le formulaire dans le controller --> ```$form = $this->createForm(CategorieType::class, $categorie);```

> Importer le formulaire au début du fichier `CategorieController` --> ```use App\Form\CategorieType;```

>  Importer au début du fichier `CategorieType.php` --> ```use Symfony\Component\Form\Extension\Core\Type\SubmitType;```

> Créer un nouvel objet AVANT la création du formulaire --> ```$categorie = new Categorie();```


**Etape 6**
> Ajouter le formulaire à la vue dans le return --> ```'ajout' => $form->createView(),```

> Ajouter le formulaire dans le fichier twig --> ```{{ form(ajout) }}```


**Etape 7**
> Dans le fichier `CategorieController.php`--> ```$form->handleRequest($resquest);

> Importer le Request dans le Controller --> ```use Symfony\Component\HttpFoundation\Request;```

> Importer le paramêtre $resquest au début --> ```public function index(**Request $request**): Response```


**Etape 8**
> Créer la sauvegarde en base 

> Condition : Si le formulaire est soumis --> ``ìf($form->isSubmitted()){}````

> Préparer la sauvegarde en base --> ```$em->persist($categorie);````

> Execute la sauvegarde en base --> ```$em->flush();```


**Etape 9** 
> Déplacer la récupération de la table APRES l'envoi du formulaire


**Etape 10** 
> Utiliser les Assert pour le formulaire 
> Doc : *https://symfony.com/doc/current/validation.html* (3e exemple)


**Etape 11** 
> Faire vérifier à Symfony que le formulaire est bien valide. Pour ça, rentrer la commande ```&& $form->isValid()``` lorsqu'on vérifie si le formulaire est envoyé (*if($form->isSubmitted())*)


-------------------------

**COURS DU 07/06 - Affichage d'une seule catégorie / d'un seul produit** 


**Etape 1**
> Dans les fichiers *Controller*, ajouter une nouvelle route sur ce modèle : ```@Route("/categorie/{id}", name="une_categorie")```


**Etape 2**
> Créer une fonction sur ce modèle : 
```public function categorie(Categorie $categorie = null){}````

> Symfony va essayer de trouver une catégorie qui correspond à l'id reçue, et lui assigner la valeur *null* s'il ne trouve rien.


**Etape 3**
> Gestion de l'erreur (si rien n'est trouvé) 
```
if($categorie == null){
    echo 'Catégorie introuvable';
    die();
}
```
