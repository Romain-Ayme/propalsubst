# PropalSubst — Module Dolibarr
## Variables de substitution pour les propositions commerciales

### Problème résolu
Dolibarr ne fournit pas nativement la variable `__DATE_DUE_YMD__` pour la date de fin de validité 
dans les modèles d'email des propositions commerciales (propales/devis).
Ce module comble ce manque.

---

### Installation

1. Copier le dossier `propalsubst/` dans le répertoire `custom/` de votre Dolibarr :
   ```
   /var/www/dolibarr/custom/propalsubst/
   ```

2. Aller dans **Accueil → Configuration → Modules**

3. Rechercher **PropalSubst** et cliquer sur **Activer**

---

### Variables disponibles dans vos modèles d'email

Une fois le module activé, ces variables sont utilisables dans tous les modèles d'email
**lorsque l'objet est une proposition commerciale** :

| Variable | Exemple de valeur | Description |
|---|---|---|
| `__PROPAL_DATE_END__` | `31/12/2025` | Validity end date (short format) |
| `__PROPAL_DATE_END_LONG__` | `31 December 2025` | Validity end date (full text) |
| `__PROPAL_DAYS_REMAINING__` | `15 days` | Days remaining before expiry |
| `__PROPAL_DATE_START__` | `15/11/2025` | Proposal creation date |
| `__PROPAL_PAYMENT_TERMS__` | `30 days net` | Payment conditions |
| `__PROPAL_PAYMENT_MODE__` | `Bank transfer` | Payment method |

---

### Exemple de modèle d'email

```
Objet : Proposition commerciale n° __REF__ – __MYCOMPANY_NAME__

Bonjour,

Veuillez trouver ci-joint notre proposition commerciale n° __REF__
d'un montant de __AMOUNT_FORMATED__.

Cette offre est valable jusqu'au __PROPAL_DATE_END__
(soit encore __PROPAL_DAYS_REMAINING__).

Nous restons à votre disposition pour tout échange.

Cordialement,
__USER_FULLNAME__
__USER_PHONE__
__MYCOMPANY_EMAIL__
```

---

### Structure du module

```
propalsubst/
├── core/
│   ├── modules/
│   │   └── modPropalSubst.class.php      ← Descripteur du module
│   └── substitutions/
│       └── functions_propalsubst.lib.php ← Logique des substitutions
├── langs/
│   ├── fr_FR/propalsubst.lang
│   └── en_US/propalsubst.lang
└── README.md
```

---

### Compatibilité
- Dolibarr **v13+** recommandé
- Testé sur v23

### Version
1.0.0
