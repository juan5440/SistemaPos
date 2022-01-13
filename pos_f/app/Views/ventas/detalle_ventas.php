
<!-- files needed for datatables installation --> 
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo;?></h4>
            <a href="<?php echo base_url();?>/ventas/inprimir" class="btn btn-danger" title="Exporta todos los registos" ><i class="fas fa-file-pdf"></i></a>
            <button class="btn btn-success" onclick="exportTableToExcel('dataTable')" title="Exporta en excel los registros visuales de la tabla"><i class="fas fa-file-excel"></i></button>
            <br>
            <div class="row">
                <p style="font-weight: bold;">Busqueda entre Fechas:</p>
                <div class="col-sm-4 ">
                    <input type="date" id="min" name="min" class="form-control">
                </div>
                <span class="input-group-addon">Hasta</span>
                <div class="col-sm-4 ">
                    <input type="date" id="max" name="max" class="form-control">
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing>
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Fecha</th>
                            <th>Factura</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio compra</th>
                            <th>Precio Venta</th>
                            <th>Total</th>
                            <th>Debito Fiscal</th>
                            <th>Rentabilidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1;?>
                        <?php foreach ($datos as $dato) { ?>
                            <tr>
                                <td><?php echo $contador;?></td>
                                <td><?php echo $dato['fecha_alta'];?></td>
                                <td><?php echo $dato['factura'];?></td>
                                <td><?php echo $dato['codigo'];?></td>
                                <td><?php echo $dato['nombre'];?></td>
                                <td><?php echo $dato['cantidad'];?></td>
                                <td>$ <?php echo $dato['precioC'];?></td>
                                <td>$ <?php echo $dato['precio'];?></td>

                                <td>$ <?php $vtotal = number_format($dato['cantidad'] * $dato['precio'], 2, '.', ',');?><?php echo $vtotal;?></td>
                                <?php 

                                $valor = 1.13;
                                $debito = 0.13;
                                $iva = number_format($vtotal / $valor * $debito , 2, '.', ','); ?>
                                <td>$ <?php echo $iva;?></td>

                                <?php $renta = number_format($dato['precio'] - $dato['precioC'], 2, '.', ',');?>
                                <td>$ <?php echo $renta;?></td>
                                <?php $contador++; ?>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
  
 <!-- Modal -->
 <script>
    $(document).ready(function() {

        $.fn.dataTableExt.afnFiltering.push(
            function( oSettings, aData, iDataIndex ) {
                var iFini = document.getElementById('min').value;
                var iFfin = document.getElementById('max').value;
                var iStartDateCol = 1;
                var iEndDateCol = 1;

                iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
                iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);

                var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
                var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);

                if ( iFini === "" && iFfin === "" )
                {
                    return true;
                }
                else if ( iFini <= datofini && iFfin === "")
                {
                    return true;
                }
                else if ( iFfin >= datoffin && iFini === "")
                {
                    return true;
                }
                else if (iFini <= datofini && iFfin >= datoffin)
                {
                    return true;
                }
                return false;
            }
            );

        $(document).ready(function() {
           var table = $('#dataTable').DataTable();

             // Add event listeners to the two range filtering inputs
             $('#min').keyup( function() { table.draw(); } );
             $('#max').keyup( function() { table.draw(); } );
         } );

    });

    function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        
    // Specify file name
    filename = filename?filename+'.xls':'R_venta.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}


</script>


