<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use CodeIgniter\RESTful\ResourceController;

class UsuariosController extends ResourceController {

    protected $modelName = 'App\Models\UsuariosModel';
    protected $format    = 'json';

    //Cria um novo usuário
    public function criarUsuario() {

        $rules = [
            'login' => 'required|min_length[3]|max_length[50]|is_unique[usuarios.login]',
            'senha' => 'required|min_length[6]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $data = [
            'login' => $this->request->getVar('login'),
            'senha' => password_hash($this->request->getVar('senha'), PASSWORD_BCRYPT)
        ];

        try {
            $this -> model -> insert($data);
            return $this->respondCreated([
                'status' => 201,
                'message' => 'Usuário criado com sucesso!'
            ]);
        } catch(\Exception $e) {
            return $this->failServerError('Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    //Lista todos os usuários
    public function listarUsuarios() {
        $usuarios = $this->model->findAll();
        return $this->respond($usuarios);
    }

    //Atualiza um usuário existente
    public function atualizarUsuario($id = null) {

        $this -> request -> getRawInput();
        $usuarios = $this->model->find($id);
        if (!$usuarios) {
            return $this->failNotFound('Usuário não encontrado');
        }

        $data = [
            'login' => $this->request->getVar('login'),
            'senha' => $this->request->getVar('senha') ? password_hash($this->request->getVar('senha'), PASSWORD_BCRYPT) : null
        ];

        $data = array_filter($data); // Remove valores nulos

        try {
            if ($this->model->update($id, $data)) {
                return $this->respond([
            'status' => 200,
            'message' => 'Usuário atualizado com sucesso!'
        ]);
            } else {
                return $this->fail($this->model->errors());
            }

        } catch(\Exception $e) {

            return $this->failServerError('Erro ao atualizar usuário: ' . $e->getMessage());

        }
    }

    //Deleta um usuário pelo ID
    public function deletarUsuario($id = null) {

        $usuarios = $this -> model -> find($id);
        if(!$usuarios) {
            return $this -> failNotFound('Usuário não encontrado');
        }

        $data = $this -> model -> delete($id);

        try {
            return $this -> respond([
                'status' => 200,
                'message' => 'Usuário deletado com sucesso!'
            ]);
        } catch(\Exception $e) {

            return $this -> failServerError('Erro ao deletar usuário: ' . $e -> getMessage());

        }   
    }
}
?>