<?php
# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

require '/var/www/conf/keys.php';

class Validate{

    public $validation = [];

    public $errors = [];

    private $data = [];

    public function notEmpty($value){

        if(!empty($value)){
            return true;
        }

        return false;

    }

    public function email($value){

        if(!empty($value)){
            if(filter_var($value, FILTER_VALIDATE_EMAIL)){
                return true;
            }
        }
        return false;

    }

    public function url($value){

        if(!empty($value)){
            if(filter_var($value, FILTER_VALIDATE_URL)){
                return true;
            }
        }

        return false;

    }

    public function check($data){

        $this->data = $data;

        foreach(array_keys($this->validation) as $fieldName){
            $this->rules($fieldName);
        }

    }

    public function rules($field){
        foreach($this->validation[$field] as $rule){
            if($this->{$rule['rule']}($this->data[$field]) === false){
                $this->errors[$field] = $rule;
            }
        }
    }

    public function error($field){
        if(!empty($this->errors[$field])){
            return $this->errors[$field]['message'];
        }

        return false;
    }

}

$valid = new Validate();

$input = filter_input_array(INPUT_POST);

if(!empty($input)){

    $valid->validation = [
        'first_name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter your first name'
        ]],
        'last_name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter your last name'
        ]],
        'email'=>[[
                'rule'=>'email',
                'message'=>'Please enter a valid email'
            ],[
                'rule'=>'notEmpty',
                'message'=>'Please enter an email'
        ]],
        'url'=>[[
                'rule'=>'url',
                'message'=>'Please enter a valid url'
        ]],
        'subject'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a subject'
        ]],
        'message'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please add a message'
        ]],
    ];


    $valid->check($input);
}


if(empty($valid->errors) && !empty($input)){


    $domain = MG_DOMIAN;
    # Make the call to the client.
    $from = "Mailgun Sandbox <postmaster@{$domain}>";
    $to = "Jason Snider <jason@jasonsnider.com>";
    $subject = "Contact Form: {$input['subject']}";
    $text = "{$input['first_name']}  {$input['last_name']} <{$input['email']}>"
        . "\n{$input['subject']}\n{$input['body']}>";

    $result = $mgClient->sendMessage(
      $domain,
      array('from'    => $from,
            'to'      => $to,
            'subject' => $subject,
            'text'    => $text
        )
    );
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Single Page App with a Validation Class</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>

    <?php if(empty($valid->errors) && !empty($input)): ?>
      <div>Success!</div>
    <?php else: ?>
      <div>You page has errors.</div>
    <?php endif; ?>

    <form method="post" action="contact.php">

      <div>
        <label for="firstName">First Name</label><br>
        <input type="text" name="first_name" id="firstName">
        <div style="color: #ff0000;"><?php echo $valid->error('first_name'); ?></div>
      </div>

      <div>
        <label for="lastName" id="lastName">Last Name</label><br>
        <input type="text" name="last_name">
        <div style="color: #ff0000;"><?php echo $valid->error('last_name'); ?></div>
      </div>

      <div>
        <label for="email" id="email">Email</label><br>
        <input type="text" name="email">
        <div style="color: #ff0000;"><?php echo $valid->error('email'); ?></div>
      </div>

      <div>
        <label for="url" id="url">URL</label><br>
        <input type="text" name="url">
        <div style="color: #ff0000;"><?php echo $valid->error('url'); ?></div>
      </div>

      <div>
        <label for="subject" id="subject">Subject</label><br>
        <input type="text" name="subject">
        <div style="color: #ff0000;"><?php echo $valid->error('subject'); ?></div>
      </div>

      <div>
        <label for="message" id="message">Message</label><br>
        <textarea name="message"></textarea>
        <div style="color: #ff0000;"><?php echo $valid->error('message'); ?></div>
      </div>

      <input type="submit">

    </form>
  </body>
</html>
