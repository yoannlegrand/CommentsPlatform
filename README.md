J'ai livré ici ce que je suis arrivé à faire en un peu plus de 4 heures (1 heure par jour environ).

Au niveau connexion, je n'ai pas utiliser un bundle tout fait. On se connecte avec user/userpass (en dur dans le code) pour avoir le role USER qui accède à toutes les pages. 
Pour une "vrai" application, on aurait bien sur plusieurs niveau de role et les infos en BDD.

J'ai utilisé SensioBuzzBundle (https://github.com/sensiolabs/SensioBuzzBundle#step3-enable-the-bundle) pour faire des appel curl sur le service GitHub.
J'ai joint le package dans vendor/kriswallsmith car j'ai fait une petite modification (je sais c'est mal), j'ai rencontré un problème de certificat lors de l'appel curl. 
J'ai donc modifié les infos passées pour faire semblant d'être un navigateur et ne plus vérifier le ssl :

curl_setopt($this->lastCurl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($this->lastCurl, CURLOPT_SSL_VERIFYPEER, false);

On doit pouvoir faire plus propre en passant ces infos dans la fonction d'appel du service (idem manque de temmps).
 
J'ai créé un service gitHub qui propose 2 fonctions (1 pour rechercher les utilisateurs, 1 autre pour rechercher les publications d'un utilisateur). Ce service prend en paramètre le service buzz importé.
On trouve ça dans le bundle services.

L'application comporte donc :
	- une page de recherche utilisateur 
	- une page de résultats (j'affiche uniquement les résultats de la page 1, j'aurais aimé faire une pagination mais je n'ai pas eu le temps).
	- une page permettant de commenter les publications d'un utilisateur (1 select avec la liste de ses publications) et affichant les 5 derniers commentaires
	

Niveau style et mise en page, j'ai tenté de faire sobre. 	


ps: Avant le commit, j'ai virer le dossier app/cache et toutes les librairies de base (elles sont dans le composer.json)
=======

A Symfony project created on February 8, 2016, 2:41 pm.
