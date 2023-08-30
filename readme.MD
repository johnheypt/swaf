## Modular Architecture


-  Os Modules devem estar na pastinha `app/Modules/`

-  O módulo e o controller deve ter seus nomes em CamelCase

-  Cada módulo possui um único controller
-  CONTROLLER: O Controller possui o mesmo nome do módulo
    <br>E deve ficar dentro da pasta Controllers
    -  Ex.: `Modules/Users/Controllers/Users.php`
    
        Onde Modules/Users/ é o módulo<br>
        E Users.php é o controller

- VIEWS: As views de um módulo devem ficar na pastinha views
    - Ex.: `Modules/Users/views/index.php`
    - Ex.: `Modules/Users/views/add.php`
<br>
<br>
- MODELS: Os models deverão ficar na pastinha Models
    - Ex.: `Modules/Users/Models/Users.php`