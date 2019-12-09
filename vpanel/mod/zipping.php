<div class="box">
    <div class="box-header">
        <img src="./assets/appbar.cabinet.files.png" width="48"> Menggenerate Paket Data
    </div>
    <!-- /.box-header -->
<?php
    $fi = new FilesystemIterator('../images/', FilesystemIterator::SKIP_DOTS);    
    $jml=iterator_count($fi);
    $jmldownload=ceil($jml/100);
?>    
    <div class="box-body">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default1">
            Generate <?= $jmldownload ?> Paket untuk <?= $jml ?> Gambar!
        </button>        
    </div>
    <div class="modal fade" id="modal-default1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <p>Anda akan menggenerate <?= $jmldownload ?> paket untuk <?= $jml ?> gambar soal&hellip;</p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="pop()">Lakukan Kompres  Gambar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <hr/>
    <div class="box-body">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default2">
            Generate <?= $jml ?> Gambar kedalam 1 Paket!
        </button>        
    </div>
    <div class="modal fade" id="modal-default2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <p>Anda akan menggenerate 1 paket untuk <?= $jml ?>gambar soal&hellip;</p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="pop3()">Lakukan Kompres  Gambar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <hr/>
    <div class="box-body">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default" disabled>
            Generate Paket Patching Tingkat Dasar!
        </button>        
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <p>Anda akan menggenerate paket gambar soal&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="pop1()">Lakukan Kompres Gambar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <hr/>
    <div class="box-body">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default" disabled>
            Generate Paket Patching Tingkat Lanjut!
        </button>        
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <p>Anda akan menggenerate paket gambar soal&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="pop2()">Lakukan Kompres Gambar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.box-body -->

</div>
<script>
    function pop() {
        myWindow = window.open("<?php echo "$namaserver/vpanel/zipping_img.php"; ?>", "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=300,height=300");
    }
    function pop3() {
        myWindow = window.open("<?php echo "$namaserver/vpanel/zipping_imgall.php"; ?>", "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=300,height=300");
    }
    function pop1() {
        myWindow = window.open("<?php echo "$namaserver/vpanel/zipping_patch1.php"; ?>", "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=300,height=300");
    }
    function pop2() {
        myWindow = window.open("<?php echo "$namaserver/vpanel/zipping_patch2.php"; ?>", "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=300,height=300");
    }

</script>
