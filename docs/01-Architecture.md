# 01 – Architecture de CDG Studio

## Objectif

CDG Studio est conçu comme un framework modulaire destiné à héberger les différentes fonctionnalités métier de Cap Digital Gestion.

Le Framework fournit les services techniques communs.

Les modules apportent les fonctionnalités métier.

Cette séparation permet de faire évoluer les fonctionnalités sans modifier le cœur du Framework.

---

# Vue d'ensemble

```
                    WordPress
                         │
                         ▼
                 cdg-studio.php
                         │
                         ▼
                     Plugin
                         │
                         ▼
                     Loader
                         │
                         ▼
                  Application
                         │
        ┌────────────────┴────────────────┐
        │                                 │
        ▼                                 ▼
 Service Providers                 Module Registry
        │                                 │
        ▼                                 ▼
     Container                     Module Loader
        │                                 │
        └──────────────┬──────────────────┘
                       ▼
                    Modules
```

---

# Les différentes couches

## Core

Le dossier **Core** contient le cœur du Framework.

Il orchestre le cycle de vie de l'application.

Il ne contient aucune logique métier.

Responsabilités :

- démarrage du Framework
- configuration
- chargement des modules
- initialisation des services

---

## Providers

Les Providers enregistrent les services dans le Container.

Ils centralisent toute la configuration technique.

Exemples :

- ConfigManager
- Logger
- EventDispatcher
- Cache
- SettingsManager

---

## Support

Le dossier **Support** contient les composants techniques réutilisables.

Ils encapsulent les fonctionnalités communes.

Exemples :

- Container
- Logger
- Cache
- HookManager
- EventDispatcher

Ces composants ne contiennent aucune logique métier.

---

## Contracts

Le dossier **Contracts** contient les interfaces.

Les interfaces définissent les comportements attendus.

Le Framework dépend des interfaces.

Les implémentations restent interchangeables.

---

## Events

Les événements permettent aux composants de communiquer sans dépendance directe.

Le Framework privilégie une architecture orientée événements.

Les modules ne doivent jamais s'appeler directement.

---

## Exceptions

Toutes les exceptions spécifiques au Framework sont regroupées dans ce dossier.

Elles permettent :

- une meilleure lisibilité ;
- une gestion fine des erreurs ;
- une documentation plus claire.

---

## Modules

Les modules représentent les fonctionnalités métier.

Chaque module est indépendant.

Structure type :

```
Module
│
├── Controller
├── Repository
├── Service
├── Assets
└── Views
```

Chaque module possède une seule responsabilité métier.

---

## Services

Le dossier **Services** accueille les services réutilisables qui ne sont pas directement liés au fonctionnement du Framework.

Ils peuvent être utilisés par plusieurs modules.

---

## Helpers

Fonctions utilitaires génériques.

Aucune logique métier.

---

## Http

Ce dossier regroupe les composants liés aux échanges HTTP.

Exemples :

- Request
- Response
- API
- REST

---

# Dépendances autorisées

Le sens des dépendances est strictement défini.

```
Modules
      │
      ▼
Framework
      │
      ▼
WordPress
```

Le Framework ne dépend jamais des modules.

Les modules ne dépendent jamais les uns des autres.

---

# Communication entre modules

Les modules communiquent uniquement par :

- EventDispatcher
- Services communs
- Container

Les appels directs entre modules sont interdits.

---

# Objectifs de cette architecture

Cette architecture vise à garantir :

- une forte modularité ;
- une maintenance simplifiée ;
- un faible couplage ;
- une grande évolutivité ;
- une excellente lisibilité.

Le Framework évolue lentement.

Les modules évoluent rapidement.

---

# Philosophie

Le Framework fournit des capacités.

Les modules apportent les fonctionnalités.

Le cœur du Framework doit rester stable, compact et indépendant des besoins métier.

Toute évolution du Framework doit respecter les principes définis dans **00-Architecture-Principles.md**.