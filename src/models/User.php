<?php

class User extends Model {

    protected static $table = "users";
    protected static $columns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin'
    ];

    public function getActiveUsersCount()
    {
        return $this->getUsersCount();
    }

    public function insert()
    {
        $this->validate();

        if(!$this->getValue('end_date')) {
            $this->setValue('end_date', null);
        }

        if($this->getValue('is_admin')) {
            $this->setValue('is_admin', 1);
        } else {
            $this->setValue('is_admin', 0);
        }

        $this->setValue('password', password_hash($this->getValue('password'), PASSWORD_DEFAULT));

        return parent::insert();
    }

    public function update()
    {
        $this->validate();

        if(!$this->getValue('end_date')) {
            $this->setValue('end_date', null);
        }

        if($this->getValue('is_admin')) {
            $this->setValue('is_admin', 1);
        } else {
            $this->setValue('is_admin', 0);
        }

        $this->setValue('password', password_hash($this->getValue('password'), PASSWORD_DEFAULT));

        return parent::update();
    }

    private function validate() {
        $errors = [];

        if(!$this->getValue('name')) {
            $errors['name'] = 'Nome é um campo obrigatório';
        }

        if(!$this->getValue('email')) {
            $errors['email'] = 'E-mail é um campo obrigatório';
        } elseif(!filter_var($this->getValue('email'), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Informe um e-mail válido';
        }

        if(!$this->getValue('start_date')) {
            $errors['start_date'] = 'Data de admissão é um campo obrigatório';
        } elseif(!DateTime::createFromFormat('Y-m-d', $this->getValue('start_date'))) {
            $errors['start_date'] = 'Data de admissão precisar estar no padrão dd/mm/aaaa';
        }

        if($this->getValue('end_date') && !DateTime::createFromFormat('Y-m-d', $this->getValue('end_date'))) {
            $errors['end_date'] = 'Data de desligamento precisar estar no padrão dd/mm/aaaa';
        }

        if(!$this->getValue('password')) {
            $errors['password'] = 'Senha é um campo obrigatório';
        }

        if(!$this->getValue('confirm_password')) {
            $errors['confirm_password'] = 'Confirmação de senha é um campo obrigatório';
        }

        if($this->getValue('password') && $this->getValue('confirm_password') && $this->getValue('password') !== $this->getValue('confirm_password')) {
            $errors['password'] = 'As senhas informadas não são iguais';
            $errors['confirm_password'] = 'As senhas informadas não são iguais';
        }

        if(count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

}