# 09 – Gestion des paramètres

## Objectif

Le Framework centralise l'ensemble des paramètres persistants dans le `SettingsManager`.

Les modules ne doivent jamais appeler directement les fonctions WordPress :

- `get_option()`
- `update_option()`
- `delete_option()`

Toutes les opérations passent par le `SettingsManager`.

Cette règle garantit une architecture homogène et facilite les évolutions futures.

---

# Pourquoi un SettingsManager ?

WordPress fournit un système de gestion des options.

Cependant, appeler directement les fonctions natives :

```php
get_option()

update_option()

delete_option()
```

crée un couplage fort avec WordPress.

Le Framework encapsule ces appels afin de proposer une API unique.

---

# Lecture d'un paramètre

```php
$value = $this->settings()->get(
    'company_name'
);
```

Valeur par défaut :

```php
$value = $this->settings()->get(
    'company_name',
    'Cap Digital Gestion'
);
```

---

# Enregistrement

```php
$this->settings()->set(
    'company_name',
    'Cap Digital Gestion'
);
```

---

# Suppression

```php
$this->settings()->forget(
    'company_name'
);
```

---

# Vérification

```php
if ($this->settings()->has('company_name')) {

    // ...

}
```

---

# Préfixe

Tous les paramètres enregistrés utilisent automatiquement un préfixe.

Exemple :

```text
cdg_studio_company_name

cdg_studio_default_language

cdg_studio_dashboard_theme
```

Le développeur n'a jamais à gérer ce préfixe.

---

# Organisation

Les paramètres doivent être regroupés par domaine.

Exemples :

```text
company.*

dashboard.*

crm.*

diagnostics.*

mail.*

ai.*
```

Cette convention facilite la maintenance.

---

# Ce qui doit être stocké

Le SettingsManager est destiné à conserver :

- les préférences utilisateur ;
- les paramètres du Framework ;
- les options des modules ;
- les clés de configuration.

---

# Ce qui ne doit pas être stocké

Le SettingsManager ne doit jamais contenir :

- des données métier ;
- des statistiques ;
- des historiques ;
- des documents.

Ces données appartiennent aux modules.

---

# Bonnes pratiques

- Utiliser des noms explicites.
- Regrouper les paramètres par domaine.
- Prévoir une valeur par défaut lorsque cela est pertinent.
- Ne jamais accéder directement aux fonctions WordPress.

---

# Évolutions prévues

Le Framework pourra, à terme, proposer :

- des paramètres typés ;
- la validation automatique des valeurs ;
- l'import/export de configuration ;
- le chiffrement de certains paramètres sensibles.

Les modules resteront compatibles grâce au SettingsManager.

---

# Philosophie

Le SettingsManager constitue l'unique point d'accès aux paramètres persistants.

Il garantit une architecture cohérente, limite le couplage avec WordPress et facilite les évolutions du Framework.