<?php 

class BookingFormValidator {

  private $data;
  private $errors = [];
  private static $fields = ['fullname', 'email', 'phonenumber'];

  public function __construct($post_data){
    $this->data = $post_data;
  }

  public function validateForm(){

    foreach(self::$fields as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' is not present in the data");
        return;
      }
    }

    $this->validateFullname();
    $this->validateEmail();
    $this->validatePhoneNumber();
    return $this->errors;

  }

  private function validateFullname(){

    $val = trim($this->data['fullname']);

    if(empty($val)){
      $this->addError('fullname', 'name cannot be empty');
    } else {
      if(!preg_match('/^[a-zA-Z ]*$/', $val)){
        $this->addError('fullname','name must be 6-70 characters and alphanumeric');
      }
    }

  }

  private function validateEmail(){

    $val = trim($this->data['email']);

    if(empty($val)){
      $this->addError('email', 'email cannot be empty');
    } else {
      if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
        $this->addError('email', 'email must be a valid email address');
      }
    }

  }

  private function validatePhoneNumber(){

    $val = trim($this->data['phonenumber']);

    if(empty($val)){
      $this->addError('phonenumber', 'phone number cannot be empty');
    }
  }

  private function addError($key, $val){
    $this->errors[$key] = $val;
  }

}

?>