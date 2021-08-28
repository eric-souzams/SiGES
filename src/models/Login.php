<?php

class Login extends Model {

    public function __construct(array $data)
    {
        $this->loadData($data);
    }

    public function validadeLogin() {
        $errors = [];

        if(!$this->getValue('email')) {
            $errors['email'] = 'E-mail é um campo obrigatorio.';
        }

        if(!$this->getValue('password')) {
            $errors['password'] = 'Senha é um campo obrigatorio.';
        }

        if(count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

    public function checkLogin() {
        $this->validadeLogin();

        $user = new User();
        $user = $user->findByEmail($this->getValue('email'));

        if(isset($user['end_date'])) {
            throw new AppException('Este usuario foi desligado da empresa.');
        }

        if($user) {
            if(password_verify($this->getValue('password'), $user['password'])) {
                return $user;
            }
        }
        throw new AppException("Usuario ou senha invalidos.");
    }
    
}