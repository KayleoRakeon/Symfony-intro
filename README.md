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

> Modifier la route (en suivant le modèle de la fonction de base) avec ces informations : ```@Route(/nomDuNouveauFichier, name="nomDuNouveauFichier")
