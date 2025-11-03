# Tests du Workflow Complet - API Platform

## 📋 Prérequis

-   InfoForm avec ID = 101 existant en base
-   User stagiaire (InternMember) associé à ce dossier
-   Email de contact entreprise défini dans InfoFormInternCompany

---

## 🔄 0. Réinitialisation des statuts (InfoForm ID = 101)

### SQL - Réinitialiser les statuts

```sql
-- Réinitialiser tous les statuts du dossier 101
UPDATE info_form
SET status = 'initialized'
WHERE id = 101;

-- Les sous-tables n'ont pas de colonne info_form_id, on doit utiliser une sous-requête
UPDATE info_form_intern
SET status = 'initialized'
WHERE id = (SELECT info_form_intern_id FROM info_form WHERE id = 101);

UPDATE info_form_company
SET status = 'initialized'
WHERE id = (SELECT info_form_company_id FROM info_form WHERE id = 101);

UPDATE info_form_organization
SET status = 'initialized'
WHERE id = (SELECT info_form_organization_id FROM info_form WHERE id = 101);
```

### SQL - Vérifier les statuts initiaux

```sql
-- Vérifier les statuts du dossier 101
SELECT
    `if`.id AS info_form_id,
    `if`.status AS info_form_status,
    ifi.id AS info_form_intern_id,
    ifi.status AS info_form_intern_status,
    ifc.id AS info_form_company_id,
    ifc.status AS info_form_company_status,
    ifo.id AS info_form_organization_id,
    ifo.status AS info_form_organization_status
FROM info_form `if`
LEFT JOIN info_form_intern ifi ON `if`.info_form_intern_id = ifi.id
LEFT JOIN info_form_company ifc ON `if`.info_form_company_id = ifc.id
LEFT JOIN info_form_organization ifo ON `if`.info_form_organization_id = ifo.id
WHERE `if`.id = 101;
```

**Résultat attendu :**
| Column | Valeur attendue |
|--------|----------------|
| info_form_status | `initialized` |
| info_form_intern_status | `initialized` |
| info_form_company_status | `initialized` |
| info_form_organization_status | `initialized` |

---

## 🧪 Test 1 : Validation du volet STAGIAIRE (InternProcessor)

### Route API Platform

```
PATCH /api/intern/infoForm/101/infoFormIntern/validation
```

### Headers

```json
{
    "Content-Type": "application/ld+json",
    "Authorization": "Bearer {token_stagiaire}"
}
```

### Body JSON

```json
{
    "infoFormInternStatus": "validated"
}
```

**Note:** Le statut `infoFormStatus` est automatiquement changé à `completed_intern` par le processor.

### Vérification SQL après requête

```sql
SELECT
    `if`.status AS info_form_status,
    ifi.status AS info_form_intern_status,
    ifc.status AS info_form_company_status,
    ifo.status AS info_form_organization_status
FROM info_form `if`
LEFT JOIN info_form_intern ifi ON `if`.info_form_intern_id = ifi.id
LEFT JOIN info_form_company ifc ON `if`.info_form_company_id = ifc.id
LEFT JOIN info_form_organization ifo ON `if`.info_form_organization_id = ifo.id
WHERE `if`.id = 101;
```

### Résultats attendus

#### Statuts en BDD

| Column                        | Valeur attendue                           |
| ----------------------------- | ----------------------------------------- |
| info_form_status              | `completed_intern`                        |
| info_form_intern_status       | `validated`                               |
| info_form_company_status      | **`pending`** ⚠️ (changement automatique) |
| info_form_organization_status | `initialized`                             |

#### Emails envoyés

