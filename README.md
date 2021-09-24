#Examen 'symfony' Dimitri GRUYER

controller home <br>
template bootstrap<br>
make:entity => Product <br>

- product
    - id - <small>integer</small>
    - name - <small>string</small>
    - imgMiniature - <small>string</small>
    - price - <small>float</small>
    - addedAt - <small>datetime</small>
    - isOnline - <small>boolean</small>
    - img1 - <small>string</small>
    - img2 - <small>string</small>
    - img3 - <small>string</small>

php .\bin\console doctrine:schema:update --force

make:controller => Home<br>
- /home
  - method => getAllProduct

make:controller => ApiRest<br>
- [Route('/api/product', name: 'postNewProduct', methods: 'POST')]
postman : 
{
  "name" : "basket homme",
  "img_miniature" : "chau0000.jpeg",
  "price" : "80.00",
  "added_at" : "2021-12-12",
  "isOnline" : true,
  "img1" : "chau0001.jpeg",
  "img2" : "chau0002.jpeg",
  "img3" : "chau0003.jpeg"
}
- Configure viariable global pour les image
- globals:
  image_dir: 'assets/img/upload/'