## CakePHP Labs

### Lab 1 - Add Sessions

[</> code](https://github.com/stack-x/cake.example.com/commit/9d8a65128621e75f8f17c95925ad27219e5b786b) Add an instance variable to hold the session object, set this variable during initialization. The following reads as "set this instance of ```$session``` to the session object from this instance of the request object." This will provide a short hand for accessing the session data in controllers.

*src/Controller/AppController.php* add to Line 31 and line 60
```php
class AppController extends Controller
{
    //line 31
    protected $session;
        ...

    public function initialize(): void
    {
        ...

    //line 60
        $this->session = $this->getRequest()->getSession();
    }
```

*src/Controller/AppController.php*
```sh
<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    protected $session;
    // public function beforeFilter(\Cake\Event\EventInterface $event)
    // {
    //     parent::beforeFilter($event);
    //     // for all controllers in our application, make index and view
    //     // actions public, skipping the authentication check.
    //     $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    // }

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // Add this line to check authentication result and lock your site
        // $this->loadComponent('Authentication.Authentication');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');


        $this->session = $this->getRequest()->getSession();

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }
    
}
```
Now accessing [http://loc.cake.example.com](http://loc.cake.example.com) will redirect you to a login page.

### [Configuration](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Configuration.md)

Navigate to [http://loc.cake.example.com/users/add](http://loc.cake.example.com/users/add) and create a user account.

### Lab 2 - Configuration for Social Login

Using the documentation for the users plugin, add the ability to log in using a social media platform of your choice.
For easier configuration, you can specify an array of config files to override the default plugin keys this way:
*config/bootstrap.php*
```sh
// The following configuration setting must be set before loading the Users plugin
Configure::write('Users.config', ['users']);
Plugin::load('CakeDC/Users', ['routes' => true, 'bootstrap' => true]);
Configure::write('Users.Social.login', true); //to enable social login
```

Create the facebook, twitter, etc applications you want to use and setup the configuration like this: You'll need to add the providers to your composer.json file.

> #### If you want to use social login features...

```
composer require league/oauth2-facebook:@stable
composer require league/oauth2-instagram:@stable
composer require league/oauth2-google:@stable
composer require league/oauth2-linkedin:@stable
composer require league/oauth1-client:@stable
```
> NOTE: you'll need to enable social login if you want to use it, social login is disabled by default. *config/bootstrap.php*

```
Configure::write('Users.config', ['users']);
Configure::write('Users.Social.login', true); //to enable social login
```
Or use the config override option when loading the plugin (see above)

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
