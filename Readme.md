## Introduction
Ceci est une application PHP MySQL simple d'inscription et de connexion qui permet aux utilisateurs de créer un compte, de se connecter et de se déconnecter.

## Prérequis
- PHP
- MySQL

## Installation
- Clonez le répertoire sur votre machine locale
- Ouvrez le fichier config.php et configurez les informations de connexion à la base de données
- Importez le fichier login_db.sql pour créer la base de données

## Utilisation
- Accédez à la page de connexion en ouvrant le fichier index.php dans un navigateur web
- Entrez votre nom d'utilisateur ou adresse email et mot de passe
- Si les informations sont correctes, vous serez connecté à l'application
- Si vous n'avez pas de compte, vous pouvez en créer un en cliquant sur le bouton "Ajouter un compte" sur la page de connexion et en remplissant le formulaire d'inscription.

## Sécurité
- Protection contre les attaques CSRF : La protection CSRF est mise en place en utilisant une technique de jeton CSRF qui est stocké dans une variable de session. Ce jeton est inséré en tant que champ caché dans le formulaire et est vérifié lors de la soumission du formulaire pour s'assurer que la requête provient du formulaire original et non d'une source malveillante.

- Protection contre les injections SQL : Les injections SQL sont empêchées en utilisant des requêtes préparées pour les requêtes de base de données. Les données saisies par l'utilisateur sont également nettoyées en utilisant la fonction mysqli_real_escape_string().

- Protection contre les attaques par force brute : Les attaques par force brute sont évitées en stockant les mots de passe des utilisateurs de manière cryptée en utilisant la fonction password_hash() de PHP. De plus, la fonction password_verify() est utilisée pour vérifier le mot de passe lors de la connexion.

- Protection contre les attaques par fixation de session : Les attaques par fixation de session sont évitées en régénérant l'ID de session en utilisant la fonction session_regenerate_id(true) lors de la connexion. Cela garantit qu'une nouvelle session est créée pour chaque utilisateur qui se connecte, réduisant ainsi les risques de fixation de session.

- Utilisation de cookies sécurisés : Les cookies de session sont configurés pour être sécurisés en définissant le drapeau de sécurité du cookie de session sur vrai et le drapeau HTTPOnly sur vrai. Cela garantit que le cookie de session ne sera pas envoyé sur des connexions non chiffrées, réduisant ainsi les risques d'interception par des pirates.

- Validation des entrées de l'utilisateur : Les entrées de l'utilisateur sont validées en utilisant la fonction htmlspecialchars() pour éviter les attaques de script intersite (XSS). De plus, la fonction validateForm() est utilisée pour s'assurer que tous les champs requis sont remplis avant la soumission du formulaire.


## Contribution
Si vous trouvez des bugs ou avez des suggestions pour des améliorations, n'hésitez pas à ouvrir une demande ou soumettre une demande de tirage.

## Licence
Ce projet est sous licence MIT.