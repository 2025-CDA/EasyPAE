# Workflow EasyPAE

---

## 📊 Architecture des données - IMPORTANT

### Stockage du SIRET

-   ❌ Le stagiaire **NE saisit PAS** le SIRET dans son formulaire (`InfoFormInternCompany`)
-   ❌ `InfoFormInternCompany` ne contient **PAS** de champ SIRET
-   ❌ `InfoFormCompany` ne contient **PAS** de champ SIRET (pas de duplication)
-   ✅ Le SIRET est stocké **UNIQUEMENT** dans la table `Company`
-   ✅ Le SIRET est l'identifiant unique de `Company`
-   ✅ On récupère le SIRET via les relations : `CompanyMember` → `Company` → `siret`

### Formulaire stagiaire (`InfoFormInternCompany`)

Le stagiaire saisit :

-   Nom de l'entreprise
-   Adresse
-   **EMAIL du contact entreprise** (⚠️ IMPORTANT : c'est ce contact qui remplira le formulaire avec le SIRET)
-   Nom/Prénom du représentant légal

### Formulaire entreprise (`InfoFormCompany`)

Le contact entreprise reçoit un email et doit remplir :

-   **SIRET** (obligatoire - utilisé pour chercher/créer `Company`)
-   Activité, Fax
-   Informations du tuteur
-   Etc.

---

## L'organisme crée un stagiaire

**Déclencheur** : `POST /organization/session/{sessionId}/intern`

-   ✅ Crée User stagiaire (SANS mot de passe)
-   ✅ Crée InternMember
-   📧 **Au stagiaire** : Email d'activation de compte avec lien JWT (validité 24h)
    -   Objet : "Bienvenue sur EasyPAE - Activez votre compte"
    -   Contenu : Lien vers /reset-password/{token}

## Le stagiaire active son compte

**Déclencheur** : Clic sur lien JWT

-   ✅ Page de définition du mot de passe
-   ✅ Premier login possible
-   ❌ Pas d'email post action (action utilisateur)

## Mot de passe oublié

**Déclencheur** : `POST /auth/forgot-password`

-   📧 **À l'utilisateur concerné** : Email de réinitialisation avec lien JWT (validité 1h)
    -   Objet : "Réinitialisation de votre mot de passe EasyPAE"
    -   Contenu : Lien vers /reset-password/{token}

## Le Stagiaire crée sa fiche PAE

**Déclencheur** : `POST /intern/infoForm`

-   ✅ Crée InfoForm + 3 sous-tables (tous statuts = "initialized")
-   📧 **À l'organisme** : "Le stagiaire X a créé sa fiche PAE"
    -   Objet : "Nouvelle demande de PAE initiée"
    -   Contenu : Nom du stagiaire, dates de stage souhaitées

## Le stagiaire valide son volet (InternProcessor)

**Déclencheur** : `PATCH /intern/infoForm/{id}/infoFormIntern/validation`

-   ✅ `infoFormInternStatus` → "validated"
-   ✅ **[AUTO]** `infoFormCompanyStatus` → "pending"
-   ✅ **[AUTO]** Vérification EMAIL du contact entreprise **UNIQUEMENT** (pas de SIRET à ce stade)
-   📧 Email selon le cas (voir logique ci-dessous)
-   📧 **À l'organisme** : "Le stagiaire X a validé son volet"
    -   Objet : "Demande de PAE validée par le stagiaire"
    -   Contenu : En attente de validation entreprise
-   ❌ **PAS au stagiaire** (c'est lui qui a fait l'action)

#### 🔍 Logique de vérification EMAIL UNIQUEMENT

**⚠️ À ce stade, le SIRET n'est PAS encore connu (le stagiaire ne l'a pas saisi)**

**Recherche dans `User` : Email du contact entreprise existe ?**

**CAS A - Email existe ✅**

