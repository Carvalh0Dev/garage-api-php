<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model {
    protected $table = 'usuarios';
    protected $primaryKey = 'id_users';
    protected $allowedFields = [
        'login',
        'senha'
    ];
    protected $useTimestamps = false;
    protected $updatedField = '';
    protected $createdField = 'created_at';
    protected $validationRules = [
        'login' => 'required|min_length[3]',
        'senha' => 'required|min_length[6]'
    ];

}
?>