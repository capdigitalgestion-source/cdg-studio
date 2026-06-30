# 07 – Journalisation

## Objectif

La journalisation permet de suivre le comportement du Framework et des modules.

Elle sert à :

- comprendre le déroulement d'un traitement ;
- identifier les erreurs ;
- faciliter le diagnostic ;
- conserver des informations utiles au support.

---

# Norme PSR-3

CDG Studio utilise un Logger compatible PSR-3.

Cette norme définit des niveaux de journalisation communs :

- debug
- info
- notice
- warning
- error
- critical
- alert
- emergency

---

# Utilisation

Dans un module, utiliser :

```php
$this->logger()->info('Message');
```

Avec contexte :

```php
$this->logger()->error('Erreur lors du traitement', [
    'module' => 'Diagnostics',
    'action' => 'generate',
]);
```

---

# Niveaux recommandés

## info

Pour les événements normaux importants.

Exemple :

```php
$this->logger()->info('Diagnostic généré');
```

## warning

Pour une situation anormale mais non bloquante.

```php
$this->logger()->warning('Configuration manquante, valeur par défaut utilisée');
```

## error

Pour une erreur empêchant le traitement attendu.

```php
$this->logger()->error('Impossible de générer le document');
```

---

# Bonnes pratiques

- Toujours écrire un message clair.
- Ajouter un contexte lorsque c'est utile.
- Ne jamais journaliser de données sensibles.
- Ne pas utiliser le Logger comme outil de stockage métier.
- Ne pas multiplier les logs inutiles.

---

# Données sensibles

Les logs ne doivent jamais contenir :

- mots de passe ;
- clés API ;
- tokens ;
- données bancaires ;
- informations personnelles inutiles au diagnostic.

---

# Implémentation actuelle

Le Logger écrit dans le mécanisme de log WordPress lorsque `WP_DEBUG_LOG` est actif.

Cette implémentation pourra évoluer sans modifier les modules.

---

# Philosophie

Les logs doivent aider à comprendre le comportement du système.

Ils doivent rester utiles, lisibles et proportionnés.