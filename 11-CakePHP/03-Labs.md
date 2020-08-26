## CakePHP Labs

### Lab 1 - Add Sessions

[</> code](https://github.com/stack-x/cake.example.com/commit/9d8a65128621e75f8f17c95925ad27219e5b786b) Add an instance variable to hold the session object, set this variable during initialization. The following reads as "set this instance of ```$session``` to the session object from this instance of the request object." This will provide a short hand for accessing the session data in controllers.

*src/Controller/AppController.php* add to Line 40 and line 47
```php
    //line 40
    protected $session;

    public function initialize()
    {
        ...

    //line 47
        $this->session = $this->getRequest()->getSession();
    }
```

#### Deny Access by Default
[</> code](https://github.com/stack-x/cake.example.com/commit/44f8149e1b6dda45d8ffa37f13f4b9d8852dafc3)
*src/Controller/AppController.php*
```php
public function initialize(): void
{
    parent::initialize();

    // Load the AUTH component
    $this->loadComponent('Auth');

    $this->loadComponent('RequestHandler');
    $this->loadComponent('Flash');
    $this->session = $this->getRequest()->getSession();

    // Deny unauthorized access by default
    $this->Auth->deny();
}
```

At this point when you try to access [http://loc.cake.example.com](http://loc.cake.example.com) the application will try to redirect you to *users/login*. This will error out due to us (a) not having a UsersController at the top level and (b) not having a route that directs us to the CakeDC plugin. We will resolve this by adding a route.

[</> code](https://github.com/stack-x/cake.example.com/commit/b32d232a8f74ff1e9512b0cb8c10e9afe332a977) Add the following at line 80 of *src/config/routes.php*

```php

Router::connect(
    '/users/login',
    [
        'plugin' => 'CakeDC/Users',
        'controller' => 'Users',
        'action' => 'login'
    ]
);

```

Now accessing [http://loc.cake.example.com](http://loc.cake.example.com) will redirect you to a login page.

### [Configuration](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Configuration.md)


Navigate to [http://loc.cake.example.com/users/add](http://loc.cake.example.com/users/add) and create a user account.

### Lab 2 - Composer

Using the documentation for the users plugin, add the ability to log in using a social media platform of your choice.
> #### If you want to use social login features...

```composer require league/oauth2-facebook:@stable
composer require league/oauth2-instagram:@stable
composer require league/oauth2-google:@stable
composer require league/oauth2-linkedin:@stable
composer require league/oauth1-client:@stable
```
> NOTE: you'll need to enable social login if you want to use it, social login is disabled by default. 
```
Configure::write('Users.config', ['users']);
Configure::write('Users.Social.login', true); //to enable social login
```
> then in your config/users.php
```
return [
    'OAuth.providers.facebook.options.clientId' => 'YOUR APP ID',
    'OAuth.providers.facebook.options.clientSecret' => 'YOUR APP SECRET',
    'OAuth.providers.twitter.options.clientId' => 'YOUR APP ID',
    'OAuth.providers.twitter.options.clientSecret' => 'YOUR APP SECRET',
    //etc
];
```
> ### **IMPORTANT:** Remember you'll need to configure your social login application callback url to use the provider specific endpoint, for example:
```
Facebook App Callback URL --> http://yourdomain.com/auth/facebook
Twitter App Callback URL --> http://yourdomain.com/auth/twitter
Google App Callback URL --> http://yourdomain.com/auth/google
etc.
```
> ### *Note: Choose your most used log-in type. Using social authentication is not required.* Check the [Configuration page](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Configuration.md) for more details.

### Lab 3 - Comment System

1. Create a table
  * id - the primary key of the comment system
  * post_id - the id of the article for which the comment is being made
  * first_name - the first name of the reader making a comment
  * last_name - the last name of the reader making a comment
  * email - the email of the reader making a comment
  * comment - the reader's comment
  * created - current timestamp at the time of submission
1. At the bottom of each article provide a form that will collect the above data and on submit
  * Save the data to the comments table

### Lab 4 - Contact Form

1. Create a contact form.
1. When a user submits the form, save the contents to a database.
1. When the user submits the form, use the MailGun API to send your self an email every time someone submits the contact form.

If you’ve made it this far, congratulations, you now have a simple blog that:
* Allows authenticated users to create and edit articles.
* Allows unauthenticated users to view articles.


## Additional Resources
* [CakePHP](https://cakephp.org/)
