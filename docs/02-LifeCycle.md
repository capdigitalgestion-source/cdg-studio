# 02 – Cycle de vie du Framework

## Objectif

Ce document décrit précisément le cycle de vie de CDG Studio depuis le chargement du plugin par WordPress jusqu'à l'initialisation complète des modules.

Comprendre ce cycle est indispensable pour développer ou faire évoluer le Framework.

---

# Vue d'ensemble

```text
WordPress
    │
    ▼
cdg-studio.php
    │
    ▼
Plugin::boot()
    │
    ▼
Loader
    │
    ▼
Application
    │
    ▼
Service Providers
    │
    ▼
Container
    │
    ▼
Module Registry
    │
    ▼
Module Loader
    │
    ▼
Modules
```

---

# Étape 1 – Chargement du plugin

WordPress charge le fichier :

```
cdg-studio.php
```

Ce fichier :

- vérifie que WordPress est chargé ;
- définit les constantes globales ;
- charge Composer ;
- démarre le Framework.

---

# Étape 2 – Plugin

Le point d'entrée est :

```php
Plugin::boot();
```

La classe `Plugin` ne contient aucune logique métier.

Elle délègue simplement le démarrage au `Loader`.

---

# Étape 3 – Loader

Le `Loader` crée une instance de :

```
Application
```

Il ne possède qu'une responsabilité :

initialiser le cœur du Framework.

---

# Étape 4 – Application

L'Application est le chef d'orchestre du Framework.

Elle :

- crée le Container ;
- crée le ModuleLoader ;
- enregistre les Service Providers ;
- initialise les modules.

Elle ne contient aucune logique métier.

---

# Étape 5 – Service Providers

Les Providers enregistrent les services du Framework.

Exemples :

- ConfigManager
- Logger
- EventDispatcher
- Cache
- SettingsManager
- HookManager

Chaque Provider est responsable d'un domaine technique.

---

# Étape 6 – Container

Le Container centralise toutes les dépendances.

Les composants du Framework ne créent jamais directement leurs dépendances.

Ils les récupèrent via le Container.

Exemple :

```php
$this->container->get('logger');
```

---

# Étape 7 – Module Registry

Le Module Registry référence tous les modules disponibles.

Il constitue la liste officielle des modules du Framework.

Exemple :

```php
return [

    DashboardModule::class,

];
```

---

# Étape 8 – Module Loader

Le ModuleLoader :

- instancie les modules ;
- appelle leur méthode `register()`;
- puis leur méthode `boot()`.

Ordre d'exécution :

```text
register()

↓

boot()
```

Tous les modules suivent ce cycle.

---

# Étape 9 – Modules

Chaque module est autonome.

Structure :

```text
Dashboard/

    DashboardModule

    DashboardController

    DashboardRepository

    DashboardService
```

Le module reçoit les services du Framework via l'AbstractModule.

---

# Cycle complet

```text
WordPress

↓

Plugin

↓

Loader

↓

Application

↓

Providers

↓

Container

↓

Module Registry

↓

Module Loader

↓

Modules

↓

Application prête
```

---

# Bonnes pratiques

Le Framework démarre toujours avant les modules.

Les modules ne créent jamais leurs dépendances eux-mêmes.

Les modules ne connaissent jamais les autres modules.

Le Framework reste indépendant des fonctionnalités métier.

---

# Évolutions prévues

Les prochaines versions du Framework pourront ajouter des événements de cycle de vie.

Exemples :

- FrameworkBooting
- FrameworkBooted
- ModuleRegistering
- ModuleRegistered
- ModuleBooting
- ModuleBooted

Ces événements permettront aux modules d'interagir avec le Framework sans créer de dépendances directes.

---

# Conclusion

Le cycle de vie de CDG Studio est volontairement simple.

Chaque étape possède une responsabilité clairement définie.

Cette organisation garantit :

- un faible couplage ;
- une excellente lisibilité ;
- une grande évolutivité ;
- une maintenance facilitée.