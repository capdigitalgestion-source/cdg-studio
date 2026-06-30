# 08 – Gestion du Cache

## Objectif

Le Cache permet d'éviter l'exécution répétée de traitements coûteux.

Il améliore :

- les performances ;
- la réactivité de l'application ;
- la charge sur la base de données ;
- l'expérience utilisateur.

Le Framework fournit un composant unique de gestion du cache.

---

# Pourquoi utiliser le Cache ?

Certaines informations évoluent peu mais sont demandées très souvent.

Exemples :

- statistiques du tableau de bord ;
- paramètres système ;
- données calculées ;
- appels API externes ;
- listes de référence.

Le Cache évite de recalculer ces informations à chaque requête.

---

# Utilisation

Lecture :

```php
$value = $this->cache()->get('dashboard.stats');
```

Écriture :

```php
$this->cache()->put(
    'dashboard.stats',
    $stats,
    3600
);
```

Suppression :

```php
$this->cache()->forget('dashboard.stats');
```

---

# remember()

La méthode recommandée est :

```php
$stats = $this->cache()->remember(
    'dashboard.stats',
    3600,
    fn () => $this->repository->calculateStatistics()
);
```

Fonctionnement :

- le cache existe → il est retourné ;
- le cache n'existe pas → le callback est exécuté ;
- le résultat est enregistré ;
- la valeur est retournée.

Cette méthode évite d'écrire plusieurs fois la même logique.

---

# Durée de vie

La durée dépend du type de données.

Exemples :

| Donnée | Durée recommandée |
|---------|-------------------|
| Tableau de bord | 5 à 15 minutes |
| Paramètres | 1 heure |
| Statistiques | 1 heure |
| Données API | selon le fournisseur |
| Données temporaires | quelques minutes |

Il convient de choisir une durée adaptée à la fréquence réelle de mise à jour.

---

# Ce qui ne doit pas être mis en cache

Ne jamais mettre en cache :

- les informations sensibles ;
- les données propres à une session utilisateur ;
- les traitements critiques devant toujours être à jour.

Le cache ne doit jamais devenir la source de vérité.

---

# Implémentation actuelle

Le Framework repose actuellement sur les Transients WordPress.

Cette implémentation est transparente pour les modules.

Une évolution future pourra utiliser :

- Object Cache ;
- Redis ;
- Memcached ;
- toute autre solution compatible.

Les modules n'auront aucune modification à effectuer.

---

# Bonnes pratiques

- Utiliser des clés explicites.
- Choisir une durée cohérente.
- Supprimer le cache lorsqu'une donnée est modifiée.
- Préférer `remember()` lorsque cela est possible.

---

# Philosophie

Le Cache est un outil d'optimisation.

Il ne remplace jamais les données métier.

Le Framework garantit une implémentation unique afin que tous les modules utilisent les mêmes mécanismes de mise en cache.