<?php

namespace App\Models;

use CodeIgniter\Model;

class AutomovelModel extends Model { 
    protected $table = 'automovel';
    protected $primaryKey = 'id_automovel';
    protected $allowedFields = [
        'placa',
        'modelo',
        'proprietario',
        'cor', 
        'grupo',
        'valor_hora' 
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $updatedField = '';
    protected $createdField = 'created_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = [
        'placa' => 'required|min_length[7]',
        'modelo' => 'required',
        'proprietario' => 'required',
        'cor' => 'required',
        'grupo' => 'required',
        'valor_hora' => 'required|decimal'
    ];

    //Calcula o valor da estadia dos automoveis com base no tempo de entrada e saída
    public function calcularEstadia($id) {

        $automovel = $this ->withDeleted() -> find($id);

        if (!$automovel) {
            throw new \Exception("Automóvel não encontrado.");
        }

        $entrada = strtotime($automovel['created_at']);

        $saida = $automovel['deleted_at'] ? strtotime($automovel['deleted_at']) : time();

        $diferencaSegundos = $saida - $entrada;
        $horas = ceil($diferencaSegundos / 3600);

        $valorTotal = $horas * $automovel['valor_hora'];

        return [
            'horas' => $horas,
            'valor_total' => $valorTotal
        ];
    }
}
?>