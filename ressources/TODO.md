### TODO

**Arnaud (voir ressources/schema.png)** 
- mettre a jour la route infoFormInternCompanyValidation :
    si l'email du contact existe deja dans la bdd
        envoyer un mail a la personne qui doit deja etre connecté a une company

    si l'email n'existe pas
        creation de l'utilsateur et envoi de mail pour 1ere connexion

    si le nouvel utilisateur entre sa company mais quelle existe deja
        il se rattache a elle

    si le nouvel utilisateur entre sa company mais qu'elle n'existe pas
        il la creer en rentrant les champs necessaire

**Charles**
- finir la configuration des mails et les injecter dans les processor adéquats
    Listing des mails :
    . nouveau "user" via "Ajouter un stagiaire" OK
    . mot de passe oublié OK
    . nouveau "user" via "Suivant" (ajout d'un company_member)
    . modification du statuts
- user/change-password

**Max**
- account/{userId}/info :
    GET/PATCH ajouter les champs phoneNumber, address and birthday sur ces 2 routes.
- ajouter un champ updatedAt sur les routes status

**Mélissa & Julen**
- problème du POST (création de sessions) de OrganizationDTO où ça fait une erreur 400 iri mais que ça met bien en BDD



### TO FINISH :
- contrôle de toutes les routes
- suppression des components inutiles (MailerController, templates/pages)