1. **À l'organisme** : "Le stagiaire X a validé son volet"
2. **Au contact entreprise** :
    - **CAS A** (email existe) : "Notification - Nouvelle demande de stage"
    - **CAS B** (email n'existe pas) : "Invitation à remplir le formulaire entreprise"

---

## 🧪 Test 2 : ENTREPRISE - CAS A (Email existe dans User, CompanyMember lié)

**Scénario :** L'email du contact entreprise correspond à un User existant qui a déjà un CompanyMember. Le système doit simplement lier le CompanyMember existant à ce nouveau dossier.

### Préparation SQL

```sql
-- Vérifier qu'un User avec email 'tuteurfacebook@gmail.com' existe
SELECT u.id, u.email, u.first_name, u.last_name, cm.id AS company_member_id, cm.company_id
FROM user u
LEFT JOIN company_member cm ON cm.user_id = u.id
WHERE u.email = 'tuteurfacebook@gmail.com';

-- Résultat attendu : User ID=18, CompanyMember ID=1, Company ID=1 (Meta)

-- Mettre l'email de ce user dans info_form_intern_company du dossier 101
UPDATE info_form_intern_company
SET email = 'tuteurfacebook@gmail.com'
WHERE id = 101;
```

### Route API Platform

```
PATCH /api/company/infoForm/101/infoFormCompany/validation
```

### Headers

```json
{
    "Content-Type": "application/ld+json",
    "Authorization": "Bearer {token_entreprise}"
}
```

### Body JSON

```json
{
    "siret": "82341567800012",
    "name": "Meta",
    "address": "10 Rue de la Tech, 75001 Paris, France",
    "phoneNumber": "0145678912",
    "infoFormCompanyStatus": "validated"
}
```

### Vérification SQL après requête

```sql
-- Vérifier les statuts
SELECT
    `if`.status AS info_form_status,
    ifi.status AS info_form_intern_status,
    ifc.status AS info_form_company_status,
    ifo.status AS info_form_organization_status
FROM info_form `if`
LEFT JOIN info_form_intern ifi ON `if`.info_form_intern_id = ifi.id
LEFT JOIN info_form_company ifc ON `if`.info_form_company_id = ifc.id
LEFT JOIN info_form_organization ifo ON `if`.info_form_organization_id = ifo.id
WHERE `if`.id = 101;

-- Vérifier le lien CompanyMember → InfoForm
SELECT cm.id, cm.user_id, cm.company_id, cmif.info_form_id
FROM company_member cm
LEFT JOIN company_member_info_form cmif ON cmif.company_member_id = cm.id
WHERE cm.id = 1 AND cmif.info_form_id = 101;
```

### Résultats attendus

#### CAS A : User/CompanyMember existant

| Vérification                                | Résultat attendu                                        |
| ------------------------------------------- | ------------------------------------------------------- |
| info_form_status                            | `completed_company`                                     |
| info_form_company_status                    | `validated`                                             |
| info_form_organization_status               | `pending`                                               |
| **AUCUN nouvel User créé**                  | ✅ User ID=18 réutilisé                                 |
| **AUCUN nouveau CompanyMember créé**        | ✅ CompanyMember ID=1 réutilisé                         |
| **Lien company_member_info_form créé**      | ✅ company_member_id=1, info_form_id=101                |
| **Email "Notification - Nouvelle demande"** | ✅ Envoyé à tuteurfacebook@gmail.com (CAS A)            |
| **Email à l'organisme**                     | ✅ Envoyé aux OrganizationMembers de la TrainingSession |
| **Email au stagiaire**                      | ✅ Envoyé "L'entreprise a validé"                       |

---

## 🧪 Test 3 : ENTREPRISE - CAS B1 (SIRET existe, email n'existe pas)

**Scénario :** Le SIRET correspond à une Company existante, mais l'email du contact n'existe pas dans User. Le système doit créer un nouveau User et un nouveau CompanyMember pour cette Company.

### Préparation SQL

```sql
-- Vérifier qu'une Company avec SIRET '82341567800023' existe (Apple)
SELECT id, siret, name FROM company WHERE siret = '82341567800023';
-- Résultat attendu : Company ID=2, name='Apple'

-- Mettre un email qui n'existe PAS dans User
UPDATE info_form_intern_company
SET email = 'nouveau.contact@apple.com',
    legal_representative_first_name = 'Jean',
    legal_representative_last_name = 'Nouveau'
WHERE id = 101;

-- Vérifier que cet email n'existe pas
SELECT id FROM user WHERE email = 'nouveau.contact@apple.com';
-- Résultat attendu : aucun résultat
```

### Route API Platform

```
PATCH /api/company/infoForm/101/infoFormCompany/validation
```

### Headers

```json
{
    "Content-Type": "application/ld+json",
    "Authorization": "Bearer {token_entreprise}"
}
```

### Body JSON

```json
{
    "siret": "82341567800023",
    "name": "Apple",
    "address": "20 Avenue des Pommes, 75002 Paris, France",
    "phoneNumber": "0145678913",
    "infoFormCompanyStatus": "validated"
}
```

### Vérification SQL après requête

```sql
-- Vérifier les statuts
SELECT
    `if`.status AS info_form_status,
    ifi.status AS info_form_intern_status,
    ifc.status AS info_form_company_status,
    ifo.status AS info_form_organization_status
FROM info_form `if`
LEFT JOIN info_form_intern ifi ON `if`.info_form_intern_id = ifi.id
LEFT JOIN info_form_company ifc ON `if`.info_form_company_id = ifc.id
LEFT JOIN info_form_organization ifo ON `if`.info_form_organization_id = ifo.id
WHERE `if`.id = 101;

-- Vérifier que le User a été créé
SELECT id, email, first_name, last_name, role, password
FROM user
WHERE email = 'nouveau.contact@apple.com';

-- Vérifier que le CompanyMember a été créé et lié à Company ID=2 (Apple)
SELECT cm.id, cm.user_id, cm.company_id, c.name AS company_name
FROM company_member cm
JOIN user u ON u.id = cm.user_id
JOIN company c ON c.id = cm.company_id
WHERE u.email = 'nouveau.contact@apple.com';

-- Vérifier le lien avec InfoForm
SELECT cmif.company_member_id, cmif.info_form_id
FROM company_member_info_form cmif
JOIN company_member cm ON cm.id = cmif.company_member_id
JOIN user u ON u.id = cm.user_id
WHERE u.email = 'nouveau.contact@apple.com' AND cmif.info_form_id = 101;
```

### Résultats attendus

#### CAS B1 : Company existante, nouveau User

| Vérification                           | Résultat attendu                                          |
| -------------------------------------- | --------------------------------------------------------- |
| info_form_status                       | `completed_company`                                       |
| info_form_company_status               | `validated`                                               |
| info_form_organization_status          | `pending`                                                 |
| **Company existante réutilisée**       | ✅ Company ID=2 (Apple) non modifiée                      |
| **Nouveau User créé**                  | ✅ email='nouveau.contact@apple.com', role='COMPANY'      |
| **Mot de passe temporaire généré**     | ✅ password=bin2hex(random_bytes(16)) - 32 caractères hex |
| **Nouveau CompanyMember créé**         | ✅ Lié à User créé + Company ID=2                         |
| **Lien company_member_info_form créé** | ✅ company_member_id={nouveau}, info_form_id=101          |
| **Email "Activez votre compte"**       | ✅ Envoyé à nouveau.contact@apple.com (CAS B1)            |
| **Email à l'organisme**                | ✅ Envoyé aux OrganizationMembers de la TrainingSession   |
| **Email au stagiaire**                 | ✅ Envoyé "L'entreprise a validé"                         |

---

## 🧪 Test 4 : ENTREPRISE - CAS B2 (SIRET n'existe pas, nouvelle Company)

**Scénario :** Le SIRET n'existe pas dans Company. Le système doit créer une nouvelle Company, un nouveau User et un nouveau CompanyMember.

### Préparation SQL

```sql
-- Vérifier qu'un SIRET n'existe PAS
SELECT id FROM company WHERE siret = '99999999900099';
-- Résultat attendu : aucun résultat

-- Mettre les données de la nouvelle entreprise
UPDATE info_form_intern_company
SET email = 'directeur@nouvelleentreprise.fr',
    company_name = 'Nouvelle Entreprise SAS',
    legal_representative_first_name = 'Pierre',
    legal_representative_last_name = 'Directeur'
WHERE id = 101;

-- Vérifier que cet email n'existe pas
SELECT id FROM user WHERE email = 'directeur@nouvelleentreprise.fr';
-- Résultat attendu : aucun résultat
```

### Route API Platform

```
PATCH /api/company/infoForm/101/infoFormCompany/validation
```

### Headers

```json
{
    "Content-Type": "application/ld+json",
    "Authorization": "Bearer {token_entreprise}"
}
```

### Body JSON

```json
{
    "siret": "99999999900099",
    "name": "Nouvelle Entreprise SAS",
    "address": "100 Rue de l'Innovation, 75015 Paris, France",
    "phoneNumber": "0199887766",
    "infoFormCompanyStatus": "validated"
}
```

### Vérification SQL après requête

```sql
-- Vérifier les statuts
SELECT
    `if`.status AS info_form_status,
    ifi.status AS info_form_intern_status,
    ifc.status AS info_form_company_status,
    ifo.status AS info_form_organization_status
FROM info_form `if`
LEFT JOIN info_form_intern ifi ON `if`.info_form_intern_id = ifi.id
LEFT JOIN info_form_company ifc ON `if`.info_form_company_id = ifc.id
LEFT JOIN info_form_organization ifo ON `if`.info_form_organization_id = ifo.id
WHERE `if`.id = 101;

-- Vérifier que la Company a été créée
SELECT id, siret, name, address, phone_number
FROM company
WHERE siret = '99999999900099';

-- Vérifier que le User a été créé
SELECT id, email, first_name, last_name, role, password
FROM user
WHERE email = 'directeur@nouvelleentreprise.fr';

-- Vérifier que le CompanyMember a été créé
SELECT cm.id, cm.user_id, cm.company_id, c.siret AS company_siret, c.name AS company_name
FROM company_member cm
JOIN user u ON u.id = cm.user_id
JOIN company c ON c.id = cm.company_id
WHERE u.email = 'directeur@nouvelleentreprise.fr';

-- Vérifier le lien avec InfoForm
SELECT cmif.company_member_id, cmif.info_form_id
FROM company_member_info_form cmif
JOIN company_member cm ON cm.id = cmif.company_member_id
JOIN user u ON u.id = cm.user_id
WHERE u.email = 'directeur@nouvelleentreprise.fr' AND cmif.info_form_id = 101;
```

### Résultats attendus

#### CAS B2 : Nouvelle Company

| Vérification                           | Résultat attendu                                           |
| -------------------------------------- | ---------------------------------------------------------- |
| info_form_status                       | `completed_company`                                        |
| info_form_company_status               | `validated`                                                |
| info_form_organization_status          | `pending`                                                  |
| **Nouvelle Company créée**             | ✅ siret='99999999900099', name='Nouvelle Entreprise SAS'  |
| **Nouveau User créé**                  | ✅ email='directeur@nouvelleentreprise.fr', role='COMPANY' |
| **Mot de passe temporaire généré**     | ✅ password=bin2hex(random_bytes(16)) - 32 caractères hex  |
| **Nouveau CompanyMember créé**         | ✅ Lié à User créé + Company créée                         |
| **Lien company_member_info_form créé** | ✅ company_member_id={nouveau}, info_form_id=101           |
| **Email "Bienvenue sur EasyPAE"**      | ✅ Envoyé à directeur@nouvelleentreprise.fr (CAS B2)       |
| **Email à l'organisme**                | ✅ Envoyé aux OrganizationMembers de la TrainingSession    |
| **Email au stagiaire**                 | ✅ Envoyé "L'entreprise a validé"                          |

---

## 🧪 Test 5 : Édition du formulaire ENTREPRISE (CompanyProcessor - EDIT)

**⚠️ NOTE :** Ce test est OPTIONNEL. La route EDIT sert uniquement à sauvegarder des données intermédiaires du formulaire, sans créer d'entités ni envoyer d'emails.

### Route API Platform

```
PATCH /api/company/infoForm/101/infoFormCompany
```

### Headers

```json
{
    "Content-Type": "application/ld+json",
    "Authorization": "Bearer {token_entreprise}"
}
```

### Body JSON

```json
{
    "activity": "Développement informatique",
    "fax": "0123456788",
    "legalRepresentativeFirstName": "Jean",
    "legalRepresentativeLastName": "Dupont",
    "legalRepresentativeEmail": "jean.dupont@entreprise-test.fr",
    "tutorFirstName": "Marie",
    "tutorLastName": "Martin",
    "tutorEmail": "marie.martin@entreprise-test.fr",
    "tutorPhoneNumber": "0612345678"
}
```

**⚠️ IMPORTANT :** Ne PAS envoyer `siret`, `name`, `address`, `phoneNumber` lors de l'édition. Ces données seront fournies lors de la validation (Test 3).

### Vérification SQL après requête

```sql
SELECT
    `if`.status AS info_form_status,
    ifi.status AS info_form_intern_status,
    ifc.status AS info_form_company_status,
    ifo.status AS info_form_organization_status,
    ifc.activity,
    ifc.fax,
    ifc.legal_representative_first_name,
    ifc.tutor_first_name
FROM info_form `if`
LEFT JOIN info_form_intern ifi ON `if`.info_form_intern_id = ifi.id
LEFT JOIN info_form_company ifc ON `if`.info_form_company_id = ifc.id
LEFT JOIN info_form_organization ifo ON `if`.info_form_organization_id = ifo.id
WHERE `if`.id = 101;
```

### Résultats attendus

#### Statuts en BDD (AUCUN CHANGEMENT)

| Column                        | Valeur attendue    |
| ----------------------------- | ------------------ |
| info_form_status              | `completed_intern` |
| info_form_intern_status       | `validated`        |
| info_form_company_status      | `pending`          |
| info_form_organization_status | `initialized`      |

#### Données InfoFormCompany

| Column                          | Valeur attendue              |
| ------------------------------- | ---------------------------- |
| activity                        | `Développement informatique` |
| fax                             | `0123456788`                 |
| legal_representative_first_name | `Jean`                       |
| tutor_first_name                | `Marie`                      |

#### Emails envoyés

❌ **AUCUN email** (simple sauvegarde du formulaire)

---

## 🧪 Test 3 : Validation du volet ENTREPRISE (CompanyProcessor - VALIDATION)

### Route API Platform

```
PATCH /api/company/infoForm/101/infoFormCompany/validation
```

### Headers

```json
{
    "Content-Type": "application/ld+json",
    "Authorization": "Bearer {token_entreprise}"
}
```

### Body JSON

```json
{
    "siret": "12345678901234",
    "name": "Entreprise Test",
    "address": "123 Rue de Test, 75001 Paris",
    "phoneNumber": "0123456789",
    "infoFormCompanyStatus": "validated"
}
```

**⚠️ C'EST ICI** qu'on envoie le SIRET et les données de l'entreprise. Cette route va :

-   Vérifier si l'entreprise existe (CAS B1) ou la créer (CAS B2)
-   Créer le User avec un mot de passe temporaire : `bin2hex(random_bytes(16))`
-   Créer le CompanyMember
-   Envoyer les emails
-   Changer le status de l'InfoForm à `COMPLETED_COMPANY_VALIDATION`

### Vérification SQL après requête

```sql
SELECT
    `if`.status AS info_form_status,
    ifi.status AS info_form_intern_status,
    ifc.status AS info_form_company_status,
    ifo.status AS info_form_organization_status
FROM info_form `if`
LEFT JOIN info_form_intern ifi ON `if`.info_form_intern_id = ifi.id
LEFT JOIN info_form_company ifc ON `if`.info_form_company_id = ifc.id
LEFT JOIN info_form_organization ifo ON `if`.info_form_organization_id = ifo.id
WHERE `if`.id = 101;
```

### Vérification création Company/User/CompanyMember

```sql
-- Vérifier si Company a été créée avec le SIRET
SELECT id, siret, name, address FROM company WHERE siret = '12345678901234';

-- Vérifier si User entreprise a été créé
SELECT id, email, first_name, last_name, role FROM user WHERE email = 'jean.dupont@entreprise-test.fr';

-- Vérifier si CompanyMember a été créé et lié
SELECT
    cm.id,
    cm.user_id,
    cm.company_id,
    cm.role,
    u.email AS user_email,
    c.siret AS company_siret
FROM company_member cm
JOIN user u ON u.id = cm.user_id
JOIN company c ON c.id = cm.company_id
WHERE u.email = 'jean.dupont@entreprise-test.fr';

-- Vérifier le lien avec InfoForm
SELECT info_form_id
FROM company_member_info_form
WHERE company_member_id = (
    SELECT cm.id FROM company_member cm
    JOIN user u ON u.id = cm.user_id
    WHERE u.email = 'jean.dupont@entreprise-test.fr'
);
```

### Résultats attendus

#### Statuts en BDD

| Column                        | Valeur attendue                           |
| ----------------------------- | ----------------------------------------- |
| info_form_status              | `completed_company`                       |
| info_form_intern_status       | `validated`                               |
| info_form_company_status      | `validated`                               |
| info_form_organization_status | **`pending`** ⚠️ (changement automatique) |

#### Entités créées

-   ✅ **Company** créée avec SIRET `12345678901234` (CAS B2) OU rattachée si existe (CAS B1)
-   ✅ **User** créé avec email `jean.dupont@entreprise-test.fr` et role `COMPANY`
-   ✅ **CompanyMember** créé et lié à Company et User
-   ✅ Lien dans `company_member_info_form` avec `info_form_id = 101`

#### Emails envoyés

1. **Au stagiaire** : "L'entreprise a validé votre demande de stage"
2. **À l'organisme** : "Le dossier de X est prêt à être signé"
3. **À l'entreprise** (selon cas) :
    - **CAS B1** : "Activez votre compte" (entreprise existe)
    - **CAS B2** : "Bienvenue sur EasyPAE" (nouvelle entreprise)

---

## 🧪 Test 6 : Signature du PAE par l'ORGANISME (OrganizationProcessor)

### Route API Platform

```
PATCH /api/organization/infoForm/101/sign
```

### Headers

```json
{
    "Content-Type": "application/ld+json",
    "Authorization": "Bearer {token_organisme}"
}
```

### Body JSON

```json
{
    "signature": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUA...",
    "validationDate": "2025-10-30T14:30:00+00:00"
}
```

### Vérification SQL après requête

```sql
SELECT
    `if`.status AS info_form_status,
    ifi.status AS info_form_intern_status,
    ifc.status AS info_form_company_status,
    ifo.status AS info_form_organization_status,
    ifo.signature,
    ifo.validation_date
FROM info_form `if`
LEFT JOIN info_form_intern ifi ON `if`.info_form_intern_id = ifi.id
LEFT JOIN info_form_company ifc ON `if`.info_form_company_id = ifc.id
LEFT JOIN info_form_organization ifo ON `if`.info_form_organization_id = ifo.id
WHERE `if`.id = 101;
```

### Résultats attendus

#### Statuts en BDD

| Column                        | Valeur attendue                                   |
| ----------------------------- | ------------------------------------------------- |
| info_form_status              | **`fully_completed`** ⚠️ (changement automatique) |
| info_form_intern_status       | `validated`                                       |
| info_form_company_status      | `validated`                                       |
| info_form_organization_status | **`validated`**                                   |

#### Données InfoFormOrganization

| Column          | Valeur attendue                                         |
| --------------- | ------------------------------------------------------- |
| signature       | `data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUA...` |
| validation_date | `2025-10-30 14:30:00`                                   |

#### Emails envoyés

1. **Au stagiaire** : "🎉 Votre PAE est validé"
2. **À l'entreprise** : "Le PAE de X est validé par l'organisme"

---

## 📊 Vérification finale - Statuts complets

### SQL - État final du dossier 101

```sql
SELECT
    `if`.id AS info_form_id,
    `if`.status AS info_form_status,
    ifi.status AS info_form_intern_status,
    ifc.status AS info_form_company_status,
    ifo.status AS info_form_organization_status,
    ifo.signature IS NOT NULL AS has_signature,
    ifo.validation_date
FROM info_form `if`
LEFT JOIN info_form_intern ifi ON `if`.info_form_intern_id = ifi.id
LEFT JOIN info_form_company ifc ON `if`.info_form_company_id = ifc.id
LEFT JOIN info_form_organization ifo ON `if`.info_form_organization_id = ifo.id
WHERE `if`.id = 101;
```

### État final attendu

| Column                        | Valeur finale        |
| ----------------------------- | -------------------- |
| info_form_status              | `fully_completed` ✅ |
| info_form_intern_status       | `validated` ✅       |
| info_form_company_status      | `validated` ✅       |
| info_form_organization_status | `validated` ✅       |
| has_signature                 | `1` (true) ✅        |
| validation_date               | Date de signature ✅ |

---

## 🎯 Checklist complète des tests

-   [ ] **Test 0** : Réinitialisation des statuts (tous `initialized`)
-   [ ] **Test 1** : Validation stagiaire → `info_form_company_status` passe à `pending`
-   [ ] **Test 1** : Email envoyé à l'organisme ✉️
-   [ ] **Test 1** : Email envoyé au contact entreprise (CAS A ou B) ✉️
-   [ ] **Test 2** : Édition formulaire entreprise → Données sauvegardées, aucun changement de statut
-   [ ] **Test 2** : Aucun email envoyé
-   [ ] **Test 3** : Validation entreprise → `info_form_organization_status` passe à `pending`
-   [ ] **Test 3** : Création/rattachement Company avec SIRET ✅
-   [ ] **Test 3** : Création User entreprise ✅
-   [ ] **Test 3** : Création CompanyMember ✅
-   [ ] **Test 3** : Email au stagiaire ✉️
-   [ ] **Test 3** : Email à l'organisme ✉️
-   [ ] **Test 3** : Email d'activation à l'entreprise ✉️
-   [ ] **Test 4** : Signature organisme → `info_form_status` passe à `fully_completed`
-   [ ] **Test 4** : `info_form_organization_status` passe à `validated`
-   [ ] **Test 4** : Email au stagiaire ✉️
-   [ ] **Test 4** : Email à l'entreprise ✉️
-   [ ] **Vérification finale** : Tous les statuts sont `validated` sauf `info_form_status` qui est `fully_completed`

---

## 🐛 Points d'attention / Debug

### Vérifier les logs d'emails

```bash
# Symfony Mailer logs
tail -f var/log/dev.log | grep -i "email\|mailer"
```

### Vérifier les erreurs API Platform

```bash
# Logs d'erreurs
tail -f var/log/dev.log | grep -i "error\|exception"
```

### Tester avec un client HTTP (Postman/Insomnia/curl)

#### Exemple avec curl - Test 1

```bash
curl -X PATCH "http://localhost:8000/api/intern/infoForm/101/infoFormIntern/validation" \
  -H "Content-Type: application/ld+json" \
  -H "Authorization: Bearer {token_stagiaire}" \
  -d '{
    "infoFormInternStatus": "validated"
  }'
```

#### Exemple avec curl - Test 3

```bash
curl -X PATCH "http://localhost:8000/api/company/infoForm/101/infoFormCompany/validation" \
  -H "Content-Type: application/ld+json" \
  -H "Authorization: Bearer {token_entreprise}" \
  -d '{
    "infoFormCompanyStatus": "validated"
  }'
```

---

## 📧 Emails attendus - Récapitulatif

| Étape                          | Destinataire               | Objet                                | Template                                        |
| ------------------------------ | -------------------------- | ------------------------------------ | ----------------------------------------------- |
| Test 1 - Validation stagiaire  | Organisme                  | "Le stagiaire X a validé son volet"  | `organization_intern_validated.html.twig`       |
| Test 1 - CAS A                 | Entreprise (existante)     | "Nouvelle demande de stage"          | `company_notification_existing_user.html.twig`  |
| Test 1 - CAS B                 | Entreprise (nouvelle)      | "Invitation à remplir le formulaire" | `company_activation_new_company.html.twig`      |
| Test 3 - Validation entreprise | Stagiaire                  | "L'entreprise a validé"              | `intern_company_validated.html.twig`            |
| Test 3 - Validation entreprise | Organisme                  | "Dossier prêt à être signé"          | `organization_company_validated.html.twig`      |
| Test 3 - CAS B1                | Entreprise (SIRET existe)  | "Activez votre compte"               | `company_activation_existing_company.html.twig` |
| Test 3 - CAS B2                | Entreprise (nouveau SIRET) | "Bienvenue sur EasyPAE"              | `company_activation_new_company.html.twig`      |
| Test 4 - Signature organisme   | Stagiaire                  | "🎉 Votre PAE est validé"            | `intern_pae_completed.html.twig`                |
| Test 4 - Signature organisme   | Entreprise                 | "PAE validé par l'organisme"         | `company_pae_completed.html.twig`               |

**Total : 9 emails possibles** (selon les cas CAS A/B1/B2)
