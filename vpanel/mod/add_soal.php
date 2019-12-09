<script type="text/javascript" src="./tiny_mce/tiny_mce_src.js"></script>
<script type="text/javascript">
	tinyMCE.init({         
		mode : "textareas",
		editor_selector : "q",
        theme : "advanced",
        plugins : "jbimages,lists,pagebreak,table,advimage,emotions,insertdatetime,media,searchreplace,paste,visualchars,nonbreaking,xhtmlxtras,template,advlist,tiny_mce_wiris",
        language : "en",                 
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "jbimages,tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,media",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_resizing : true,             
        relative_urls : false,
		height : 20             
    });         
	tinyMCE.init({         
		mode : "textareas",
		editor_selector : "a",
        theme : "advanced",
        plugins : "jbimages,lists,pagebreak,table,advimage,emotions,insertdatetime,media,searchreplace,paste,visualchars,nonbreaking,xhtmlxtras,template,advlist,tiny_mce_wiris",
        language : "en",                 
        theme_advanced_buttons1 : "jbimages,bold,italic,underline,strikethrough,|,outdent,indent,cut,copy,paste,pastetext,pasteword,blockquote,|,undo,redo,|,sub,sup,|,charmap,emotions,media",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_resizing : true,             
        relative_urls : false ,
		height : 5               
    });         </script>
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title"><img src="./assets/add.soal.png" width="48"> Input Soal &nbsp; &nbsp; <button type="button" class="btn btn-warning" onclick="location.href='./?to=<?= $importsoal ?>';">Import Dari Excel</button></h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<form name="form" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
		<div class="box-body">
			
			<div class="form-group">
                  <label for="inputsoal" class="col-sm-2 control-label">Modul</label>
				<div class="col-sm-4">
                  <select name="kd_modul" class="form-control" required>
<?php 
if (!empty($_POST[kd_modul])) $_SESSION[kdm]=$_POST[kd_modul];
if (!empty($_SESSION[kdm])) $_POST[kd_modul]=$_SESSION[kdm];
if (empty($_POST[kd_modul])) 
		echo "<option value=0 selected>- pilih modul -</option>";
	$hasil=mysql_query("SELECT * FROM modul WHERE status='Aktif' ORDER BY nm_modul");
	while ($dt=mysql_fetch_row($hasil))
	{
		if ($dt[0]==$_GET[kd_modul])
			echo "<option value=$dt[0] selected>$dt[1]</option>";
		elseif ($dt[0]==$_POST[kd_modul])
			echo "<option value=$dt[0] selected>$dt[1]</option>";
		else
			echo "<option value=$dt[0]>$dt[1]</option>";
	}
  ?>
</select>
				</div>
			</div>		
			<div class="form-group">
				<label for="inputsoal" class="col-sm-2 control-label">Soal</label>
				<div class="col-sm-8">
					<textarea name="q" id="q" class="q" style="width:90%" autofocus><?php echo "$_POST[q]";?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="inputsoal" class="col-sm-2 control-label">Jawaban Benar</label>
				<div class="col-sm-8">
					 <textarea name="a" type="text" class="a" id="answer"  rows="1" style="width:90%"><?php echo "$_POST[a]";?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="inputsoal" class="col-sm-2 control-label">Jawaban Salah #1</label>
				<div class="col-sm-8">
					<textarea name="alt_1" type="text" class="a" id="alt_1" rows="1"  style="width:90%"><?php echo "$_POST[alt_1]";?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="inputsoal" class="col-sm-2 control-label">Jawaban Salah #2</label>
				<div class="col-sm-8">
					<textarea name="alt_2" type="text" class="a" id="alt_2" rows="1"  style="width:90%"><?php echo "$_POST[alt_2]";?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="inputsoal" class="col-sm-2 control-label">Jawaban Salah #3</label>
				<div class="col-sm-8">
					<textarea name="alt_3" type="text" class="a" id="alt_3" rows="1"  style="width:90%"><?php echo "$_POST[alt_3]";?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="inputsoal" class="col-sm-2 control-label">Jawaban Salah #4</label>
				<div class="col-sm-8">
					<textarea name="alt_4" type="text" class="a" id="alt_4" rows="1"  style="width:90%"><?php echo "$_POST[alt_4]";?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="inputsoal" class="col-sm-2 control-label">Acak Jawaban</label>
				<?php 
	if (!empty($_SESSION[ack])) $_POST[format]=$_SESSION[ack];

  	if ($_GET[format]=='random' || $_POST[format]=='random') 	$cek="checked=\"checked\"";
	else $cek="";
?>
				<div class="col-sm-8">
					<input  name="format" type="checkbox" value="random" class="minimal-red"  <?php echo $cek ?>> Ya
        </div>
			</div>	
		</div>
		<!-- /.box-body -->
		<div class="box-footer">
			<div class="col-sm-2"></div>
			<div class="col-sm-4">
				<input type="hidden" name="kd" value="<?= " $_GET[ren] "; ?>">
				<?php if ($_GET[ac]=='rensoal') { ?>
				<button type="submit" name="updatesoal" value="ok" class="btn btn-warning">Update</button>
				<?php } else { ?>
				<button type="submit" name="submitsoal" value="ok" class="btn btn-primary">Simpan</button>
				<?php } ?>

				<button type="cancel" class="btn btn-default">Reset</button>
			</div>
		</div>
		<!-- /.box-footer -->
	</form>
</div>