<?php
/**
 * A mock up of session data
 */
class Session
{
  /**
   * Returns the current user session
   * @return array Session Data
   */
  public function read()
  {
    return ['id'=>'1234', 'name'=>'YOUR-NAME'];
  }
}

/**
 * Returns a greeting to a given user
 */
class Hello
{
  /**
   * An instance variable to hold the name of the user
   * @var string
   */
  private $who;

  /**
   * A constructor method - Constructor injection with type hinting. Constructor injection is a form of type hinting.
   * @param  Object $session A user session
   */
  public function __construct(Session $session) {

    $sessionData = $session->read();

    $this->setWho($sessionData['name']);
  }

  /**
   * A setter method for Hello::who
   * @param String $who - The name of a given user
   */
  public function setWho($who)
  {
    $this->who = $who;
  }

  /**
   * Returns a greeting to a target user
   * @param  {[type]} $message [description]
   * @return {[type]}          [description]
   */
  public function greet($message)
  {
    return "{$message} {$this->who}";
  }

}

//Instantiate the Session class
$session = new Session();

//Instantiate the Hello class. Inject the $session object into the constructor.
$greeting = new Hello($session);

//Provide a message for the user (Ternary Logic)
$message = 'Good ' . (date("H")<12?'Morning':(date("H")<17?'Afternoon':'Evening'));

echo $greeting->greet($message);
