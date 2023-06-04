<?php

namespace App\Models;

use PDOException;

class AuthModel extends ModelBase
{

    public function __construct()
    {
        parent::__construct();

    }

    public function searchUser(string $username)
    {
        return $this->read(
            ['username', 'password'],
            'users',
            ['username'],
            ['='],
            [$username]
        );
    }

}
