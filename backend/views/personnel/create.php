<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('contents'); ?>
<link type="text/css" href="<?=$_BASE_DIR?>js/calendar/skins/default/theme.css" rel="stylesheet"/>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/calendar.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/lang/calendar-zh-utf8.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(function(){
	$('#form_news').submit(function(){
		if($.trim($('#username').val()) == ''){
			alert('请输入用户名！');
			$('#username').focus();
			return false;	
		}
    if($.trim($('#password').val()) == ''){
      alert('请输入密码！');
      $('#password').focus();
      return false; 
    }
    if($.trim($('#password').val()) != $.trim($('#password1').val())){
      alert('两次密码不一致！');
      $('#password').focus();
      return false; 
    }
		if(confirm('您确定要提交吗？')){
			return true;	
		}else{
			return false;
		}
	});	
});
$(function(){
    $('.dept_select').chosen();
});
</script>
<?php echo $alert;?>
<style>
/*打印表格 在第43行*/
.print_table {
	border-collapse:collapse;/*border:1px solid #000000;*/
}
.print_table th {
	border:1px solid #CCCCCC;
}
.print_table td {
	border:1px solid #CCCCCC;
}
</style>

<div class="row-fluid sortable" style="width:95%;">		
    <div class="box span12">
        <div class="box-content">
            <div class="row-fluid">
<div class="sims_sbumit">
<form class="fsimple" id="form_news" name="form_news" action="" method="post" enctype="multipart/form-data" >
    <table class="table table-striped table-bordered bootstrap-datatable datatable">
      <tr height="30">
        <td width="146" >用户名：</td>
        <td width="842" ><input name="username" type="text"  id="username" value="" size="50" /></td>
      </tr>
      
      <tr height="30">
        <td >密码：</td>
        <td ><input name="password" type="password"  id="password" value="" size="50" /></td>
      </tr>
      <tr height="30">
        <td width="146" >确认密码：</td>
        <td width="842" ><input name="password1" type="password"  id="password1" value="" size="50" /></td>
      </tr>      
      <tr height="30">
        <td >角色：</td>
        <td >
            <select  id="orgid" name="orgid" class="dept_select" style="width:150px;">
            <?php
            foreach($Isorgid as $k => $v){
                echo '<option value="'.$k.'" >'.$v.'</option>';
            }
            ?>
            </select>
        </td>
      </tr>
     

      <tr height="80">
      <td ></td>
        <td>
          <div class="btn4 mr20" onclick="javascript:$('.fsimple').submit();">保存</div>
          <div class="btn4 mr20" onclick="javascript:location='<?php echo url('personnel')?>';">返回</div></td>
      </tr>
    </table>
</form>       
</div>      

            </div>
        </div>
    </div>
</div>
<?php $this->_endblock(); ?>
