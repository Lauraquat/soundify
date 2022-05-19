# Soundify

## Fonctionnalités

- [ ] Homepage
- [ ] Compte
- [ ] Créer artistes (lier aux comptes)
- [ ] Inscription
- [ ] Connexion
- [ ] Page mon-compte
- [ ] Sécuriser mon-compte
- [ ] Créer un titre (si compte artiste)
- [ ] BREAD titres (+ sécu pour modif et suppr owner seulement)
- [ ] BREAD Playlist (+ secu modif et suppr owner seulement)
- [ ] Écouter titre
- [ ] Liker titre -> ajout sur une playlist insupprimable "favoris"

## Models

### Playlist

- nom
- supprimable
- titres
- proprio

### Titres

- nom
- artistes
- fichier
- durée
- categories
- nb-écoutes
- image

### Catégories

- nom

### Artistes

- nom
- titres

### Utilisateur

- nom
- password
- mail
- playlists
- ?artiste