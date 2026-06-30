# 05 – Gestion des événements

## Objectif

Le Framework CDG Studio adopte une architecture orientée événements.

Les événements permettent aux différents composants de communiquer sans créer de dépendances directes.

Ils favorisent :

- un faible couplage ;
- une meilleure extensibilité ;
- une maintenance simplifiée.

---

# Pourquoi utiliser des événements ?

Sans événements :

```
Module A
    │
    ▼
Module B
```

Le module A dépend directement du module B.

Cette dépendance rend l'évolution plus difficile.

Avec les événements :

```
Module A

↓

EventDispatcher

↓

Module B
```

Les modules restent indépendants.

---

# Principe

Un composant peut :

- déclencher un événement ;
- écouter un événement.

Il ne connaît jamais les composants qui réagiront.

---

# Déclencher un événement

Exemple :

```php
$this->events()->dispatch(
    new ContactCreated($contact)
);
```

Le Framework transmet ensuite l'événement à tous les écouteurs enregistrés.

---

# Écouter un événement

Exemple :

```php
$this->events()->listen(
    ContactCreated::class,
    function (ContactCreated $event) {
        // Traitement
    }
);
```

Plusieurs écouteurs peuvent réagir au même événement.

---

# Cas d'utilisation

Les événements sont particulièrement adaptés pour :

- création d'un contact ;
- validation d'un formulaire ;
- génération d'un document ;
- envoi d'un e-mail ;
- synchronisation avec un service externe ;
- journalisation.

---

# Communication entre modules

Les modules ne doivent jamais s'appeler directement.

Ils échangent uniquement par :

- événements ;
- services communs.

Cette règle est obligatoire.

---

# Événements du Framework

Le Framework pourra publier plusieurs événements internes.

Exemples :

- FrameworkBooting
- FrameworkBooted
- ModuleRegistering
- ModuleRegistered
- ModuleBooting
- ModuleBooted

Ces événements permettront aux modules de réagir au cycle de vie du Framework.

---

# Événements métier

Chaque module peut définir ses propres événements.

Exemples :

CRM

- ContactCreated
- ContactUpdated
- ContactDeleted

Diagnostics

- DiagnosticStarted
- DiagnosticCompleted

Facturation

- InvoiceGenerated
- InvoiceSent

Les événements métier restent propres à leur domaine.

---

# Bonnes pratiques

- Les événements doivent être simples.
- Ils transportent uniquement les données nécessaires.
- Ils ne contiennent aucune logique métier.
- Leur nom doit être explicite.

---

# Ce qu'il faut éviter

- Utiliser les événements pour contourner une mauvaise architecture.
- Transporter des objets inutiles.
- Déclencher plusieurs fois le même événement sans raison.
- Créer des dépendances cachées entre modules.

---

# Philosophie

Les événements constituent le principal mécanisme de communication entre les composants du Framework.

Ils permettent de faire évoluer CDG Studio sans augmenter le couplage entre les modules.
