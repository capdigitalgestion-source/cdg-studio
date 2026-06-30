# 10 – Conventions de développement

## Objectif

Ce document définit les conventions de développement de CDG Studio.

Elles garantissent :

- une architecture cohérente ;
- une excellente lisibilité ;
- une maintenance simplifiée ;
- une évolution durable du Framework.

Ces conventions s'appliquent à tous les développements.

---

# Convention n°1 — Une responsabilité par classe

Chaque classe possède une responsabilité unique.

Exemple :

- Controller
- Service
- Repository
- Provider
- Event

Une classe qui remplit plusieurs rôles doit être découpée.

---

# Convention n°2 — Les modules sont indépendants

Aucun module ne dépend directement d'un autre.

Communication autorisée :

- EventDispatcher
- Services communs
- Container

Les appels directs entre modules sont interdits.

---

# Convention n°3 — Le Framework reste générique

Le Framework ne contient jamais de logique métier.

Le Framework fournit :

- des services ;
- des composants techniques ;
- des outils.

Les fonctionnalités métier appartiennent exclusivement aux modules.

---

# Convention n°4 — Les Controllers restent légers

Un Controller :

- reçoit une action ;
- prépare les données ;
- délègue le traitement.

Il ne contient jamais la logique métier.

---

# Convention n°5 — La logique métier appartient aux Services

Toutes les règles métier sont implémentées dans les Services.

Les Services peuvent utiliser :

- Repository
- Cache
- Logger
- Settings
- EventDispatcher

---

# Convention n°6 — Les Repository accèdent aux données

Les Repository sont les seuls responsables :

- des requêtes SQL ;
- des appels WordPress liés aux données ;
- des lectures ;
- des écritures.

Ils ne contiennent aucune logique métier.

---

# Convention n°7 — Utiliser les services du Framework

Les composants suivants doivent être utilisés :

- Logger
- Cache
- SettingsManager
- HookManager
- EventDispatcher

Éviter autant que possible les appels directs aux fonctions natives de WordPress lorsqu'un service du Framework existe.

---

# Convention n°8 — Respecter les namespaces

Chaque classe appartient à un namespace cohérent.

Exemple :

CDGStudio\Core

CDGStudio\Support

CDGStudio\Modules\CRM

Les namespaces reflètent l'organisation des dossiers.

---

# Convention n°9 — Respecter PSR-12

Le code suit les recommandations PSR-12 :

- indentation de quatre espaces ;
- accolades sur une nouvelle ligne ;
- typage strict ;
- imports explicites ;
- noms explicites.

---

# Convention n°10 — Favoriser la lisibilité

La lisibilité est prioritaire.

Préférer :

- des méthodes courtes ;
- des noms explicites ;
- des responsabilités clairement séparées.

Éviter les méthodes de plusieurs centaines de lignes.

---

# Convention n°11 — Documenter le code

Les composants importants doivent être documentés.

La documentation explique :

- le rôle de la classe ;
- sa responsabilité ;
- son fonctionnement général.

Elle ne doit pas paraphraser le code.

---

# Convention n°12 — Journaliser les erreurs importantes

Les erreurs significatives doivent être enregistrées via le Logger.

Ne jamais utiliser :

```php
var_dump();

print_r();

echo;
```

pour le débogage permanent.

---

# Convention n°13 — Préserver la rétrocompatibilité

Toute évolution du Framework doit limiter les impacts sur les modules existants.

Les changements incompatibles doivent être exceptionnels et documentés.

---

# Convention n°14 — Le Framework évolue lentement

Le Framework constitue le socle technique.

Il évolue de manière maîtrisée.

Les modules évoluent plus rapidement.

---

# Convention n°15 — Respecter les principes d'architecture

Toute nouvelle classe doit respecter :

- les 11 principes d'architecture ;
- les conventions de ce document.

En cas de doute, privilégier la solution la plus simple, la plus lisible et la plus durable.

---

# Philosophie

La qualité du Framework ne dépend pas uniquement du code.

Elle dépend surtout de la cohérence des décisions prises dans le temps.

Ces conventions constituent le cadre de référence pour tous les développements futurs de CDG Studio.
