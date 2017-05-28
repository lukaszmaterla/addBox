addBox - Notice-board 
======
 
### Used technologies:

- PHP:
    - Symfony
        - Doctrine
        - Twig
        - FOSUserBundle
        - EasyAdmin Bundle
    - SwiftMailer
- Bootstrap

### Possible Operation:  
- implemented entities and relation between them:
    - user
    - offer
    - comment
    - category 
    - message
- all users can see up-to-date advertisements on main page
- all users can view ads and add comments 
- to add new advertisment, user must to register
- to confirm register, users need to click in activation link which is sent by email
- logged in user can:
    - add new advertisment, also edit and delete
    - edit profile and add new personal information
    - view only his offer divided into actives and archives 
- if someone adds a comment the owner of the offer gets an email with the content, date and a link to check
- offer have to add to one category  
- category can create only promoted user to admin role
- logged in users can send message to offer owner user

### Routing:
- /  - all user
- /admin - only user has ROLE_ADMIN
- /profile - only logged in users
- /offer/new - only logged in users
- /offer/{id} - all users
- /profile/offer/ - only logged in users
- /category/{id} - all users
- /category/new - only admin
- /profile/message - only logged in users
### Author

* **Łukasz Materla** - [Profile](https://github.com/lukaszmaterla)
