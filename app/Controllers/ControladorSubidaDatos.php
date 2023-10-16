<?php

namespace App\Controllers;

use Exception;
use Kint\Parser\ToStringPlugin;

use App\Models\ModelMatrizGraduados;

//carrera tipo
use App\Models\ModelCarreraTipo;
//condicion
use App\Models\ModelCondicion;
//modalidad
use App\Models\ModalidadModTitulacion;
//periodo
use App\Models\ModelFEPeriodo;
//carrera
use App\Models\ModelFEcarreras;


class ControladorSubidaDatos extends BaseController
{

    //*subida datos menu
    public function subidaDatos()
    {
        try {

            echo view('header');
            echo view('subida/menuDatos');
            echo view('footer');
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    //*subida datos manual
    public function subirManualmente()
    {
        try {

            //matriz
            $objEstadMatr = new ModelMatrizGraduados();
            //carrera tipo
            $objCarreraTipo = new ModelCarreraTipo();
            //condicion
            $objCondicion = new ModelCondicion();
            //modalidad
            $objModalidad = new ModalidadModTitulacion();
            //periodo
            $objPeriodo = new ModelFEPeriodo();
            //carrera
            $objCarrera = new ModelFEcarreras();

            $data['tbl_estadistica_matriz'] = $objEstadMatr->verModelo();
            $data['tbl_carrera_tipo'] = $objCarreraTipo->verModelo();
            $data['tbl_estudiante'] = $objCondicion->verModelo();
            $data['tbl_modalida_titulacion'] = $objModalidad->verModelo();
            $data['tbl_periodo'] = $objPeriodo->verModelo();
            $data['tbl_carrera'] = $objCarrera->verModelo();


            echo view('header');
            echo view('subida/manualmente', $data);
            echo view('footer');
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    //*enviar datos manualmente post
    public function enviarManualmente()
    {
        try {

            //matriz
            $objEstadMatr = new ModelMatrizGraduados();
            //carrera tipo
            $objCarreraTipo = new ModelCarreraTipo();
            //condicion
            $objCondicion = new ModelCondicion();
            //modalidad
            $objModalidad = new ModalidadModTitulacion();
            //periodo
            $objPeriodo = new ModelFEPeriodo();
            //carrera
            $objCarrera = new ModelFEcarreras();

            //obtener datos
            $id_carrera_tipo = $this->request->getPost('id_carrera_tipo');
            $id_condicion = $this->request->getPost('id_condicion');
            $id_tipo_grado = $this->request->getPost('id_tipo_grado');
            $id_periodo = $this->request->getPost('id_periodo');
            $id_carrera = $this->request->getPost('id_carrera');
            $sede = $this->request->getPost('sede');

            $cantmasgen = $this->request->getPost('cantmasgen');
            $cantfemgen = $this->request->getPost('cantfemgen');
            $totalgen = $this->request->getPost('totalgen');


            //procesar datos dinamicamente
            //*etnia
            $indexetnia = $this->request->getPost('indexetnia');
            for ($i = 0; $i < $indexetnia; $i++) {
                $etnia[$i] = $this->request->getPost('etnia_' . $i);
                $cantmasetnia[$i] = $this->request->getPost('cantmasgenetnia_' . $i);
                $cantfemetnia[$i] = $this->request->getPost('cantfemgenetnia_' . $i);
            }

            //*nacionalidad
            $indexnacionalidad = $this->request->getPost('indexnacionalidad');
            for ($i = 0; $i < $indexnacionalidad; $i++) {
                $nacionalidad[$i] = $this->request->getPost('nacionalidad_' . $i);
                $cantmasnacionalidad[$i] = $this->request->getPost('cantmasgennacionalidad_' . $i);
                $cantfemnacionalidad[$i] = $this->request->getPost('cantfemgennacionalidad_' . $i);
            }

            //*genero
            $discgenmas = $this->request->getPost('discgenmas');
            $discgenfem = $this->request->getPost('discgenfem');

            //CLASIFICAR obtener los ids
            $id_carrera_tipop = $objCarreraTipo->obtenerId($id_carrera_tipo);
            $id_condicionp = $objCondicion->obtenerId($id_condicion);
            $id_tipo_gradop = $objModalidad->obtenerId($id_tipo_grado);
            $id_periodop = $objPeriodo->obtenerId($id_periodo);
            $id_carrerap = $objCarrera->obtenerId($id_carrera);

            //muestra
            {
                echo "carrera tipo: " . $id_carrera_tipo;
                echo "<br>";
                echo "carrera tipo id: " . $id_carrera_tipop['CTIP_ID'];
                echo "<br>";
                echo "condicion: " . $id_condicion;
                echo "<br>";
                echo "condicion id: " . $id_condicionp['EST_ID'];
                echo "<br>";
                echo "tipo grado: " . $id_tipo_grado;
                echo "<br>";
                echo "tipo grado id: " . $id_tipo_gradop['MODT_ID'];
                echo "<br>";
                echo "periodo: " . $id_periodo;
                echo "<br>";
                echo "periodo id: " . $id_periodop['PER_ID'];
                echo "<br>";
                echo "carrera: " . $id_carrera;
                echo "<br>";
                echo "carrera id: " . $id_carrerap['CAR_ID'];
                echo "<br>";
                echo "sede:" . $sede;
                echo "<br>";
                echo "cantmasgen: " . $cantmasgen;
                echo "<br>";
                echo "cantfemgen: " . $cantfemgen;
                echo "<br>";
                echo "totalgen: " . $totalgen;
                echo "<br>";
                echo "<br>";
                echo "indexetnia: " . $indexetnia;
                echo "<br>";
                //etnias
                for ($i = 0; $i < $indexetnia; $i++) {
                    //obtener los datos y almacenar en un array
                    echo "etnia: " . $etnia[$i];
                    echo "<br>";
                    echo "cantmasetnia: " . $cantmasetnia[$i];
                    echo "<br>";
                    echo "cantfemetnia: " . $cantfemetnia[$i];
                    echo "<br>";
                }
                echo "<br>";
                echo "indexnacionalidad: " . $indexnacionalidad;
                echo "<br>";
                //nacionalidades
                for ($i = 0; $i < $indexnacionalidad; $i++) {
                    //obtener los datos y almacenar en un array
                    echo "nacionalidad: " . $nacionalidad[$i];
                    echo "<br>";
                    echo "cantmasnacionalidad: " . $cantmasnacionalidad[$i];
                    echo "<br>";
                    echo "cantfemnacionalidad: " . $cantfemnacionalidad[$i];
                    echo "<br>";
                }
                echo "<br>";
                echo "discgenmas: " . $discgenmas;
                echo "<br>";
                echo "discgenfem: " . $discgenfem;
                echo "<br>";
            }

            //preprocesamiento de datos para enviar a la base de datos
            $ESTM_TIPO = $id_carrera_tipop['CTIP_ID'];
            $ESTM_CONDICION = $id_condicionp['EST_ID'];
            $ESTM_TIPO_GRADO = $id_tipo_gradop['MODT_ID'];
            $ESTM_PERIODO = $id_periodop['PER_ID'];
            $ESTM_CARRERA = $id_carrerap['CAR_ID'];
            $ESTM_GENERO_H = $cantmasgen;
            $ESTM_GENERO_M = $cantfemgen;

            //encerado de variables
            $ESTM_ETNIA_MESTIZO_H = 0;
            $ESTM_ETNIA_MESTIZO_M = 0;
            $ESTM_ETNIA_INDIGENA_H = 0;
            $ESTM_ETNIA_INDIGENA_M = 0;
            $ESTM_ETNIA_AFRO_H = 0;
            $ESTM_ETNIA_AFRO_M = 0;
            $ESTM_ETNIA_MONTUBIO_H = 0;
            $ESTM_ETNIA_MONTUBIO_M = 0;
            $ESTM_ETNIA_MULATO_H = 0;
            $ESTM_ETNIA_MULATO_M = 0;
            $ESTM_ETNIA_NEGRO_H = 0;
            $ESTM_ETNIA_NEGRO_M = 0;
            $ESTM_ETNIA_BLANCO_H = 0;
            $ESTM_ETNIA_BLANCO_M = 0;
            $ESTM_NACIONALIDAD_EC_H = 0;
            $ESTM_NACIONALIDAD_EC_M = 0;
            $ESTM_NACIONALIDAD_COL_H = 0;
            $ESTM_NACIONALIDAD_COL_M = 0;
            $ESTM_NACIONALIDAD_ESP_H = 0;
            $ESTM_NACIONALIDAD_ESP_M = 0;
            $ESTM_NACIONALIDAD_FRA_H = 0;
            $ESTM_NACIONALIDAD_FRA_H = 0;
            $ESTM_NACIONALIDAD_FRA_M = 0;
            $ESTM_NACIONALIDAD_USA_H = 0;
            $ESTM_NACIONALIDAD_USA_M = 0;
            $ESTM_NACIONALIDAD_PER_H = 0;
            $ESTM_NACIONALIDAD_PER_M = 0;
            $ESTM_NACIONALIDAD_RUM_H = 0;
            $ESTM_NACIONALIDAD_RUM_M = 0;
            $ESTM_NACIONALIDAD_CUB_H = 0;
            $ESTM_NACIONALIDAD_CUB_M = 0;
            $ESTM_NACIONALIDAD_URC_H = 0;
            $ESTM_NACIONALIDAD_URC_M = 0;
            $ESTM_NACIONALIDAD_VEN_H = 0;
            $ESTM_NACIONALIDAD_VEN_M = 0;
            $ESTM_DISCAPACIDAD_H = 0;
            $ESTM_DISCAPACIDAD_M = 0;

            if ($indexetnia != 0) {
                for ($i = 0; $i < $indexetnia; $i++) {
                    if ($etnia[$i] == "MESTIZO") {
                        $ESTM_ETNIA_MESTIZO_H = $cantmasetnia[$i];
                        $ESTM_ETNIA_MESTIZO_M = $cantfemetnia[$i];
                    } else if ($etnia[$i] == "INDIGENA") {
                        $ESTM_ETNIA_INDIGENA_H = $cantmasetnia[$i];
                        $ESTM_ETNIA_INDIGENA_M = $cantfemetnia[$i];
                    } else if ($etnia[$i] == "Afroecuatoriano") {
                        $ESTM_ETNIA_AFRO_H = $cantmasetnia[$i];
                        $ESTM_ETNIA_AFRO_M = $cantfemetnia[$i];
                    } else if ($etnia[$i] == "Montubio") {
                        $ESTM_ETNIA_MONTUBIO_H = $cantmasetnia[$i];
                        $ESTM_ETNIA_MONTUBIO_M = $cantfemetnia[$i];
                    } else if ($etnia[$i] == "Mulato") {
                        $ESTM_ETNIA_MULATO_H = $cantmasetnia[$i];
                        $ESTM_ETNIA_MULATO_M = $cantfemetnia[$i];
                    } else if ($etnia[$i] == "Negro") {
                        $ESTM_ETNIA_NEGRO_H = $cantmasetnia[$i];
                        $ESTM_ETNIA_NEGRO_M = $cantfemetnia[$i];
                    } else if ($etnia[$i] == "Blanco") {
                        $ESTM_ETNIA_BLANCO_H = $cantmasetnia[$i];
                        $ESTM_ETNIA_BLANCO_M = $cantfemetnia[$i];
                    }
                }
            }

            if ($indexnacionalidad != 0) {
                for ($i = 0; $i < $indexnacionalidad; $i++) {
                    if ($nacionalidad[$i] == "Ecuatoriana") {
                        $ESTM_NACIONALIDAD_EC_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_EC_M = $cantfemnacionalidad[$i];
                    } else if ($nacionalidad[$i] == "Colombiana") {
                        $ESTM_NACIONALIDAD_COL_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_COL_M = $cantfemnacionalidad[$i];
                    } else if ($nacionalidad[$i] == "Española") {
                        $ESTM_NACIONALIDAD_ESP_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_ESP_M = $cantfemnacionalidad[$i];
                    } else if ($nacionalidad[$i] == "Francesa") {
                        $ESTM_NACIONALIDAD_FRA_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_FRA_M = $cantfemnacionalidad[$i];
                    } else if ($nacionalidad[$i] == "Estadounidense") {
                        $ESTM_NACIONALIDAD_USA_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_USA_M = $cantfemnacionalidad[$i];
                    } else if ($nacionalidad[$i] == "Peruana") {
                        $ESTM_NACIONALIDAD_PER_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_PER_M = $cantfemnacionalidad[$i];
                    } else if ($nacionalidad[$i] == "Rumana") {
                        $ESTM_NACIONALIDAD_RUM_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_RUM_M = $cantfemnacionalidad[$i];
                    } else if ($nacionalidad[$i] == "Cubana") {
                        $ESTM_NACIONALIDAD_CUB_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_CUB_M = $cantfemnacionalidad[$i];
                    } else if ($nacionalidad[$i] == "Ucraniana") {
                        $ESTM_NACIONALIDAD_URC_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_URC_M = $cantfemnacionalidad[$i];
                    } else if ($nacionalidad[$i] == "Venezolana") {
                        $ESTM_NACIONALIDAD_VEN_H = $cantmasnacionalidad[$i];
                        $ESTM_NACIONALIDAD_VEN_M = $cantfemnacionalidad[$i];
                    }
                }
            }

            $ESTM_DISCAPACIDAD_H = $discgenmas;
            $ESTM_DISCAPACIDAD_M = $discgenfem;

            $ESTM_TOTAL = $totalgen;
            $ESTM_SEDE = $sede;
            $ESTM_ESTADO  = 0;

            //ENVIO A LA BD
            $datosInsertar = [
                'ESTM_ID' => null,
                'ESTM_TIPO' => $ESTM_TIPO,
                'ESTM_CONDICION' => $ESTM_CONDICION,
                'ESTM_TIPO_GRADO' => $ESTM_TIPO_GRADO,
                'ESTM_PERIODO' => $ESTM_PERIODO,
                'ESTM_CARRERA' => $ESTM_CARRERA,
                'ESTM_GENERO_H' => $ESTM_GENERO_H,
                'ESTM_GENERO_M' => $ESTM_GENERO_M,
                'ESTM_ETNIA_MESTIZO_H' => $ESTM_ETNIA_MESTIZO_H,
                'ESTM_ETNIA_MESTIZO_M' => $ESTM_ETNIA_MESTIZO_M,
                'ESTM_ETNIA_INDIGENA_H' => $ESTM_ETNIA_INDIGENA_H,
                'ESTM_ETNIA_INDIGENA_M' => $ESTM_ETNIA_INDIGENA_M,
                'ESTM_ETNIA_AFRO_H' => $ESTM_ETNIA_AFRO_H,
                'ESTM_ETNIA_AFRO_M' => $ESTM_ETNIA_AFRO_M,
                'ESTM_ETNIA_MONTUBIO_H' => $ESTM_ETNIA_MONTUBIO_H,
                'ESTM_ETNIA_MONTUBIO_M' => $ESTM_ETNIA_MONTUBIO_M,
                'ESTM_ETNIA_MULATO_H' => $ESTM_ETNIA_MULATO_H,
                'ESTM_ETNIA_MULATO_M' => $ESTM_ETNIA_MULATO_M,
                'ESTM_ETNIA_NEGRO_H' => $ESTM_ETNIA_NEGRO_H,
                'ESTM_ETNIA_NEGRO_M' => $ESTM_ETNIA_NEGRO_M,
                'ESTM_ETNIA_BLANCO_H' => $ESTM_ETNIA_BLANCO_H,
                'ESTM_ETNIA_BLANCO_M' => $ESTM_ETNIA_BLANCO_M,
                'ESTM_NACIONALIDAD_EC_H' => $ESTM_NACIONALIDAD_EC_H,
                'ESTM_NACIONALIDAD_EC_M' => $ESTM_NACIONALIDAD_EC_M,
                'ESTM_NACIONALIDAD_COL_H' => $ESTM_NACIONALIDAD_COL_H,
                'ESTM_NACIONALIDAD_COL_M' => $ESTM_NACIONALIDAD_COL_M,
                'ESTM_NACIONALIDAD_ESP_H' => $ESTM_NACIONALIDAD_ESP_H,
                'ESTM_NACIONALIDAD_ESP_M' => $ESTM_NACIONALIDAD_ESP_M,
                'ESTM_NACIONALIDAD_FRA_H' => $ESTM_NACIONALIDAD_FRA_H,
                'ESTM_NACIONALIDAD_FRA_M' => $ESTM_NACIONALIDAD_FRA_M,
                'ESTM_NACIONALIDAD_USA_H' => $ESTM_NACIONALIDAD_USA_H,
                'ESTM_NACIONALIDAD_USA_M' => $ESTM_NACIONALIDAD_USA_M,
                'ESTM_NACIONALIDAD_PER_H' => $ESTM_NACIONALIDAD_PER_H,
                'ESTM_NACIONALIDAD_PER_M' => $ESTM_NACIONALIDAD_PER_M,
                'ESTM_NACIONALIDAD_PER_M' => $ESTM_NACIONALIDAD_PER_M,
                'ESTM_NACIONALIDAD_RUM_H' => $ESTM_NACIONALIDAD_RUM_H,
                'ESTM_NACIONALIDAD_RUM_M' => $ESTM_NACIONALIDAD_RUM_M,
                'ESTM_NACIONALIDAD_CUB_H' => $ESTM_NACIONALIDAD_CUB_H,
                'ESTM_NACIONALIDAD_CUB_M' => $ESTM_NACIONALIDAD_CUB_M,
                'ESTM_NACIONALIDAD_URC_H' => $ESTM_NACIONALIDAD_URC_H,
                'ESTM_NACIONALIDAD_URC_M' => $ESTM_NACIONALIDAD_URC_M,
                'ESTM_NACIONALIDAD_VEN_H' => $ESTM_NACIONALIDAD_VEN_H,
                'ESTM_NACIONALIDAD_VEN_M' => $ESTM_NACIONALIDAD_VEN_M,
                'ESTM_DISCAPACIDAD_H' => $ESTM_DISCAPACIDAD_H,
                'ESTM_DISCAPACIDAD_M' => $ESTM_DISCAPACIDAD_M,
                'ESTM_TOTAL' => $ESTM_TOTAL,
                'ESTM_SEDE' => $ESTM_SEDE,
                'ESTM_ESTADO' => $ESTM_ESTADO
            ];

            $objEstadMatr->insertar($datosInsertar);

            echo "datos insertados correctamente";

            //redireccionar
            return redirect()->to(base_url() . 'index.php/subidaDatos/manualmente');
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    
}
