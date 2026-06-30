# 06 – Les Service Providers

## Objectif

Les Service Providers sont responsables de l'enregistrement des services du Framework dans le Container.

Ils constituent le point de centralisation de l'initialisation technique.

Un Provider ne contient jamais de logique métier.

---

# Rôle d'un Provider

Un Provider enregistre les composants nécessaires au fonctionnement du Framework.

Exemples :

- ConfigManager
- Logger
- Cache
- EventDispatcher
- HookManager
- SettingsManager

Leur création est centralisée afin d'assurer une architecture cohérente.

---

# Fonctionnement

Le démarrage suit le cycle suivant :

```text
Application

↓

Providers

↓

Container

↓

Services disponibles
```

Chaque Provider reçoit le Container.

Il y enregistre les services dont il est responsable.

---

# Exemple

```php
$container->set(
    'logger',
    fn () => new Logger()
);
```

ou

```php
$container->set(
    'cache',
    fn () => new Cache()
);
```

Le Provider ne crée pas les dépendances des modules.

Il enregistre uniquement les services.

---

# Provider actuel

Le Framework possède actuellement :

```
CoreServiceProvider
```

Il enregistre les services fondamentaux du Framework.

---

# Évolution prévue

Lorsque le Framework grandira, plusieurs Providers pourront coexister.

Exemple :

```text
Providers/

    CoreServiceProvider

    AdminServiceProvider

    DatabaseServiceProvider

    DashboardServiceProvider

    ApiServiceProvider
```

Chaque Provider reste responsable d'un seul domaine.

---

# Pourquoi plusieurs Providers ?

Cette organisation permet :

- une meilleure lisibilité ;
- une maintenance simplifiée ;
- une séparation claire des responsabilités.

Aucun Provider ne doit devenir une classe "fourre-tout".

---

# Ce qu'un Provider ne doit jamais faire

Un Provider ne doit pas :

- contenir de logique métier ;
- accéder directement aux données métier ;
- exécuter des traitements applicatifs.

Son unique rôle est l'enregistrement des services.

---

# Bonnes pratiques

Créer un nouveau Provider lorsque :

- plusieurs services appartiennent au même domaine ;
- la classe devient trop volumineuse ;
- une fonctionnalité technique mérite d'être isolée.

Ne pas créer un Provider pour un seul service sans raison.

---

# Dépendances

Les Providers peuvent dépendre :

- du Container ;
- de l'Application ;
- de la configuration.

Ils ne doivent jamais dépendre directement des modules métier.

---

# Philosophie

Les Providers constituent la couche d'assemblage du Framework.

Ils préparent les services nécessaires au fonctionnement de l'application tout en maintenant un faible couplage entre les composants.