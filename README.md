<img src="https://user-images.githubusercontent.com/83210905/145017371-38efba3a-1cda-454c-a40b-1b2b10acc79f.png" />


<h3>Présentation</h3>

<p>Ce projet a été réalisé par un groupe de 3 personnes:</p>
<ul>
  <li>Corentin Nordmann (<a href="https://github.com/CorentinNrd">Github</a>, <a href="https://corentinnrd.github.io/Portfolio-Corentin/">Portfolio</a>)</li>
  <li>Nolwenn Sibiril (<a href="https://github.com/Nolwenn14">GitHub</a>, Portoflio à venir)</li>
  <li>Moi même (<a href="https://dounyadelren.github.io/Portfolio_DounyaDerlen/">Portfolio</a>)</li>
</ul>
<p>Nous avons eu un mois pour recréer un clône de Twitter avec la plupart de ses fonctionnalités. Fraichement sortis d'une grosse période d'apprentissage nous avons mis à profit toutes les connaissances que nous avions cumulées sur PHP, MYSQL, Javascript (les requêtes Ajax notamment) ainsi que la structure d'un site web en MVC (une rapide ébauche sur ce projet)</p>
<p>Contrainte : interdiction d'utiliser un <u>framework</u></p>

<h3>Installation : </h3>
<p>Rien de plus simple ! Il vous suffit de clôner ce repertoire et lancer votre serveur Apache.</p>

<h3>Organisation : </h3>
<p>Je tiens à remercier mes coéquipiers avec qui le travail de groupe a été d'une fluidité déconcertante. Nos tâches ont été divisées selon nos points forts et nos affinités ce qui nous a permis d'être très productifs.</p>
<p>Personnellement je me suis occupée majoritairement de la partie Front-End: le rendu visuel, les interactions base de données, inscription/connexion, la publication de tweets, les différents thèmes de couleur, la récupération des données de l'utilisateur (photo de profil, "@", etc...) ainsi que les hahtags.</p>

<ul>
  <li>Le Front-End : je me suis très librement inspirée du site original avec un dossier d'assets constitué d'icônes trouvées sur le net et traitées sur Gimp pour m'assurer d'avoir un fond transparent</li>
  <li>le CRUD : l'inscription, la connexion, la publication de tweets ont été très rapidemment mise en place car c'est un point que je maitrise. Pour les hashtags j'ai utilisé une RegEx qui cible tous les caractères qui suivent le caractères "#", cette chaîne de caractère devient un lien coloré qui renvoie sur la page de recherche google de ce mot. Malheureusement ma Regex ne prend pas en compte un deuxième ou troisième hashtag elle n'en cible qu'un.</li>
  <li>La récupération des données : une de mes collègues a donc créé des objets Json pour ses requêtes Ajax, en faisant des tableaux à parcourir, il me suffisait donc de récupérer le bon tableau avec l'index adéquat qui m'affichait l'infomartion voulue</li>
  <li>Les thèmes : les thèmes ont été fait à deux. Le problème étant qu'il nous manquait un élément essentiel; le stockage dans le localStorage, qui gardait en mémoire le thème choisit</li>
 </ul>
<h3>Commentaires : </h3>
<p>En termes de modularité du code, il y a mieux. Ceci étant dit, c'est le premier gros gros projet de trois bébés codeurs alors nous en sommes assez fiers, mais il y a toujours place pour l'amélioration. Par exemple:</p>
<ul>
  <li>La barre de recherche n'est pas fonctionnelle</li>
  <li>On ne peut ni repondre, ni commenter, ni reposter</li>
  <li>Pour l'instant le post d'image ou vidéo n'est pas possible</li>
  <li>Il faudrait créer une fonction pour redimmensionner automatiquement les photos de profil sans les déformer</li>
</ul>
<p>Oui ça fait beaucoup...</p>

<p> Au final ce projet je m'y remettrais bientôt mais avec un autre langage, sans contraintes, sûrement avec React & Node + API </p>

