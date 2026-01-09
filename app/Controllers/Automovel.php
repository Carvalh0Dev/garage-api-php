<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Automovel extends ResourceController {
    private $automovelModel;

    public function __construct() {
        $this -> automovelModel = new \App\Models\AutomovelModel();
    }

    //Lista todos os automoveis cadastrados (GET)
    public function listarAutomoveis() {

        $data = $this -> automovelModel -> findAll();

        return $this -> response -> setJSON($data);
    }

    //Cria/registra um novo automovel (POST)
    public function criarAutomovel() {

        $newAutomovel['placa'] = $this -> request -> getVar('placa');
        $newAutomovel['modelo'] = $this -> request -> getVar('modelo');
        $newAutomovel['proprietario'] = $this -> request -> getVar('proprietario');
        $newAutomovel['cor'] = $this -> request -> getVar('cor');
        $newAutomovel['grupo'] = $this -> request -> getVar('grupo');
        $newAutomovel['grupo'] = $this -> request -> getVar('grupo');
        $newAutomovel['valor_hora'] = $this -> request -> getVar('valor_hora');

        try {
            $this -> automovelModel -> insert($newAutomovel);
            $response = [
                'status' => 201,
                'error' => null,
                'message' => 'Automóvel criado com sucesso!'
            ];
            return $this -> response -> setJSON($response) -> setStatusCode(201);
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => 'Erro ao criar o automóvel: ' . $e -> getMessage()
            ];
            return $this -> response -> setJSON($response) -> setStatusCode(500);
        }
        
    }

    //Atualiza um automovel existente (PUT)
    public function atualizarAutomovel($id) {
        
        $updatedAutomovel['placa'] = $this -> request -> getVar('placa');
        $updatedAutomovel['modelo'] = $this -> request -> getVar('modelo');
        $updatedAutomovel['proprietario'] = $this -> request -> getVar('proprietario');
        $updatedAutomovel['cor'] = $this -> request -> getVar('cor');
        
        try {
            $this -> automovelModel -> update($id, $updatedAutomovel);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => 'Automóvel atualizado com sucesso!'
            ];
            return $this -> response -> setJSON($response) -> setStatusCode(200);
         } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => 'Erro ao atualizar o automóvel: '. $e -> getMessage()
            ];
            return $this -> response -> setJSON($response) -> setStatusCode(500);
         }
    }

    //Deleta o carro (DELETE) - Registra a saída do automóvel e calcula o valor da estadia
    public function deletarAutomovel ($id) {
        try {
            $automovel = $this -> automovelModel -> withDeleted() -> find($id);

            if (!$automovel) {
                throw new \Exception("Automóvel não encontrado.");
            }

            $this -> automovelModel -> delete($id);

            $entrada = $automovel['created_at'];
            $saida = date('Y-m-d H:i:s');

            $estadia = $this -> automovelModel -> calcularEstadia($id, $entrada, $saida);

            $response = [
                'status' => 200,
                'error' => null,
                'message' => 'Automóvel deletado com sucesso!',
                'horas_estadia' => $estadia['horas'],
                'valor_total' => $estadia['valor_total']
            ];

            return $this -> response -> setJSON($response) -> setStatusCode(200);
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => 'Erro ao deletar o automóvel: ' . $e -> getMessage()
            ];
            return $this -> response -> setJSON($response) -> setStatusCode(500);
        }
    }
}
?>