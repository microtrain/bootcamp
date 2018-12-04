var authApp = (function() {

  function loginForm(){
    let app = document.getElementById('app');

    let form =  `
      <div class="card login-form">
        <form id="loginForm" class="card-body">
          <h1 class="card-title text-center">Please Sign In</h1>
          <div id="formMsg" class="alert alert-danger text-center">Invalid username or password</div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
          </div>
          <div>
            <input type="submit" value="Sign In" class="btn btn-lg btn-primary btn-block">
          </div>
        </form>
      </div>
    `;

    app.innerHTML=form;
  }

  function registrationForm(){
    var app = document.getElementById('app');

    var form =  `

        <div class="card login-form">
          <form id="registrationForm" class="card-body" novalidate>
            <h1 class="card-title text-center">Create an Account</h1>
            <div id="formMsg" class="alert alert-danger text-center">Your form has errors</div>

            <div class="form-group">
              <label for="first_name">First Name</label>
              <input type="text" id="first_name" name="first_name" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" id="last_name" name="last_name" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>

            <div>
              <input type="submit" value="Sign In" class="btn btn-lg btn-primary btn-block">
            </div>
          </form>
        </div>
    `;

    app.innerHTML=form;
  }

  function postRequest(formId, url){
    let form = document.getElementById(formId);
    form.addEventListener('submit', function(e){
      e.preventDefault();

      let formData = new FormData(form);
      let uri = `${window.location.origin}${url}`;
      let xhr = new XMLHttpRequest();
      xhr.open('POST', uri);

      xhr.setRequestHeader(
        'Content-Type',
        'application/json; charset=UTF-8'
      );

      let object = {};
      formData.forEach(function(value, key){
        object[key]=value;
      });

      xhr.send(JSON.stringify(object));
      xhr.onload = function(){
        let data = JSON.parse(xhr.response);
        if(data.success===true){
          window.location.href = '/';
        }else{
          document.getElementById('formMsg').style.display='block';

        }
      }
    });
  }

  return {
    load: function(){
      registrationForm();
      postRequest('registrationForm', '/api/auth/register');
      validate.registrationForm();
    }
  }

})();

var validation = (function() {

  // return true for
  // empty, undefined, and blank
  function isBlank(str) {
      return (!str || /^\s*$/.test(str));
  }

  function match(a, b) {
    if(a === b){
      return true;
    }

    return false;
  }

  function notEmpty(str){
    return !isBlank(str);
  }

  function email(str, tld=true){
    if(tld){
      return /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]/.test(str)
    }else{
      return /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]/.test(str)
    }

  }

  function password(str){

    let lower = /^(?=.*[a-z]{1,})/;
    let upper = /^(?=.*[A-Z]{1,})/;
    let num = /^(?=.*[0-9]{1,})/;
    let special =  /^(?=.*[\`\~\!\@\#\$\%\^\&\*\(\)\_\+\=\[\]\\\|\{\}\:\;\'\"\<\>\,\-]{1,})/;
    let min = 8;

    if(!lower.test(str)){
      return false;
    }

    if(!upper.test(str)){
      return false;
    }

    if(!num.test(str)){
      return false;
    }

    if(!special.test(str)){
      return false;
    }

    if(str.length<min){
      return false;
    }

    return true;

    var pattern = new RegExp(regEx);
    console.log(regEx);
    return pattern.test(str)

    //return /^(?=.*[a-z]{1,})(?=.*[A-Z]{1,})(?=.*[0-9]{1,})(?=.*[\`\~\!\@\#\$\%\^\&\*\(\)\_\+\=\[\]\\\|\{\}\:\;\'\"\<\>\,\-]{1,})/.test(str);
  }

  return {
    test: function(){
      let pw = document.getElementById('email');
      console.log(password(pw.value));
    }
  }

})();

var validate = (function() {

  function confirmPasswordMatch() {

    let pw = document.getElementById('password');
    let cpw = document.getElementById('confirm_password');

    if(pw.value !== cpw.value){
      cpw.setCustomValidity("Passwords do not match");
    } else {
      cpw.setCustomValidity("");
    }

  }

  return {
    registrationForm: function(){
      document.querySelector('#registrationForm input[type="submit"]').addEventListener(
        'click',
        function(){
          validation.test();
        confirmPasswordMatch();
      });
    }
  }

})();

authApp.load();
