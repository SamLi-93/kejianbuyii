<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('contents'); ?>
<link type="text/css" href="<?=$_BASE_DIR?>js/calendar/skins/default/theme.css" rel="stylesheet"/>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/calendar.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/lang/calendar-zh-utf8.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">
function insertTabRow(witchID,file_name){
  var rowNum,rowNumNew,insertText;
  rowNum = $('#'+witchID+' tr').size();
  rowNumNew = rowNum +1;
  //alert(rowNumNew);
  insertText = "<tr><td><input name='"+file_name+"' type='file'></td></tr>";  
  //alert(insertText);
  $('#'+witchID).append(insertText);
}
function deleteTabRow(witchID){
  var rowNum,rowNumNew;
  rowNum = $('#'+witchID+' tr').size();
  rowNumNew = rowNum - 1;
  //alert(rowNumNew);
  //if(rowNum > 1){
    $('#'+witchID+' tr:eq('+rowNumNew+')').remove();

  //}
}
$(function(){
	$('#form_news').submit(function(){
		if($.trim($('#projectname').val()) == ''){
			alert('请输入项目名称！');
			$('#projectname').focus();
			return false;	
		}
    if($.trim($('#school').val()) == ''){
      alert('请输入学校！');
      $('#school').focus();
      return false; 
    }
    if($.trim($('#time').val()) > $.trim($('#endtime').val())){
      alert('开始时间不能大于结束时间');
      $('#school').focus();
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
        <td width="146" >项目名称：</td>
        <td width="842" ><input name="projectname" type="text"  id="projectname" value="" size="50" /></td>
      </tr>
      
      <tr height="30">
        <td width="146" >学校：</td>
        <td width="842" ><input name="school" type="text"  id="school" value="" size="50" /></td>
      </tr>
      <tr height="30">
        <td >是否结束：</td>
        <td >
            <select  id="over" name="over" class="dept_select" style="width:150px;">
            <?php
            foreach($over as $k => $v){
                echo '<option value="'.$k.'" >'.$v.'</option>';
            }
            ?>
            </select>
        </td>
      </tr>
      <tr height="30">
        <td >费用是否结算：</td>
        <td >
            <select  id="free" name="free" class="dept_select" style="width:150px;">
            <?php
            foreach($free as $k => $v){
                echo '<option value="'.$k.'" >'.$v.'</option>';
            }
            ?>
            </select>
        </td>
      </tr>
     <tr height="30">
        <td >项目联系人：</td>
        <td ><input name="teacher" type="text"  id="teacher" value="" size="50" /></td>
      </tr>
      <tr height="30">
        <td >开始时间：</td>
        <td >
        <input name="time" type="text"  id="time" value="<?php echo date('Y-m-d'); ?>" size="30" /></td>
      </tr>
      <tr height="30">
        <td >结束时间：</td>
        <td ><input name="endtime" type="text"  id="endtime" value="<?php echo date('Y-m-d');?>" size="30" /></td>
      </tr>
      <tr height="30">
        <td >图片：</td>
        <td ><img src="<?=$_BASE_DIR?>index_style/images/+.gif" style="cursor:hand;" onClick="javascirpt:insertTabRow('tp_table','tp[]');" title="添加一个图片"> <img src="<?=$_BASE_DIR?>index_style/images/-.gif" style="cursor:hand;" onClick="deleteTabRow('tp_table');" title="删除一个图片"> &nbsp;如需增加<font color="#ff000">图片</font>按"+", 删除按"-"
          <table  id="tp_table" width="100%"  border="0">
          </table></td>
      </tr>
      <tr height="30">
        <td >附件：</td>
        <td ><img src="<?=$_BASE_DIR?>index_style/images/+.gif" style="cursor:hand;" onClick="javascirpt:insertTabRow('fj_table','fj[]');" title="添加一个附件"> <img src="<?=$_BASE_DIR?>index_style/images/-.gif" style="cursor:hand;" onClick="deleteTabRow('fj_table');" title="删除一个附件"> &nbsp;如需增加<font color="#ff000">附件</font>按"+", 删除按"-"
          <table  id="fj_table" width="100%"  border="0">
          </table></td>
      </tr>
      <tr height="30">
        <td >原始路径：</td>
        <td ><input name="originalPath" type="text"  id="originalPath" value="" size="50" /></td>
      </tr>
      <tr height="30">
        <td >制作路径：</td>
        <td ><input name="makingPath" type="text"  id="makingPath" value="" size="50" /></td>
      </tr>
      <tr height="30">
        <td >上传人：</td>
        <td >
          <select name="uploadname" style="width:130px;" id="uploadname" class="dept_select"> 
            <?echo '<option value="">选择上传人</option>';
            foreach ($list1 as $k => $v) {
              if (strlen($user['name']) && $user['name'] == $v) {
                $sel = 'selected';
              } else {
                $sel = '';
              }
              echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
            }?>
          </select>
          
        </td>
      </tr>
      <tr height="80">
      <td ></td>
        <td>
          <div class="btn4 mr20" onclick="javascript:$('.fsimple').submit();">保存</div>
          <div class="btn4 mr20" onclick="javascript:location='<?php echo url('project')?>';">返回</div></td>
      </tr>
    </table>
</form>       
</div>      

            </div>
        </div>
    </div>
</div>
<script language="javascript">
  Calendar.setup({inputField : "time",ifFormat : "%Y-%m-%d",showsTime: true});
  Calendar.setup({inputField : "endtime",ifFormat : "%Y-%m-%d",showsTime: true});
  CKEDITOR.replace( 'content', { skin: "office2003", width:670, height:250,filebrowserBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html', filebrowserImageBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Images', filebrowserFlashBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Flash', filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', filebrowserImageUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images', filebrowserFlashUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash' });
</script>
<?php $this->_endblock(); ?>
