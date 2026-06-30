# 11 – Roadmap du Framework

## Vision

CDG Studio est conçu comme une plateforme modulaire dédiée à l'accompagnement des entreprises dans leur organisation, leur digitalisation et le pilotage de leur activité.

Le Framework constitue un socle technique stable sur lequel viennent s'appuyer les différents modules métier.

Chaque évolution doit préserver cette philosophie.

---

# Framework v1.0

## Objectif

Mettre en place un socle technique robuste, documenté et évolutif.

### Réalisé

- Architecture modulaire
- Container
- Service Providers
- ConfigManager
- SettingsManager
- Cache
- Logger compatible PSR-3
- EventDispatcher
- HookManager
- AbstractModule
- ModuleLoader
- ModuleRegistry
- Exceptions spécialisées
- Documentation technique
- Principes d'architecture

Version destinée à servir de fondation à tous les développements futurs.

---

# Framework v1.1

## Objectif

Rendre le Framework plus intelligent.

### Évolutions envisagées

- Événements du cycle de vie du Framework
- Journalisation enrichie
- Service IDs centralisés
- Découverte automatique des modules
- Validation des configurations
- Amélioration du système de cache

---

# Framework v1.2

## Objectif

Faciliter le développement des modules.

### Évolutions envisagées

- Générateur de modules
- Console de développement
- Outils de diagnostic
- Outils de migration
- Vérification automatique des conventions
- Assistance au développement

---

# Framework v2.0

## Objectif

Transformer CDG Studio en véritable plateforme applicative.

### Évolutions envisagées

- API interne complète
- Gestion des tâches planifiées
- Bus d'événements avancé
- Système de plugins
- Interface d'administration du Framework
- Tests automatisés
- Documentation générée automatiquement

---

# Modules métier

Une fois le Framework stabilisé, le développement se concentrera sur les modules.

Les principaux modules identifiés sont :

- Dashboard
- CRM
- Diagnostics
- Facturation
- Documents
- Agenda
- Automatisations
- Intelligence artificielle
- Statistiques
- Paramétrage
- Connecteurs externes

Chaque module sera développé indépendamment du Framework.

---

# Philosophie d'évolution

Le Framework évolue lentement.

Les modules évoluent rapidement.

Cette séparation garantit la stabilité du socle technique tout en permettant une évolution continue des fonctionnalités.

Toute évolution du Framework doit respecter les principes définis dans :

- 00-Architecture-Principles.md
- 10-Conventions.md

---

# Objectif à long terme

Faire de CDG Studio une plateforme modulaire, maintenable et extensible, capable d'accompagner durablement les besoins de Cap Digital Gestion.

Le Framework doit rester simple, cohérent et suffisamment générique pour accueillir de nouveaux modules sans remise en cause de son architecture.
