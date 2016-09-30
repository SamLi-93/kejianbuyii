<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('contents'); ?>
<link type="text/css" href="<?=$_BASE_DIR?>js/calendar/skins/default/theme.css" rel="stylesheet"/>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/calendar.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/lang/calendar-zh-utf8.js"></script>
<script type="text/javascript" src="<?= $_BASE_DIR ?>ckeditor/ckeditor.js"></script>
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
function deleteTabRow(witchID) {
  var rowNum, rowNumNew;
  rowNum = $('#' + witchID + ' tr').size();
  rowNumNew = rowNum - 1;
  //alert(rowNumNew);
  //if(rowNum > 1){
  $('#' + witchID + ' tr:eq(' + rowNumNew + ')').remove();
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
        var name = data.coursename;
        var educational = data.educational;

        var condition_info = "<select id=\"courcename\" class=\"dept_select\" name=\"courcename\" style=\"width:200px\"><option value=\"\">选择课程名称</option>";
        for(var i = 0; i < name.length; i++){
          condition_info +="<option value=\""+name[i]+"\">"+name[i]+"</option>";
          }
          condition_info +="</select>";
        $('#courcename1').html(condition_info);

        var condition_info1 = "<select id=\"school\" class=\"dept_select\" name=\"school\" style=\"width:200px\"><option value=\"\">选择学校</option>";
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
<?php echo $alert; ?>
<style>
    /*打印表格*/
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
                                    <select  id="projectname" name="projectname" class="dept_select" style="width:200px;" onchange="changecheck(this.options[this.options.selectedIndex].value)">
                                        <?php 
                                            foreach($project as $k => $v){ 
                                            if ($myData['projectname'] == $v) {
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
                                    <select  id="school" name="school" class="dept_select" style="width:200px;">
                                        <?php 
                                            foreach($educational as $k => $v){ 
                                            if ($myData['school'] == $v) {
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
                                    <input name="courcename" type="text"  id="courcename" value="<?php echo stripslashes($myData['courcename']); ?>" size="50" />
                                </td>
                            </tr>
                            <tr height="30">
                                <td >图片：</td>
                                <td >
                                    <table width="300" border="0">
                                       <?php
                                        foreach ($picData as $k => $v) {
                                            if (is_file($rootdir . $v['path'])) {
                                                echo '<tr><td><a href="' . $_BASE_DIR . str_replace('\\', '/', $v['path']) . '" target="_blank">' . $v['name'] . '</a></td><td><a href="' . url('videomaking/edit', array('id' => $myData['id'], 'en_id' => $v['id'], 'actionValue' => 'deletePic')) . '" onclick="return deletePic()" style="color:blue;" title="删除">[删除]</a></td></tr>';
                                            }
                                        }?>
                                    </table>
                                    <img src="<?= $_BASE_DIR ?>index_style/images/+.gif" style="cursor:hand;" onClick="javascirpt:insertTabRow('tp_table', 'tp[]');" title="添加一个图片"> <img src="<?= $_BASE_DIR ?>index_style/images/-.gif" style="cursor:hand;" onClick="deleteTabRow('tp_table');" title="删除一个附件"> &nbsp;如需增加<font color="#ff000">图片</font>按"+", 删除按"-"
                                    <table  id="tp_table" width="100%"  border="0">
                                    </table>
                                </td>
                            </tr>
                            <tr height="30">
                                <td >附件</td>
                                <td >
                                    <table width="300" border="0">
                                       <?php
                                        foreach ($encData as $k => $v) {
                                            if (is_file($rootdir . $v['path'])) {
                                                echo '<tr><td><a href="' . $_BASE_DIR . str_replace('\\', '/', $v['path']) . '" target="_blank">' . $v['name'] . '</a></td><td><a href="' . url('videomaking/edit', array('id' => $myData['id'], 'en_id' => $v['id'], 'actionValue' => 'deleteEnc')) . '" onclick="return deleteEnc()" style="color:blue;" title="删除">[删除]</a></td></tr>';
                                            }
                                        }?>
                                    </table>
                                    <img src="<?= $_BASE_DIR ?>index_style/images/+.gif" style="cursor:hand;" onClick="javascirpt:insertTabRow('fj_table', 'fj[]');" title="添加一个附件"> <img src="<?= $_BASE_DIR ?>index_style/images/-.gif" style="cursor:hand;" onClick="deleteTabRow('fj_table');" title="删除一个附件"> &nbsp;如需增加<font color="#ff000">附件</font>按"+", 删除按"-"
                                    <table  id="fj_table" width="100%"  border="0">
                                    </table>
                                </td>
                            </tr>
                            <tr height="30">
                                <td >有无字幕：</td>
                                <td ><select  id="subtitle" name="subtitle" class="dept_select" style="width:200px;">
                                 <?php
                                 foreach($subtitle as $k => $v){
                                    if ($myData['subtitle'] == $k) {
                                                $sel = 'selected';
                                            } else {
                                                $sel = '';
                                            }
                                            echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
                                 }

                                   ?>
                             </select></td>
                            </tr>
                            <tr height="30">
                                <td >费用结算：</td>
                                <td ><select  id="free" name="free" class="dept_select" style="width:200px;">
                                 <?php
                                 foreach($free as $k => $v){
                                    if ($myData['free'] == $k) {
                                                $sel = 'selected';
                                            } else {
                                                $sel = '';
                                            }
                                            echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
                                 }

                                   ?>
                             </select></td>
                            </tr>
                            <tr height="10">
                                <td >上传人：</td>
                                <td >
                                <select  id="makingname" name="makingname" class="dept_select" style="width:200px;">
                                 <?php 
                                 foreach($list1 as $k => $v){
                                    if ($myData['makingname'] == $v) {
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
                                  <div class="btn4 mr20" onclick="javascript:location='<?php echo url('videomaking')?>';">返回</div></td>
                              </tr>
                        </table>
                    <input type="hidden" name="id" value="<?php echo $myData['id']; ?>" />
                </form>
                </div>
            </div></div>
        <?php $this->_endblock(); ?>
