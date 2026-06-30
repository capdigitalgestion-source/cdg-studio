# 04 – Développer un module

## Objectif

Les modules représentent les fonctionnalités métier de CDG Studio.

Chaque module est autonome, indépendant et ne dépend jamais directement d'un autre module.

Le Framework fournit les services techniques.

Les modules apportent les fonctionnalités.

---

# Structure officielle

Chaque module respecte obligatoirement la structure suivante.

```text
Modules/
└── NomDuModule/
    ├── NomDuModule.php
    ├── NomDuModuleController.php
    ├── NomDuModuleService.php
    ├── NomDuModuleRepository.php
    ├── Assets/
    └── Views/
```

Cette convention garantit une architecture homogène sur l'ensemble du projet.

---

# Responsabilité des classes

## Module

Point d'entrée du module.

Responsabilités :

- enregistrement du module
- démarrage
- accès aux services du Framework

Le Module ne contient jamais de logique métier.

---

## Controller

Le Controller reçoit les actions provenant :

- de WordPress
- d'une page d'administration
- d'un formulaire
- d'une API

Il prépare les données puis délègue le traitement au Service.

---

## Service

Le Service contient la logique métier.

Il orchestre les traitements.

Il peut utiliser :

- Repository
- Cache
- Logger
- EventDispatcher
- Settings

Toute règle métier appartient au Service.

---

## Repository

Le Repository gère l'accès aux données.

Il est responsable :

- des requêtes SQL
- des accès WordPress
- des lectures
- des écritures

Le Service ne doit jamais interroger directement la base de données.

---

## Assets

Contient :

- CSS
- JavaScript
- images

Uniquement les ressources propres au module.

---

## Views

Contient les fichiers d'affichage.

Aucune logique métier ne doit être présente dans les vues.

---

# Dépendances autorisées

Le sens des dépendances est strict.

```text
Controller
        │
        ▼
Service
        │
        ▼
Repository
```

Jamais l'inverse.

---

# Communication avec le Framework

Le module accède aux services du Framework via AbstractModule.

Exemple :

```php
$this->logger();

$this->config();

$this->cache();

$this->settings();

$this->events();
```

Les services sont injectés par le Framework.

---

# Communication entre modules

Les modules ne s'appellent jamais directement.

Ils communiquent uniquement :

- via les événements ;
- via des services communs ;
- via le Container lorsque cela est justifié.

Cette règle limite le couplage.

---

# Cycle de vie d'un module

Le Framework appelle successivement :

```text
register()

↓

boot()
```

Le module doit être prêt après l'exécution de `boot()`.

---

# Création d'un nouveau module

Pour créer un nouveau module :

1. créer le dossier du module ;
2. créer les quatre classes principales ;
3. ajouter les ressources dans Assets ;
4. créer les vues dans Views ;
5. enregistrer le module dans le ModuleRegistry.

Aucune autre modification du Framework n'est nécessaire.

---

# Bonnes pratiques

- Une responsabilité par classe.
- Pas de logique métier dans les Controllers.
- Pas d'accès direct à la base dans les Services.
- Pas d'appel direct entre modules.
- Réutiliser les services du Framework.

---

# Ce qu'il faut éviter

- Les classes "fourre-tout".
- Les dépendances circulaires.
- Les appels directs à WordPress lorsque le Framework fournit déjà un service.
- Les modules dépendants les uns des autres.

---

# Philosophie

Un module doit pouvoir être ajouté, mis à jour ou supprimé sans impacter le reste du Framework.

Cette indépendance constitue l'un des principes fondamentaux de CDG Studio.