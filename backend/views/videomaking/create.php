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
    if($.trim($('#courcename').val()) == ''){
      alert('请输入课程名称！');
      $('#courcename').focus();
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
function changecheck(v){
  $.ajax({
      type: "post",
      method: "post",
      dataType: "json",
      data: {"v": v},
      url: "<?php echo url('/changecheck');?>",
      success: function(data){
        console.log(data);
        var educational = data.educational;

        var condition_info1 = "<select id=\"school\" class=\"dept_select\" name=\"school\" style=\"width:150px\"><option value=\"\">选择学校</option>";
        for(var i = 0; i < educational.length; i++){
          condition_info1 +="<option value=\""+educational[i]+"\">"+educational[i]+"</option>";
          }
          condition_info1 +="</select>";
        $('#school1').html(condition_info1);
        $('.dept_select').chosen();
      }
  });  
}
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
        <td width="842" >
          <select  id="projectname" name="projectname" class="dept_select" style="width:150px;" onchange="changecheck(this.options[this.options.selectedIndex].value)">
          <?echo '<option value="">选择项目</option>';
            foreach ($project as $k => $v) {
            if (strlen($projectname) && $projectname == $v) {
              $sel = 'selected';
            } else {
              $sel = '';
            }
            echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
          }?>
          </select>
        </td>
      </tr>
      <tr height="30">
        <td width="146" >学校：</td>
        <td width="842" id ="school1">
          <select name="school" style="width:150px;" id="school" class="dept_select"> 
          <?echo '<option value="">选择学校</option>'; 
            foreach ($educational as $k => $v) {
            if (strlen($school) && $school == $v) {
              $sel = 'selected';
            } else {
              $sel = '';
            }
            echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
          }?>
          </select>
        </td>
      </tr>
      <tr height="30">
        <td width="146" >课程名称：</td>
        <td width="842">
          <input name="courcename" type="text"  id="courcename" value="" size="50" />
        </td>
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
        <td >有无字幕：</td>
        <td >
            <select  id="subtitle" name="subtitle" class="dept_select" style="width:200px;">
            <?php
            foreach($subtitle as $k => $v){
                echo '<option value="'.$k.'" >'.$v.'</option>';
            }
            ?>
            </select>
        </td>
      </tr>
      <tr height="30">
        <td >费用结算：</td>
        <td >
            <select  id="free" name="free" class="dept_select" style="width:200px;">
            <?php
            foreach($free as $k => $v){
                echo '<option value="'.$k.'" >'.$v.'</option>';
            }
            ?>
            </select>
        </td>
      </tr>
      <tr height="30">
        <td >上传人：</td>
        <td >
          <select name="makingname" style="width:130px;" id="makingname" class="dept_select"> 
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
          <div class="btn4 mr20" onclick="javascript:location='<?php if(strlen($return)){echo url($return.'/create');}else{echo url('videomaking');}?>';">返回</div></td>
      </tr>
    </table>
</form>       
</div>      

            </div>
        </div>
    </div>
</div>
<?php $this->_endblock(); ?>
