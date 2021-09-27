#Examen 'symfony' Dimitri GRUYER
              /\
             /  \            J'utilise une classe pour instancier mes objets 'ROLE' donc bien veillez à faire
            / || \           un doctrine:schema:update !!   
           /  ..  \
           --------
bug à corrigé<br>
<p style="color: orange">
Lors de la 1er connection du compte moderator, => redirection vers le template /home (non autorisé),
Retour arriere, rafraichir page login == direction correct vers le dashboard moderator !!
</p>

make:entity => Product <br>
- Product
    - id - <strong>integer</strong>
    - name - <strong>string</strong>
    - imgMiniature - <strong>string</strong>
    - price - <strong>float</strong>
    - addedAt - <strong>datetime</strong>
    - isOnline - <strong>boolean</strong>
    - img1 - <strong>string</strong>
    - img2 - <vstrong>string</strong>
    - img3 - <strong>string</strong>
    - price - <strong>float</strong>

php .\bin\console doctrine:schema:update --force

make:entity => User <br>
- User
  - id - <strong>integer</strong>
  - name - <strong>string</strong>
  - surname - <strong>string</strong>
  - email - <strong>float</strong>
  - password - <strong>datetime</strong>

Modifier entity Product
- Client - <strong>Entity=User</strong></li>
- updated: src/Entity/Product.php
- updated: src/Entity/User.php

php .\bin\console doctrine:schema:update --force

Add Entity Role
Add UserInterface, PasswordAuthenticatedUserInterface dans User
make:entity => Role <br>
- User
  - id - <strong>integer</strong>
  - role - <strong>string</strong>

Modifier entity User
- Roles - <strong>Entity=Role</strong></li>
- updated: src/Entity/Role.php
- updated: src/Entity/User.php

php .\bin\console doctrine:schema:update --force


make:controller => Home<br>
- /app/home
  - method => getAllProductIsOnline<br>
  - 
-Template home.html.twig
  - Ajout du template Bootstrap 'Shop'<br>
    https://startbootstrap.com/template/shop-item

Tester l'injection de données <br>

make:controller => ApiRest<br>
[Route('/public/user', name: 'postNewUser', methods: 'POST')]<br>
postman :<br>
{<br>
"name" : "DGnex",<br>
"surname" : "NEXUS",<br>
"email" : "dgnex@mail.com",<br>
"password" : "1234"<br>
"roles" : "ROLE_USER"<br>
}<br>

[Route('/api/product', name: 'postNewProduct', methods: 'POST')]<br>
postman : <br>
{<br>
  "name" : "basket homme",<br>
  "img_miniature" : "chau0000.jpeg",<br>
  "price" : "80.00",<br>
  "added_at" : "2021-12-12",<br>
  "isOnline" : true,<br>
  "img1" : "chau0001.jpeg",<br>
  "img2" : "chau0002.jpeg",<br>
  "img3" : "chau0003.jpeg"<br>
  "user" : 1<br>
}<br>

- Configure viariable global pour les image
- globals:
  image_dir: 'assets/img/upload/'

Ajouter  make:auth<br>
=> SecurityController<br>
Ajouter make:form
=> UserRegisterType<br>
Modifier SecurityController<br>
=> Afficher le formulaire register sur la même page<br>

Ajouter make:controller<br>
=> UserController
- Methode /user/register
=> Récupérer et interpréter les données du formulaire 

Ajouter un produit<br>




Modifier 

modifier publicRestController Add user

