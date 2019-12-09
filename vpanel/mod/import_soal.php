<div class="box">
    <div class="box-header">
        <i class="fa fa-file-excel-o" style="font-size: 30px;"></i>
         Import Soal
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default1">
            Download File Excel Template Soal
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
                    <p>Anda akan file Excel template soal dengan extensi excel</p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='../download/soal.xls'">Lanjutkan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <hr/>
    <form action="" method="post" enctype="multipart/form-data">
    <div class="box-body">
        <label for="exampleInputFile">File input</label>
        <input type="file" name="soal" id="exampleInputFile">      
        <p class="help-block">File Excel dengan format khusus.</p>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default2">
            Upload
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
                    <p>Yakin akan melakukan import?</p>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
                    <button type="submit" name="import_soal" value="ok" class="btn btn-primary" onclick="">Ya</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.box-body -->
    </form>    
</div>