# B2 - Symfony

## Composer

### Dépendances

Composer est un gestionnaire de dépendances nous permettant de déclarer les packages externes à notre application, que l'on souhaite utiliser.

On peut utiliser Composer pour créer notre application Symfony, par exemple.

On peut également utiliser Composer pour importer une dépendance isolée (un composant Symfony seul par exemple).

### Autoloading

Composer peut également nous permettre de gérer la manière dont on va charger les classes de notre application.

Par exemple, si on souhaite utiliser [`PSR-4`](https://www.php-fig.org/psr/psr-4/), on peut lui indiquer.

> composer.json

On vient fixer ici le fait que le namespace "App" correspond au dossier "src/" de notre application.

Ainsi, il agira comme un espace de nom "racine" et suivra l'arborescence de notre application.

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/"
    }
  }
}
```

### Versioning

On trouvera une stratégie de versioning [`semver`](https://devhints.io/semver) pour les packages en PHP.

Le versioning `semver` est divisé en 3 parties. De gauche à droite :

- Version majeure (_Cette version introduit des changements significatifs par rapport à la version précédente, certaines fonctionnalités qui précédaient sont supprimées par exemple_)
- Version mineure (_On peut introduire de nouvelles choses dans une version mineure par exemple, en s'assurant que tout ce qui existe déjà continue de fonctionner_)
- Version de patch (_Correctifs de bugs et sécurité_)

Les packages Composer se trouvent pour leur grande majorité sur [packagist.org](https://packagist.org/).

## Symfony

Comme indiqué sur [la page d'accueil](https://symfony.com/), Symfony est avant tout **un ensemble de composants PHP réutilisables**.

Le framework Symfony en lui-même vient rassembler plusieurs dizaines de ces composants, dans une structure (arborescence) précise. On construit ensuite notre application dans cette structure.

### Versions

Symfony adopte également le système de versioning `semver`, et présente une nouvelle version majeure tous les 2 ans.

Pendant ces 2 années, on aura 5 versions mineures : de 0 à 4.

La version mineure n°4 sera donc la dernière sous-version d'une version majeure (3.4, 4.4, etc...), et elle sortira en même temps que la version majeure suivante.

Ainsi, les versions 3.4, 4.4, etc...sont appelées des versions **LTS** ou Long-Term Support : un support sur la correction de bug et de failles de sécurité est assuré sur ces versions pendant 3 ans pour les corrections de bugs et 4 ans pour les failles de sécurité.

### Installation en version 5.4 LTS

Pour installer un projet Symfony avec la version 5.4, donc la LTS, on va utiliser le [binaire de Symfony](https://symfony.com/download) (ou Symfony CLI) :

```bash
symfony new my_project_directory --version=5.4 --webapp
```

> Note : on peut créer 2 types d'application Symfony : des applications destinées à la création de microservices, API, ou applications console par exemple, et des applications web complètes, incluant un moteur de template (Twig). Dans ce cas, on ajoute l'option `--webapp` à l'instruction de ligne de commande permettant de créer l'application. La base d'installation reste la même (package Composer `symfony/skeleton`)

A l'exécution de cette commande, on verra défiler les différents composants issus de packagist.org, qui sont intégrés automatiquement par le framework dans nos dépendances.

### Environnements

Dans une application Symfony, l'environnement par défaut dans lequel nous allons travailler est `dev`, par défaut.

L'environnement se présentera sous forme d'une variable d'environnement `APP_ENV`.

Il y a 3 environnements prévus par Symfony par défaut : `dev`, pour la phase de développement, `test` pour les tests unitaires, fonctionnels, etc... et `prod` pour le déploiement en production, qui nous permet d'optimiser la configuration de l'application pour qu'elle soit plus rapide.

### Arborescence

#### `/assets`

Ce dossier contient des fichiers Javascript qui composeront la partie front-end, donc l'interface, si nous utilisons l'outil **Webpack Encore** fourni par Symfony.

Webpack Encore permet de développer des interfaces modulaires avec Javascript et le **bundler** [Webpack](https://v4.webpack.js.org/).

#### `/bin`

Ce dossier contient 1 fichier qui va être très important : `console`. La console Symfony (**différente de l'outil Symfony CLI**) nous fournira des commandes utilitaires permettant de générer des fichiers au sein de notre arborescence, accélérant le développement de notre application, mais aussi garantissant une meilleure constance dans le style du code : la génération via des templates s'effectue toujours de la même façon, nous aurons uniquement à ajouter le code propre à notre application.

#### `/config`

Ce dossier, comme son nom le laisse facilement deviner, contient les fichiers de configuration des différents packages utilisés dans l'application.

Les fichiers de configuration utilisent le format [`yaml`](https://fr.wikipedia.org/wiki/YAML), basé sur l'indentation des différentes sections.

Se trouvent également 2 fichiers `bundles.php`, regroupant les composants applicatifs que l'on souhaite activer dans notre application, selon l'environnement, et `preload.php` pour le preloading introduit par PHP 7.4 pour le pré-chargement de scripts.

#### `/migrations`

Les migrations contiendront des classes PHP décrivant les changements de structure de notre base de données, quand nous travaillerons avec une BDD.

#### `/public`

Ce dossier contient uniquement un fichier `index.php`, qui va être le point d'entrée de notre application.

#### `/src`

Dans ce dossier, on retrouvera les classes de notre application.

On va avoir par exemple le dossier `Controllers` dans lequel se trouveront toutes les classes de contrôleurs permettant de gérer la navigation et le routage dans notre application.

Les entités (donc le modèle) se trouveront elles dans le dossier `Entity`.

Les repositories, dans le dossier `Repository`, seront notre couche de services, permettant de requêter nos modèles.

Nous n'aurons pas à toucher le fichier `Kernel.php`, c'est le noyau de Symfony.

#### `/templates`

Ce dossier contiendra tous nos templates, écrits avec `Twig`, un moteur de template que nous verrons plus tard.

#### `/translations`

Ce dossier contiendra des fichiers de traduction, si nous voulons travailler sur une application présentant des libellés multilingues, ou encore chaînes localisées.

#### `/var`

Ce dossier est destiné à recevoir des données de caches et de logs, il n'est pas intégré au gestionnaire de versions si on en utilise un.

On trouvera par exemple les fichiers issus de la compilation du conteneur applicatif, dans le dossier `cache`.

#### `/vendor`

Le dossier `/vendor` est géré par Composer, pour y inscrire la méthode d'autoloading ainsi que les sources des dépendances utilisées dans l'application.

On remarquera qu'il n'est pas versionné.

En effet, ce dossier est **entièrement** géré par Composer. Ainsi, lorsqu'on va clôner ou forker un dépôt de sources, on pourra utiliser la commande `composer install` pour le générer. Il contient souvent des milliers de fichiers issus des dépendances de notre application, il est donc inutile de commit et push tous ces fichiers sur un dépôt distant.

#### `.env`

Ce fichier contient les variables d'environnement de l'application.

Il contient en premier lieu la définition de l'environnement (`APP_ENV`).

Nous verrons plus tard l'utilité de définir plusieurs fichiers contenant des variables d'environnement et les stratégies de versioning associées.

#### `.gitignore`

Tous les fichiers à ne pas intégrer au gestionnaire de versions.

#### `composer.json`

Le fichier Composer principal, qui contient toutes nos dépendances, et la méthode d'autoloading, entre autres.

On trouvera, entre autres, les dépendances de notre application dans 2 catégories : `require` et `require-dev`.

`require` regroupe les dépendances utilisées tout le temps.

Dans `require-dev`, on placera ce qu'on va appeler **des dépendances de développement**. Cela va concerner essentiellement les tests unitaires, ou utilitaires que l'on peut mettre en oeuvre lors de la phase de développement d'une application.

> En production par exemple, on ne voudra pas des dépendances de développement. On pourra ainsi demander à Composer de ne pas les intégrer au projet : `composer install --no-dev`

#### `composer.lock`

Ce fichier est celui consulté par Composer lorsque vous effectuez un `composer install`, pour installer toutes les dépendances préalablement définies.

On peut le voir comme l'équivalent du `package-lock.json` avec npm, qui permet de regrouper les versions installées.

Ainsi, n'importe qui de nouveau sur le projet peut faire un `composer install` après avoir clôné ou forké le projet : il aura exactement les mêmes versions que nous.

#### `docker-compose.override.yml & docker-compose.yml`

Ces 2 fichiers décrivent le ou les services à instancier pour l'outil de conteneurisation [**Docker**](https://www.docker.com/), et plus précisément l'utilitaire `docker-compose`.

#### `package.json`

Tout comme `composer.json`, qui regroupe les dépendances Composer utilisées pour le back-end de notre application, ce fichier regroupe les dépendances à intégrer pour **npm** (Node Package Manager).

Vous retrouverez notamment la dépendance `@symfony/webpack-encore`, qui, comme cité plus haut, permet de développer des interfaces modulaires gérées ensuite par l'outil Webpack.

#### `symfony.lock`

Ce fichier sert à un outil intégré avec la version 4 de Symfony : Symfony Flex.

Symfony Flex est un outil construit au-dessus de Composer. Il permet, dans un projet Symfony, en plus d'installer une dépendance, d'exécuter des **recettes**, comme des scripts de pré-configuration d'un package.

Vu que nous nous situons dans un framework, il adopte une certaine structure (dossier `config` pour la configuration, autoloading `PSR-4` avec `App` comme espace de nom racine, etc...).

Lorsqu'on installe une dépendance avec la commande `composer require`, Flex peut alors entrer en jeu en créant automatiquement un fichier de configuration à l'endroit adéquat, ou bien un template de classe PHP dans `src`, etc...**il va nous aider à l'intégration d'un package au sein d'une application Symfony**.

Ce fichier garde, en plus de la version du package, la version de la recette exécutée.

#### `webpack.config.js`

Le fichier de configuration du workflow de Webpack, et plus précisément ici de Webpack Encore.

Ce fichier décrit les différentes actions à effectuer pour bundler le front-end de notre application. ON y trouvera par exemple des méthodes à activer si on veut activer le support de divers outils (Sass, TypeScript, ReactJS, etc...) :

> Fichier : webpack.config.js

```js
// enables Sass/SCSS support
//.enableSassLoader()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use React
//.enableReactPreset()
```
