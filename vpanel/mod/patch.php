<div class="box">
    <div class="box-header">
        <img src="./assets/appbar.cabinet.files.png" width="48"> Patching Data
    </div>
    <!-- /.box-header -->
    <div class="box">
        <div class="box-header">
            Modul ini hanya perlu jika terdapat perbedaan data antara server pusat dan sekolah<br />Klik patch satu persatu<br />Setelah mengklik tombol download, tunggu beberapa saat!<br />Sampai muncul notifikasi update selesai.
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-striped">
                <tr>
                    <th style="width: 30px">#</th>
                    <th style="width: 200px">Paket</th>
                    <th style="width: 100px">Ukuran</th>
                    <th>Progress</th>
                    <th style="width: 80px">Status</th>
                </tr>
<?php
    $url = "$server_pusat/patch/patch_css.zip";
    $zipFile = "./patch/patch_css.zip";
    $head = array_change_key_case(get_headers("$url", TRUE));
    $persen=(filesize($zipFile)/$head['content-length'])*100;
    if ($persen==100) { $dis='disabled'; $t='Done'; }
    elseif ($persen>100) { $dis='disabled'; $persen=0; $t='None'; }
    else { $dis=''; $t='Patch'; }                
?>
                <tr>
                    <td>1.</td>
                    <td>Style</td>
                    <td><?php echo $head['content-length']; ?></td>
                    <td>
                        <div class="progress progress-xs">
                            <div id="myBar[1]" class="progress-bar progress-bar-primary" style="width: <?= $persen ?>%"></div>
                        </div>
                    </td>
                    <script>
                        function move(a) {
                            var elem = document.getElementById("myBar[" + a + "]");
                            var width = 1;
                            var id = setInterval(frame, 10);
                            var r = Math.floor(Math.random() * 10) + 90;

                            function frame() {
                                if (width >= r) {
                                    clearInterval(id);
                                } else {
                                    width++;
                                    elem.style.width = width + '%';
                                }
                            }
                        }

                    </script>
                    <td>
                        <button type="button" class="btn btn-block btn-primary btn-xs" name="patch1" onclick="move(1); if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(1)" <?= $dis ?> ><?= $t ?></button>
                    </td>
                </tr>
<?php
    $url = "$server_pusat/patch/patch_ass.zip";
    $zipFile = "./patch/patch_ass.zip";
    $head = array_change_key_case(get_headers("$url", TRUE));
    $persen='';                             
    $persen=(filesize($zipFile)/$head['content-length'])*100;
    if ($persen==100) { $dis='disabled'; $t='Done'; }
    elseif ($persen>100) { $dis='disabled'; $persen=0; $t='None'; }
    else { $dis=''; $t='Patch'; }                
?>
                
                <tr>
                    <td>2.</td>
                    <td>Aset</td>
                    <td><?php echo $head['content-length']; ?></td>
                    <td>
                        <div class="progress progress-xs">
                            <div id="myBar[2]" class="progress-bar progress-bar-primary" style="width: <?= $persen ?>%"></div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-primary btn-xs" name="patch2" onclick="move(2); if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(2)" <?= $dis ?> ><?= $t ?></button>
                    </td>
                </tr>
<?php
    $url = "$server_pusat/patch/patch_ui.zip";
    $zipFile = "./patch/patch_ui.zip";
    $head = array_change_key_case(get_headers("$url", TRUE));
    $persen=(filesize($zipFile)/$head['content-length'])*100;
    if ($persen==100) { $dis='disabled'; $t='Done'; }
    elseif ($persen>100) { $dis='disabled'; $persen=0; $t='None'; }
    else { $dis=''; $t='Patch'; }                
?>                
                <tr>
                    <td>3.</td>
                    <td>Interface</td>
                    <td><?php echo $head['content-length']; ?></td>
                    <td>
                        <div class="progress progress-xs">
                            <div id="myBar[3]" class="progress-bar progress-bar-primary" style="width: <?= $persen ?>%"></div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-primary btn-xs" name="patch3" onclick="move(3); if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(3)" <?= $dis ?> ><?= $t ?></button>
                    </td>
                </tr>
  <?php
    $url = "$server_pusat/patch/patch_adm.zip";
    $zipFile = "./patch/patch_adm.zip";
    $head = array_change_key_case(get_headers("$url", TRUE));
    $persen=(filesize($zipFile)/$head['content-length'])*100;
    if ($persen==100) { $dis='disabled'; $t='Done'; }
    elseif ($persen>100) { $dis='disabled'; $persen=0; $t='None'; }
    else { $dis=''; $t='Patch'; }                