-   ✅ L'utilisateur a déjà un compte (`User` + `CompanyMember` existants)
-   ✅ Rattachement du `CompanyMember` existant à ce dossier (`InfoForm`)
-   📧 **À l'entreprise** : Email de NOTIFICATION simple
    -   Objet : "Un nouveau stagiaire souhaite effectuer son stage chez vous"
    -   Contenu : "Vous avez reçu une nouvelle demande de stage. Connectez-vous avec votre compte existant pour consulter le dossier."
    -   Lien direct vers `/login` (pas d'activation nécessaire, compte déjà actif)

**CAS B - Email n'existe pas ❌**

-   ❌ Le contact n'a PAS encore de compte
-   ⚠️ **À CE STADE** : On ne crée **RIEN** (ni `User`, ni `Company`, ni `CompanyMember`)
-   📧 **Au contact entreprise** : Email d'INVITATION à remplir le formulaire entreprise
    -   Objet : "Un stagiaire souhaite effectuer son stage dans votre entreprise"
    -   Contenu : Lien JWT vers le formulaire entreprise (validité 24h)
    -   Lien : `/company/register/{token}`
    -   ⚠️ **C'est dans CE formulaire que l'entreprise saisira le SIRET**

---

## L'entreprise remplit son formulaire (CompanyProcessor - EDIT)

**Déclencheur** : Clic sur le lien d'invitation (CAS B ci-dessus)
**Route** : `PATCH /company/infoForm/{id}/infoFormCompany`

L'entreprise remplit son formulaire `InfoFormCompany` :

-   **SIRET** (obligatoire) ⚠️ C'est ICI que le SIRET est saisi pour la première fois
-   Activité, Fax
-   Informations du tuteur (nom, prénom, email, téléphone)
-   Lieu de travail, horaires
-   Etc.

❌ **Pas de validation à ce stade** (juste sauvegarde du formulaire)
❌ **Aucune création** de `Company`, `User` ou `CompanyMember` (c'est fait à la validation)

---

## L'entreprise valide son volet (CompanyProcessor - VALIDATION)

**Déclencheur** : `PATCH /company/infoForm/{id}/infoFormCompany/validation`

-   ✅ `infoFormCompanyStatus` → "validated"
-   ✅ **[AUTO]** `infoFormOrganizationStatus` → "pending"
-   ✅ **[AUTO]** Vérification SIRET et création `Company`/`User`/`CompanyMember` (voir logique ci-dessous)
-   📧 **Au stagiaire** : "L'entreprise a validé votre demande de stage"
    -   Objet : "Bonne nouvelle ! Votre entreprise d'accueil a validé"
    -   Contenu : Nom entreprise, dates confirmées
-   📧 **À l'organisme** : "Le dossier de X est prêt à être signé"
    -   Objet : "PAE prêt à signer"
    -   Contenu : Lien vers le dossier complet
-   ❌ **PAS à l'entreprise** (c'est elle qui a fait l'action)

#### 🔍 Logique de vérification SIRET et création

**⚠️ C'est ICI que la vérification du SIRET et la création des entités se fait**

**Recherche dans `Company` : SIRET saisi dans le formulaire existe ?**

**CAS B1 - SIRET existe dans `Company` ✅**

-   ✅ L'entreprise (`Company`) existe déjà dans la BDD
-   ✅ Création `User` (email du formulaire, SANS mot de passe)
-   ✅ Création `CompanyMember`
-   ✅ **RATTACHEMENT** du `CompanyMember` à la `Company` existante (via SIRET)
-   ✅ Rattachement à ce dossier (`InfoForm`)
-   📧 **Au nouveau contact** : Email d'ACTIVATION
    -   Objet : "Activez votre compte pour consulter la demande de stage"
    -   Contenu : Lien JWT vers `/activate-account/{token}` (validité 24h)
    -   Note : "Votre entreprise [NOM] est déjà partenaire EasyPAE"

**CAS B2 - SIRET n'existe pas ❌**

-   ✅ Nouvelle entreprise complète à créer
-   ✅ Création `Company` (avec SIRET du formulaire + nom, adresse, etc.)
-   ✅ Création `User` (email du formulaire, SANS mot de passe)
-   ✅ Création `CompanyMember`
-   ✅ Rattachement `User` → `CompanyMember` → `Company`
-   ✅ Rattachement à ce dossier (`InfoForm`)
-   📧 **Au contact entreprise** : Email d'ACTIVATION + BIENVENUE
    -   Objet : "Bienvenue sur EasyPAE - Activez votre compte"
    -   Contenu : Lien JWT vers `/activate-account/{token}` (validité 24h)
    -   Note : "Votre entreprise [NOM] vient d'être ajoutée à notre plateforme"

## L'organisme signe le dossier (OrganizationProcessor)

**Déclencheur** : `PATCH /organization/infoForm/{id}/sign`

-   ✅ `infoFormOrganizationStatus` → "validated"
-   ✅ **[AUTO]** `infoFormStatus` → "fully_completed"
-   📧 **Au stagiaire** : "Votre PAE est officiellement validé !"
    -   Objet : "🎉 Votre PAE est validé"
    -   Contenu : Félicitations, dates officielles, prochaines étapes
-   📧 **À l'entreprise** : "Le PAE de X est validé par l'organisme"
    -   Objet : "PAE officiellement validé"
    -   Contenu : Confirmation des dates, convention signée
-   ❌ **PAS à l'organisme** (c'est lui qui a fait l'action)

## Autres cas à prévoir

-   Si statut passe à "invalidated" :
    📧 **À celui qui a été invalidé** : Raison du refus + actions à entreprendre
-   Si statut passe à "pending"
    📧 **Au prochain acteur** : "Votre action est requise"
