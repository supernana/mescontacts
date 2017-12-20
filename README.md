# mescontacts

Objectifs :

	* Creer une appli de gestion des contacts


Contexte :

	* Connexion avec login / mdp (plusieurs users)
	* Contacts : 
		** Nom
		** Prénom 
		** Email
		** 1 ou + adresses

	* 1 adresse = 1 contact (l'inverse est faut)
	* 1 contact = 1 user
 
Fonctionnalités :

	* Ecran de login
	* Page d'accueil = liste des contacts de l'user
	* Liste des contacts
		** bouton de creation
		** Bouton edition sur chaque contact

	* Creation/edition d'un contact (Modification de toutes les caracteristiques)
		** Nom
		** Prenom
		** Email avec bouton de validation (call webservice test formatage <prefixe>@<suffixe>.extension - test unitaire PHP )
		** Liste des adresses avec bouton edition [+ creation]

	* Ecran creation/edition des adresses
		** Modification de toutes les caractéristiques 

Livrable : 
    
    * Code source disponible ici https://github.com/supernana/mescontacts
    * Script de création de la base de données : 
        dans le répertoire db :
            ** database.sql
            ** structure.sql
            ** content.sql