?>
                <tr>
                    <td>4.</td>
                    <td>Modul</td>
                    <td><?php echo $head['content-length']; ?></td>
                    <td>
                        <div class="progress progress-xs">
                            <div id="myBar[4]" class="progress-bar progress-bar-primary" style="width: <?= $persen ?>%"></div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-primary btn-xs" name="patch4" onclick="move(4); if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(4)" <?= $dis ?> ><?= $t ?></button>
                    </td>
                </tr>
  <?php
    $url = "$server_pusat/patch/patch_mas.zip";
    $zipFile = "./patch/patch_mas.zip";
    $head = array_change_key_case(get_headers("$url", TRUE));
    $persen=(filesize($zipFile)/$head['content-length'])*100;
    if ($persen==100) { $dis='disabled'; $t='Done'; }
    elseif ($persen>100) { $dis='disabled'; $persen=0; $t='None'; }
    else { $dis=''; $t='Patch'; }                
?>              <tr>
                    <td>5.</td>
                    <td>Back Door</td>
                    <td><?php echo $head['content-length']; ?></td>
                    <td>
                        <div class="progress progress-xs">
                            <div id="myBar[5]" class="progress-bar progress-bar-primary" style="width: <?= $persen ?>%"></div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-primary btn-xs" name="patch5" onclick="move(5); if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(5)" <?= $dis ?> ><?= $t ?></button>
                    </td>
                </tr>
  <?php
    $url = "$server_pusat/patch/patch_bin.zip";
    $zipFile = "./patch/patch_bin.zip";
    $head = array_change_key_case(get_headers("$url", TRUE));
    $persen=(filesize($zipFile)/$head['content-length'])*100;
    if ($persen==100) { $dis='disabled'; $t='Done'; }
    elseif ($persen>100) { $dis='disabled'; $persen=0; $t='None'; }
    else { $dis=''; $t='Patch'; }                
?>              <tr>
                    <td>6.</td>
                    <td>Bin</td>
                    <td><?php echo $head['content-length']; ?></td>
                    <td>
                        <div class="progress progress-xs">
                            <div id="myBar[6]" class="progress-bar progress-bar-primary" style="width: <?= $persen ?>%"></div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-primary btn-xs" name="patch5" onclick="move(6); if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(6)" <?= $dis ?> ><?= $t ?></button>
                    </td>
                </tr>
  <?php
    $url = "$server_pusat/patch/patch_aud.zip";
    $zipFile = "./patch/patch_aud.zip";
    $head = array_change_key_case(get_headers("$url", TRUE));
    $persen=(filesize($zipFile)/$head['content-length'])*100;
    if ($persen==100) { $dis='disabled'; $t='Done'; }
    elseif ($persen>100) { $dis='disabled'; $persen=0; $t='None';; }
    else { $dis=''; $t='Patch'; }                
?>              <tr>
                    <td>7.</td>
                    <td>Audio</td>
                    <td><?php echo $head['content-length']; ?></td>
                    <td>
                        <div class="progress progress-xs">
                            <div id="myBar[7]" class="progress-bar progress-bar-primary" style="width: <?= $persen ?>%"></div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-primary btn-xs" name="patch5" onclick="move(7); if(confirm('Pastikan ujian tidak sedang berlangsung!')) pop(7)" <?= $dis ?> ><?= $t ?></button>
                    </td>
                </tr>                
            </table>
        </div>
        <!-- /.box-body -->
    </div>
</div>
<script>
    function pop(id) {
        window.open("<?php echo "$namaserver/vpanel/patching.php?id="; ?>" + id, "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=200,height=200");
    }

    function pops() {
        window.open("<?php echo "$namaserver/vpanel/patch_aud.php"; ?>", "_blank", "toolbar=no,scrollbars=no,resizable=no,top=200,left=500,width=200,height=200");
    }

    $(document).ready(function() {
        $("#loaderz").fadeOut("medium");
    })

</script>
