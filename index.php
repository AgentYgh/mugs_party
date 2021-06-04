<?php
include 'form/sortingForm.php';
include 'config/configuration.php';
include 'config/connect.php';

$maintitle = 'Mugs Party';
$colors = ['Noir','Blanc','Violet','Marron','Rose','Vert','Jaune'];
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
        <link rel="manifest" href="images/favicon/site.webmanifest">
        <link rel="stylesheet" href="css/bootstrap-v4.6.0.css">
        <link rel="stylesheet" href="css/font-awesome-4.7.0.css">
        <link rel="stylesheet" href="css/custom.css">
        <?php
        echo '<title>'.$maintitle.'</title>';
        ?>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/"><img src="images/logo.png" alt="logo" class="mr-2"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <?php
                        echo '<li class="nav-item active">
                            <a class="nav-link txt-l" href="/">'.$maintitle.'</a>
                        </li>'
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul>
                <button type="button" id="toggle-sorting-bar" class="btn btn-outline-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </nav>
        <div class="jumbotron jumbotron-fluid pb-5">
            <div class="container">
                <h1 class="display-4">Mugs & Tasses</h1>
                <p class="lead"><a href="#">Découvrez notre sélection.</a> <small><em>Commande simple et livraison rapide.</em></small></p>
                <div class="new">

                    <?php
                    if (isset($_SESSION)) {
                        echo '<a href="#" class="btn btn-outline-secondary"><i class="fa fa-plus mr-2"></i>Ajouter un mug</a>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php
        /**
         * (45 points).
         *
         * (référence image: shorting-bar-1.jpg)
         * (référence image: shorting-bar-2.jpg)
         * (référence image: shorting-bar-3.jpg)
         * (référence image: shorting-bar-4.jpg)
         * (référence image: shorting-bar-5.jpg)
         *
         * Tu dois créer une barre de recherche (poster en url) qui permet d'afficher les mugs choisis selon les critères ci dessous:
         *  - en stock
         *  - par prix (montant mininum 1, montant maximum 60)
         *  - par couleur
         *  - par taille
         *  - par nouveautés
         *  - par tendances.
         *
         * Contrainte 1: Dans tous les cas de figures possibles, seuls les mugs qui possèdent une image seront affichés.
         *
         * Exemple: Ta barre de recherche permet d'afficher tous les mugs qui sont en stock avec un prix supérieur à 32€ de couleur rose et de taille S qui sont nouveaux mais pas tendance.
         *
         * Tu dois utiliser dans ton code le tableau PHP déclaré pour afficher les couleurs disponibles. (-5 points si en dur)
         * Tu dois utiliser dans ton code la table sizes pour afficher les tailles disponibles. (-5 points si en dur)
         *
         * Ta barre de recherche doit contenir un bouton RESET pour re initialiser la barre de recherche aux valeurs par défaut. (référence image: shorting-bar-1.jpg)
         *
         * Pour la logique du tri:
         *  - Dans le dossier form tu créeras le fichier sortingForm.php
         *  - Dans ce fichier tu mettras ta logique pour la barre de tri.
         *
         * Seulement sur la page index.php, la barre de recherches doit garder les valeurs sélectionnées par l'utilisateur final
         * Exemple: Si l'utilisateur final demande tous les mugs qui ne sont pas en stock, une fois la recherches effectuée,
         *          la barre de recherches doit continuer à afficher le select En stock à Non. (idem pour les autres champs)
         */
        ?>

        <div id="sorting-bar" class="container-fluid sorting-bar">
            <div class="form-inline">
                <nav class="navbar navbar-expand-lg">
                    <div class="p-1">
                        <a>En Stock:</a>
                        <select name="stock" class="form-control">
                            <option value='all'>All</option>
                            <option value='oui'>Oui</option>
                            <option value='non'>Non</option>
                        </select>
                    </div>
                    <div class="p-1 form-inline">
                        <div class="form-inline">
                            <a>Tarif:</a>
                            <select name="tarif" class="form-control">
                                <option value='all'>All</option>
                                <option value='sup'>Supérieur</option>
                                <option value='inf'>Inférieur</option>
                            </select>
                            <form class="p-1 ml-1">
                                <a>à</a>
                                <input type="number" class="bg-white round-box form-control" id="trarifA">
                                <a>€</a>
                            </form>
                        </div>
                    </div>
                    <div class="p-1">
                        <a>Couleur:</a>
                        <select name='color' class='form-control'>
                            <option value='all'>All</option>
                            <?php
                                foreach ($colors as $c) {
                                    echo '<option value='.$c.'>'.$c.'</option>';
                                };
                            ?>
                        </select>
                    </div>
                    <div class="p-1">
                        <a>Tailles:</a>
                        <select name="size" class="form-control">
                            <option value='all'>All</option>
                            <?php
                                $sql = 'SELECT * FROM sizes';
                                if ($result = $mysqli->query($sql)) {
                                    if ($result->num_rows > 0) {
                                      while ($row = $result->fetch_assoc()) {
                                        echo '<option value='.$row['sizes'].'>'.$row['sizes'].'</option>';
                                      }
                                    }
                                  }
                            ?>
                        </select>
                    </div>
                    <div class="p-1">
                        <a>Nouveautés:</a>
                        <select name="new" class='form-control'>
                            <option value='all'>All</option>
                            <option value='yes'>Non</option>
                            <option value='no'>Oui</option>
                        </select>
                    </div>
                    <div class="p-1">
                        <a>Tendance:</a>
                        <select name='trend' class='form-control'>
                            <option value='all'>All</option>
                            <option value='no'>Non</option>
                            <option value='yes'>Oui</option>
                        </select>
                    </div>
                    <div class="m-1">
                        <button class="btn btn-success">
                            Trier
                        </button>
                    </div>
                    <div class="m-1">
                        <button class="btn btn-danger">
                            Reset
                        </button>
                    </div>
                </nav>
            </div>
        </div>

        <?php
        /**
         * (30 points).
         *
         * Contrainte 2: Aucun attribut style="" est autorisé dans le code HTML. Tous le css doivent être ajouter au fichier custom.css
         * Contrainte 3: Tu dois reproduire au plus près possible la copie conforme des cartes du formateur (référence image: exemple.jpg)
         *
         * Tu dois afficher tous les mugs présents en base de données (ref: Contrainte 1) si aucun tri est fait SINON afficher ceux triés par la barre de recherche.
         *
         * 
         * Pour les écrans: (référence image: exemple.jpg)
         *  - écran < 600px = 1 carte par ligne
         *  - écran > 600px and < 768px = 2 cartes par ligne
         *  - écran > 768px and < 1024px = 3 cartes par ligne
         *  - écran > 1024px = 4 cartes par ligne.
         *
         * Les titres des mugs doivent être en majuscules via le CSS
         * Pour le dégradé des titres les couleurs sont: rgba(3, 102, 3, 1) et rgba(0, 0, 0, 1)
         *
         * Toutes les cartes doivent avoir la même hauteur et ne doivent pas être cliquables. Donc oublie la balise <a>
         *
         * Au passage de la souris sur la carte et uniquement au passage de la souris sur la carte:
         *  - la couleur de la carte doit être: rgba(240, 255, 255, 1)
         *  - le curseur de la souris de la carte doit devenir la main. (référence image: exemple-curseur.jpg)
         *  - les couleurs du dégradé des titres changent en: rgba(129, 25, 124, 1) et rgba(0, 0, 0, 1)
         *
         * Url pour trouver les icones: https://fontawesome.com/v4.7/
         * Pour les stocks et icones: (référence image: exemple-stock.jpg)
         *  - la couleur de l'icone pour la disponibilité en stock: rgba(0, 128, 0, 1)
         *  - la couleur de l'icone pour la non disponibilité en stock: rgba(206, 14, 14, 1)
         *  - les informations des prix et stocks doivent être en bas de carte et toutes alignées à la même hauteur
         *  - le mot "pièce" doit contenir le S (pièces) s'il contient plus d'une pièce en stock
         */
        ?>

        <div class="container mt-40">
            <?php
                include 'form/sortingForm.php';
            ?>
        </div>

        <div class="spacer spacer-md"></div>
        <footer role="contentinfo" id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-6 footer-box">
                        <p style="padding-right:80px;"><h4>
                        <?php    
                        echo $maintitle.'.';
                        ?>
                        </h4>On y trouve de tout et surtout du n'importe quoi !!</p>
                        <h3 class="footer-heading">Nous suivre</h3>
                        <ul class="social-icons">
                            <li><a href="#" target="_blank"><i class="rounded-circle fa fa-google"></i></a></li>
                            <li><a href="#" target="_blank"><i class="rounded-circle fa fa-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="rounded-circle fa fa-facebook"></i></a></li>	
                            <li><a href="#" target="_blank"><i class="rounded-circle fa fa-rss"></i></a></li>
                        </ul>
                        <h3 class="footer-heading">Contact</h3>
                        <ul class="contact-info">
                            <li><span class="icon fa fa-home"></span>
                            <?php
                                echo $maintitle.',';
                            ?>
                            67000 Strasbourg</li>
                            <li><span class="icon fa fa-phone"></span>03.99.98.97.96</li>
                            <li><span class="icon fa fa-envelope"></span>contact@mugsparty.fr</li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6 footer-box">
                        <h3 class="footer-heading">Liens</h3>
                        <ul class="footer-links">
                            <li><a href="#" target="_blank">Home</a></li>
                            <li><a href="#" target="_blank">About us</a></li>
                            <li><a href="#" target="_blank">Contact</a></li>
                            <li><a href="#" target="_blank">Legal mentions</a></li>
                        </ul>
                        <h3 class="footer-heading">Catégories</h3>
                        <ul class="footer-links">
                            <li><a href="#" target="_blank">Mugs</a></li>
                            <li><a href="#" target="_blank">Tasses</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-sm-12 footer-box">
                        <h3 class="footer-heading">Nous contacter</h3>

                        <?php
                        /**
                         * (7 points).
                         *
                         * Tu dois créer la page contact.php
                         * Sur la page contact tu dois faire un dump des informations envoyées (email, message) via le formulaire de contact du footer ci dessous.
                         * La function _dump() est disponible dans le fichier configuration.php qui se trouve dans le dossier config.
                         * Contrainte 4: Obligation d'utiliser la function _dump();
                         */
                        ?>

                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Votre email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="username@yahoo.fr">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="message" class="col-sm-2 col-form-label">Votre message</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="message" rows="3" placeholder="..."></textarea>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-outline-secondary"><i class="fa fa-send mr-2"></i>Envoyer</button>
                        </div>
                    </div>
                    <div class="col-md-12 footer-box">
                        <div class="copyright">
                        <p>&copy; 2021. 
                        <?php    
                            echo $maintitle.'.';
                        ?>    
                        Tous droits réservés.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>