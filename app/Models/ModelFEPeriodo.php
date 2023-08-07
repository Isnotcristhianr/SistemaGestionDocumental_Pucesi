<?php
namespace App\Models;

use CodeIgniter\Model;

class ModelFEPeriodo extends Model{
    protected $table =  'tbl_periodo';
    protected $primaryKey = 'PER_ID';

    protected $allowedFields = ['PER_ANO','PER_PERIODO'];

    /* Contar total periodos filas Grados*/
    public function contarPeriodos(){
        $periodos = $this->findAll();
        return count($periodos);
    }

    /* Contar total periodos filas Posgrados*/
    public function contarPeriodosPosgrados(){
        //contar desde 1997 fecha posgrados
        $periodos = $this->where('PER_ANO >=', 1997)->findAll();
        return count($periodos);
    }


    /* Contar total periodos filas Tecnologias*/
    public function contarPeriodosTecnologias(){
        //contar desde 2021
        $periodos = $this->where('PER_ANO >=', 2021)->findAll();
        return count($periodos);
    }
}
