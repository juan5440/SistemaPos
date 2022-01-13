<footer class="py-4 bg-light mt-auto">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Bendición de Dios &copy; Venta de medicamentos <?php echo date('Y');?></div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>
<script src="<?php echo base_url();?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url();?>/js/scripts.js"></script>
<script src="<?php echo base_url();?>/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url();?>/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url();?>/assets/demo/datatables-demo.js"></script>
<script>
    $('#modal-confirma').on('show.bs.modal', function(e){
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));  
    });
</script>
</body>
</html>
