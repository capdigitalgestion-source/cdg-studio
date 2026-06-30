# 00 - Principes d'architecture de CDG Studio

## Préambule

CDG Studio n'est pas seulement un plugin WordPress.

C'est un framework modulaire conçu pour héberger des applications métier destinées à Cap Digital Gestion.

Toutes les évolutions du projet doivent respecter les principes définis dans ce document.

---

# Principe 1 — Séparation des responsabilités

Chaque classe ne possède qu'une seule responsabilité.

Une classe qui remplit plusieurs rôles doit être découpée.

---

# Principe 2 — Le Framework est indépendant des modules

Le Framework ne dépend jamais d'un module.

Les modules dépendent du Framework.

Le Framework doit pouvoir fonctionner sans aucun module métier.

---

# Principe 3 — Les modules sont indépendants

Aucun module ne dépend directement d'un autre.

Les échanges passent exclusivement par :

- les événements
- les services communs
- le container

---

# Principe 4 — WordPress est encapsulé

Les fonctions natives WordPress ne doivent pas être utilisées directement dans le code métier.

Les accès passent par les composants du Framework :

- HookManager
- Cache
- SettingsManager
- Logger
- EventDispatcher

Le code métier reste ainsi indépendant de WordPress.

---

# Principe 5 — Injection de dépendances

Aucun Singleton.

Toutes les dépendances transitent par le Container.

---

# Principe 6 — Une seule source de vérité

Une information ne doit être définie qu'à un seul endroit.

Exemple :

- version
- configuration
- paramètres

---

# Principe 7 — Architecture orientée événements

Les modules communiquent par événements.

Ils ne s'appellent jamais directement.

---

# Principe 8 — Convention avant configuration

Le Framework privilégie les conventions.

Tous les modules suivent la même structure.

---

# Principe 9 — Lisibilité avant optimisation

Le code doit être compréhensible avant d'être optimisé.

Une architecture simple est préférée à une architecture complexe.

---

# Principe 10 — Évolutivité

Toute nouvelle fonctionnalité doit pouvoir être ajoutée sans modifier le cœur du Framework.

---
# Principe 11 — Le Framework reste minimal et pérenne

Le Framework ne doit contenir que des composants génériques, réutilisables et indépendants des besoins métier.

Avant d'ajouter une nouvelle classe au Framework, les questions suivantes doivent être posées :

- Cette fonctionnalité est-elle réutilisable par plusieurs modules ?
- Est-elle indépendante d'un domaine métier particulier ?
- Simplifie-t-elle réellement l'architecture ou le développement ?
- Peut-elle évoluer sans impacter les modules existants ?

Si la réponse à l'une de ces questions est négative, la classe doit rester dans le module concerné.

Le Framework n'a pas vocation à anticiper des besoins hypothétiques. Il évolue uniquement pour répondre à des besoins réels, validés et suffisamment génériques pour bénéficier à l'ensemble de la plateforme.

Le Framework doit rester compact, cohérent et stable. Toute nouvelle brique doit apporter une valeur durable et contribuer à la qualité globale de l'architecture.

# Organisation des dossiers

Core
: cœur du Framework.

Support
: composants techniques réutilisables.

Providers
: enregistrement des services.

Contracts
: interfaces.

Modules
: fonctionnalités métier.

Services
: services réutilisables.

Events
: événements du Framework.

Exceptions
: exceptions spécialisées.

Helpers
: fonctions utilitaires.

Http
: contrôleurs et requêtes HTTP.

---

# Philosophie

Le Framework constitue une plateforme stable.

Les fonctionnalités métier viennent s'y greffer sous forme de modules.

Le Framework évolue lentement.

Les modules évoluent rapidement.