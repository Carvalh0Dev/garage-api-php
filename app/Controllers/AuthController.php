<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends ResourceController {

    //Responsável pela criação do token JWT
     private function createToken($usuario) {
        $key = env('JWT_SECRET'); 

        $iat = time();
        $exp = $iat + 3600;

        $payload = [
            'iat' => $iat,
            'exp' => $exp,
            'data' => [
                'id_users' => $usuario['id_users'],
                'login' => $usuario['login']
            ]
        ];

        return \Firebase\JWT\JWT::encode($payload, $key, 'HS256');
    }
    
    //Realiza o login e gera o token JWT
    public function login() {

        $model = new UsuariosModel();

        $json = $this -> request -> getJSON();

        $login = $json -> login ?? null;
        $senha = $json -> senha ?? null;

        //buscar o usuario no banco
        $usuario = $model->where('login', $login)->first();

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            return $this->failUnauthorized('Login ou senha inválidos');
        }

        $token = $this->createToken($usuario);

        return $this->respond([
            'message' => 'Login realizado com sucesso',
            'token' => $token
        ]);
    }
}

?>