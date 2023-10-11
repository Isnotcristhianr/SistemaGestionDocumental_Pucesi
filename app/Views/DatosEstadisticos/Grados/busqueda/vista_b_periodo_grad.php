<!-- Datos Estadisticos -->


<div class="container-center m-5 p-3 bg-light rounded col-xs-6 shadow-lg p-3 mb-5 bg-body rounded">
    <a href="<?php echo base_url('index.php/FiltroEstadisticoGradoBusqueda/Grado/Periodo') ?>" class="btn btn-outline-primary">
        <i class="fa-solid fa-caret-left"></i> Volver
    </a>
    <div class="row ">
        <div class="col-12">
            <h2 class="text-center text-primary">Datos Estadísticos Grado
            </h2>
            <h4 class="text-center text-dark">Búsqueda: Periodo
            </h4>
        </div>
        <div class="col-12 m-2">
            <h5 class="text-center text-secondary">↓ Graduados ↓
                <br>
                <a id="btnBox"></a>
            </h5>
        </div>
    </div>

    <!-- Contenido-->
    <h3 class="text text-start text-success">Oferta Académica Vigente</h3>
    <br>
    <table class="table table-success align-middle order-column hover row-border stripe " id="tbl">
        <thead>
            <th hidden>ID</th>
            <th>Seleccionar</th>
            <th>Año</th>
            <th>Periodo</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <!-- llenar toda la tabla con fecha de año actual-->
            <?php
            foreach ($tbl_periodo as $periodo) {
                if (
                    /* Logica obtener ultimo periodo
                    1. ultimo id
                    2. debe pertenecer al año actual
                    3. debe estar activo
                    */
                    $periodo['PER_ID'] == $tbl_periodo[0]['PER_ID'] && $periodo['PER_ANO'] == date('Y') && $periodo['PER_ULTIMO'] == 1
                ) {

            ?>
                    <tr>
                        <td hidden><?php echo $periodo['PER_ID']; ?></td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="seleccionar[]" value="<?php echo $periodo['PER_ID']; ?>">
                            </div>
                        </td>
                        <td><?php echo $periodo['PER_ANO']; ?></td>
                        <td><?php echo $periodo['PER_PERIODO']; ?></td>
                        <!-- Capturar id -->
                        <td>
                            <a href="<?php echo base_url('index.php/ReporteGradoPeriodoGraduados/' . $periodo['PER_ID']) ?>" class="btn btn-success">Datos <i class="fa-regular fa-circle-right"></i></a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>

        </tbody>
    </table>
</div>


<div class="container-center m-5 p-3 bg-light rounded col-xs-6 shadow-lg p-3 mb-5 bg-body rounded">
    <h3 class="text text-start text-primary">Oferta Académica Histórico</h3>
    <br>
    <!-- Llenar tabla con no ativas -->
    <table class="table table-primary align-middle order-column hover row-border stripe " id="tbl2">
        <thead>
            <th hidden>ID</th>
            <th>Seleccionar</th>
            <th>Año</th>
            <th>Periodo</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <!-- llenar toda la tabla sin contar el año actual-->
            <?php
            foreach ($tbl_periodo as $periodo) {
                if ($periodo['PER_ANO'] != date('Y')) {
            ?>
                    <tr>
                        <td hidden><?php echo $periodo['PER_ID']; ?></td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="seleccionar[]" value="<?php echo $periodo['PER_ID']; ?>">
                            </div>
                        </td>
                        <td><?php echo $periodo['PER_ANO']; ?></td>
                        <td><?php echo $periodo['PER_PERIODO']; ?></td>
                        <!-- Capturar id -->
                        <td>
                            <a href="<?php echo base_url('index.php/ReporteGradoPeriodoGraduados/' . $periodo['PER_ID']) ?>" class="btn btn-primary">Datos <i class="fa-regular fa-circle-right"></i></a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    // Obtener todos los checkboxes con name="seleccionar[]"
    const checkboxes = document.querySelectorAll('input[name="seleccionar[]"]');

    // Agregar un evento de cambio a cada checkbox
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            const valoresSeleccionados = Array.from(checkboxes)
                .filter((cb) => cb.checked)
                .map((cb) => cb.value);
        });

        //crear btn si hay al menos una seleccion
        checkbox.addEventListener('change', function() {
            if (document.querySelectorAll('input[name="seleccionar[]"]:checked').length > 0) {
                document.getElementById('btnBox').innerHTML = '<br><a href="#" class="btn btn-primary"><i class="fa-solid fa-circle-info p-1"></i>Generar Reporte Selección<i class="fa-solid fa-circle-info p-1"></i></a><br>';
            } else {
                document.getElementById('btnBox').innerHTML = '';
            }
        });
    });

    //al hacer click en btn capturar valores seleccionados 
    document.getElementById('btnBox').addEventListener('click', function() {
        const valoresSeleccionados = Array.from(checkboxes)
            .filter((cb) => cb.checked)
            .map((cb) => cb.value);

        alert(valoresSeleccionados);
    });
</script>