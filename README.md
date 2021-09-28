#Examen 'symfony' Dimitri GRUYER
              /\
             /  \            J'utilise une classe pour instancier mes objets 'ROLE' donc bien veillez à faire
            / || \           un doctrine:schema:update !!   
           /  ..  \
           --------


<h1 style="color: #0dcaf0">BUG connus</h1>
<p style="color: orange">
Lors de la 1er connection du compte moderator, => redirection vers le template /home (non autorisé),
Retour arriere, rafraichir page login == direction correct vers le dashboard moderator !!
</p>
<p style="color: orange">
Au lancement de l'application la route par défaut est rediriger vers /login. Cepedant, 
sans un premier raffraichissement de cette page, les authentifications ne fonctionne pas !!
</p>

<h2 style="color: yellow">ENTITY</h2>
<h3 style="color: #0dcaf0">PRODUCT</h3>

<span style="text-decoration: underline">make:entity => Product</span>

- Product
    - id - <strong>integer</strong>
    - name - <strong>string</strong>
    - imgMiniature - <strong>string</strong>
    - price - <strong>float</strong>
    - addedAt - <strong>datetime</strong>
    - isOnline - <strong>boolean</strong>
    - price - <strong>float</strong>

<small style="color: gray">php .\bin\console doctrine:schema:update --force</small>

<h3 style="color: #0dcaf0">USER</h3>
<span style="text-decoration: underline">make:entity => User</span>
- User
  - id - <strong>integer</strong>
  - name - <strong>string</strong>
  - surname - <strong>string</strong>
  - email - <strong>float</strong>
  - password - <strong>datetime</strong>

<small style="color: gray">php .\bin\console doctrine:schema:update --force</small>

<span style="text-decoration: underline">Modifier entity Product</span>

- Client - <strong>Entity=User</strong></li>
  - updated: src/Entity/Product.php
  - updated: src/Entity/User.php

<small style="color: gray">php .\bin\console doctrine:schema:update --force</small>


<span style="text-decoration: underline">Modifier entity User</span>

- Implementation 
  - IMPLEMENT => UserInterface, PasswordAuthenticatedUserInterface dans User

<h3 style="color: #0dcaf0">ROLE</h3>
  <span style="text-decoration: underline">make:entity => Role</span>
- Role
  - id - <strong>integer</strong>
  - role - <strong>string</strong>

<small style="color: gray">php .\bin\console doctrine:schema:update --force</small>

Modifier entity User
- Roles - <strong>Entity=Role</strong></li>
- updated: src/Entity/Role.php
- updated: src/Entity/User.php

<small style="color: gray">php .\bin\console doctrine:schema:update --force</small>

<h2 style="color: yellow">CONTROLLERS</h2>
<h3 style="color: #0dcaf0">HOME</h3>
<span style="text-decoration: underline">make:controller => Home</span>

-Template home.html.twig
  - Ajout du template Bootstrap 'Shop'<br>
    https://startbootstrap.com/template/shop-item

<h3 style="color: #0dcaf0">PublicRestController</h3>
<span style="text-decoration: underline">make:controller => PublicRest</span>

[Route('/public/user', name: 'postNewUser', methods: 'POST')]<br>
<span style="color: red">postman</span> :<br>
{<br>
"name" : "DGnex",<br>
"surname" : "NEXUS",<br>
"email" : "dgnex@mail.com",<br>
"password" : "1234"<br>
"roles" : "ROLE_USER"<br>
}<br>

[Route('/api/product', name: 'postNewProduct', methods: 'POST')]<br>
<span style="color: red">postman</span> :<br>
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

<h2 style="color: yellow">CONFIGURATIONS</h2>
<h3 style="color: #0dcaf0">VARIABLES</h3>
<span style="text-decoration: underline">Configure viariable global pour les images</span><small> => config/packages/twig.yaml</small>
- globals:
  - image_dir: 'assets/img/upload/'

<h2 style="color: yellow">AUTHENTIFICATOR</h2>
<h3 style="color: #0dcaf0">AUTH</h3>
<span style="text-decoration: underline">make:auth</span>
=> SecurityController<br>

<span style="text-decoration: underline">make:form</span>
=> UserRegisterType<br>

