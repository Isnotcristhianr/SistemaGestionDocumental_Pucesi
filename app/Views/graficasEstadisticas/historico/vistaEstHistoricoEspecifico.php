
<div class="container-center m-5 p-3 bg-light rounded col-xs-6 shadow-lg p-3 mb-5 bg-body rounded">
    <!-- Volver -->
    <a href="<?php echo base_url('index.php/deHistorico') ?>" class="btn btn-outline-primary">← Volver</a>
    <div class="row ">
        <div class="col-12">
            <h2 class="text-center text-primary">Datos Estadísticos Historico PUCE-I Por Fechas
            </h2>
            <h4 class="text-center text-dark">Búsqueda
                 Desde: <?php echo $fechaInicio ?>
                  Hasta: <?php echo $fechaFin ?> </h4>
        </div>
        <div class="col-12">
            <h5 class="text-center text-secondary">↓ Reporte ↓</h5>
        </div>
    </div>
</div>
<!-- Contenido-->
<div class="container-center m-5 p-1 bg-light rounded col-xs-6 shadow-lg p-3 mb-5 bg-body rounded">
    <div class="container">
        <h4>Reporte</h4>
    </div>
    <!-- Reporte Estadistico -->
    <canvas id="myChart"></canvas>
    <!-- Grafica -->
    <!-- Script chartJs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <!-- Logica Grafica -->
    <script>
        //TODO: obtener datos de php del controlador
        var datos = <?php echo json_encode($tbl_estadistica_matriz) ?>;
        var peri = <?php echo json_encode($tbl_periodo) ?>;

        //preparar los datos para el grafico

        //! eje y -> total de estudiantes graduados y matriculados
        //? logica-> total
        //datos tiene: ESTM_TOTAL
        var total = datos.map(function(elem) {
            return elem.ESTM_TOTAL;
        });


        //! eje x 
        //? logica-> periodo
        //peri tiene: PER_ID, PER_ANO
        //datos tiene: ESTM_PERIODO, ESTM_TOTAL
        //se compara PER_ID con ESTM_PERIODO y si coinciden se guarda el PER_ANO
        /* 
        1.  ESTM_PERIODO coincide con PER_ID, entonces ESTM_TOTAL tiene un ESTM_ID
        2. Donde coincide se le asigna el ESTM_TOTAL a PER_ANO y se guarda en periodo
        3. Se repite el proceso hasta que se recorran todos los datos
        4. se ordena el arreglo periodo de menor a mayor
        5. se suman los valores de ESTM_TOTAL que coincidan con PER_ANO y se asigan al total
        */

        var periodo = [];
        for (var i = 0; i < datos.length; i++) {
            for (var j = 0; j < peri.length; j++) {
                if (datos[i].ESTM_PERIODO == peri[j].PER_ID) {
                    periodo.push(peri[j].PER_ANO);
                }
            }
        }
        var a = [],
            b = [],
            prev;
        periodo.sort();
        for (var i = 0; i < periodo.length; i++) {
            if (periodo[i] !== prev) {
                a.push(periodo[i]);
                b.push(1);
            } else {
                b[b.length - 1]++;
            }
            prev = periodo[i];
        }
        periodo = a;
        total = b;



        //grafico
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            //tipo de grafico
            type: 'line',
            data: {
                //datos
                labels: periodo,
                datasets: [{
                    label: 'Total de Graduados por Año Especifico',
                    data: total,
                    backgroundColor: [
                        'rgba(99, 119, 255, 0.3)',
                        'rgba(54, 162, 235, 0.2)',

                    ],
                    borderColor: [
                        'rgba(34, 131, 196, 1)',
                        'rgba(54, 162, 235, 1)',

                    ],
                    borderWidth: 1
                }]
            },

            options: {
                //titulo
                title: {
                    display: true,
                    text: 'Total de Estudiantes Histórico PUCE-I' + '\n' + '(<?php echo "Desde: ". $fechaInicio ?>-<?php echo "Hasta: ". $fechaFin ?>)',
                    fontSize: 15
                },
                //leyenda
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontColor: '#000'
                    }
                },
                //responsive
                responsive: true,
            },

            //ejes x y y
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Value'
                    }
                }
            }


        });
    </script>
    <br>
    <!-- Descarga -->
    <div class="container my-5">
        <div class="d-flex justify-content-center">
            <!-- Excel Exportar -->
            <a href="#" id="export" class="btn btn-success btn-sm m-2" hidden>
                <i class="fas fa-file-excel"></i> Exportar Datos a Excel
            </a>
            <!-- Exportar PDF -->
            <a href="#" id="exportPdf" class="btn btn-danger btn-sm  m-2" hidden>
                <i class="fas fa-file-pdf"></i> Exportar a PDF
            </a>
            <!-- Exportar Img -->
            <a href="#" id="exportImg" class="btn btn-warning btn-sm  m-2">
                <i class="fas fa-file-image"></i> Exportar a Imagen
            </a>
            <!-- Imprimir -->
            <a href="#" id="exportPrint" class="btn btn-info btn-sm  m-2">
                <i class="fas fa-print"></i> Imprimir
            </a>
            <!-- ENVIAR IMG A CORREO -->
            <a href="#" id="exportEmail" class="btn btn-secondary btn-sm  m-2">
                <i class="fas fa-envelope"></i> Enviar a Correo
            </a>
        </div>
    </div>

    <!-- Descargas -->
    <!-- Chartjs to pdf -->
    <script>
        //Exportar a pdf
        document.getElementById('exportPdf').addEventListener('click', function() {
            //obtener canvas
            var canvas = document.getElementById('myChart');
            //obtener imagen
            var img = canvas.toDataURL('image/png');
            //doc pdf
            var doc = new jsPDF();
            //descargar 
            doc.addImage(img, 'png', 10, 10);
        });

        //Exportar Img
        document.getElementById('exportImg').addEventListener('click', function() {
            //capturar canvas
            var canvas = document.getElementById('myChart');
            //obtener imagen
            var img = canvas.toDataURL('image/png');
            //descargar imagen
            var link = create = document.createElement('a');
            link.href = img;
            link.download = 'ReporteEstadisticoHistorico.png';
            //descargar
            link.click();
        });

        //Imprimir
        document.getElementById('exportPrint').addEventListener('click', function() {
            //capturar canvas
            var canvas = document.getElementById('myChart');
            //crear ventana para impresion
            var win = window.open("", "_blank");

            //agregar canvas a ventana emergente
            win.document.open();
            win.document.write('<html><head ><title>Total de Estudiantes Historico PUCE-I (1976-2022)</title></head><body onload="window.print()">');
            win.document.write('<img src="' + canvas.toDataURL("image/png") + '" alt="Gráfico" />');
            win.document.write('</body></html>');

            //imprimir
            win.onload = function() {
                win.print();
                win.close();
            }
        });

        //enviar a email
        document.getElementById('exportEmail').addEventListener('click', function() {
            //capturar canvas
            var canvas = document.getElementById('myChart');
            //obtener imagen
            var img = canvas.toDataURL('image/png');
            //crear ventana para enviar correo con img adjunta
            var win = window.open("mailto:?subject=Reporte Estadistico Historico PUCE-I&body=Gráfico Estadistico Historico PUCE-I (1976-2022)", "_blank");
        });
    </script>
</div>