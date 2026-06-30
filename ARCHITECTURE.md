# Architecture CDG Studio

CDG Studio est structuré comme un plugin WordPress modulaire avec un socle interne inspiré d’un mini-framework PHP.

L’objectif est de séparer clairement :

- le cœur applicatif ;
- les services techniques ;
- les modules métier ;
- les accès WordPress ;
- les événements ;
- les exceptions ;
- les services réutilisables.

---

## Cycle de vie du plugin

```txt
cdg-studio.php
    ↓
Composer autoload
    ↓
CDGStudio\Core\Plugin
    ↓
CDGStudio\Core\Application
    ↓
Service Providers
    ↓
ModuleLoader
    ↓
Modules

app/
├── Contracts/
├── Core/
├── Events/
├── Exceptions/
├── Helpers/
├── Http/
├── Modules/
├── Providers/
├── Services/
└── Support/