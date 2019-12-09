<?php
	if(!defined('gaklangsung') || !isset($_SESSION[is_login])) 
	die("<h3>Akses terbatas!</h3>");	
   if (!empty($_GET['msg'])) $_GET['msg']=$converter->decode($_GET['msg']);
?>
<style>
.wrapper{
	margin: 20px auto;
	width:300px;
	height: 400px;
}
.login-form{
	width: 100%;
	height: 100%;
	overflow: auto;
}
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<span style="color:#000"><?php echo "Anda Login Sebagai : <b>$_SESSION[is_name] / $_SESSION[is_kelas] - $_SESSION[is_sekolah]</b>"; ?></span>
<legend style="color:#000; text-align:center"><i class="icon-key on-left" style="background: white; color: #3399CC; padding: 5px; border-radius: 40%"></i> Ganti password</legend>
<div class="wrapper" align="center">
<div class="notify-container"></div>       
<script>
	$(document).ready(function(){
<?php if ($_GET['msg']==1) { ?>
		setTimeout(function(){
        	$.Notify({ style	: {background: 'red', color: 'white'}, 										timeout	: 5000, content	: " &nbsp; &nbsp; &nbsp; Password salah!!! &nbsp; &nbsp; &nbsp; " }); }, 0);
<?php } else if ($_GET['msg']==3) { ?>
		setTimeout(function(){
        	$.Notify({ style	: {background: 'green', color: 'white'}, 										timeout	: 5000, content	: " &nbsp; &nbsp; &nbsp; Password berhasil diubah!!! &nbsp; &nbsp; &nbsp; " }); }, 0);
<?php } ?>
	});
</script>
<div class="login-form">
<div>&nbsp;</div>
<form action="" method="post" enctype="multipart/form-data">
<fieldset>
	<div class="input-control password" data-role="input-control"><span id="sprytextfield1">
    <input name="password1" type="text" placeholder="Password Lama" autofocus required />
    <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
    </div>
    <div class="input-control password" data-role="input-control"><span id="sprytextfield2">
    <input name="password2" type="text" placeholder="Masukan password baru" required />
    <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
   	</div>
	<div>&nbsp;</div>
    <input type="hidden" name="do" value="changepass"/>
	<input name="updatepass" type="submit" value="Update"  class="success">
	<input type="reset" value="Reset" >
</fieldset>
</form>
</div>      
</div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "custom", {pattern:"00-00-0000", useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "custom", {pattern:"00-00-0000", useCharacterMasking:true});
</script>
