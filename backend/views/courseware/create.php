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
function insertTabRow1(witchID,file_name){
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
    if($.trim($('#courcename').val()) == ''){
      alert('请输入课程名称！');
      $('#courcename').focus();
      return false; 
    }
    if($.trim($('#hour').val()) == ''&&$.trim($('#minu').val()) == ''&&$.trim($('#second').val()) == ''){
      alert('请输入时长！');
      $('#hour').focus();
      return false; 
    }
    if($.trim($('#makingname').val()) == ''){
      alert('请选择制作人员！');
      $('#courcename').focus();
      return false; 
    }
    if($.trim($('#date').val())>$.trim($('#enddate').val())){
      alert('结束时间不得早于开始时间');
      $('#date').focus();
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
        var name = data.coursename;
        var educational = data.educational;

        var condition_info = "<select id=\"courcename\" class=\"dept_select\" name=\"courcename\" style=\"width:200px\"><option value=\"\">选择课程名称</option>";
        for(var i = 0; i < name.length; i++){
          condition_info +="<option value=\""+name[i]+"\">"+name[i]+"</option>";
          }
          condition_info +="</select>";
        $('#courcename1').html(condition_info);

        var condition_info1 = "<select id=\"school\" class=\"dept_select\" name=\"school\" style=\"width:200px\" onchange=\"changecheck1(this.options[this.options.selectedIndex].value)\"><option value=\"\">选择学校</option>";
        for(var i = 0; i < educational.length; i++){
          condition_info1 +="<option value=\""+educational[i]+"\">"+educational[i]+"</option>";
          }
          condition_info1 +="</select>";
        $('#school1').html(condition_info1);
        $('.dept_select').chosen();
      }
  });  
}
function changecheck1(v){
  $.ajax({
      type: "post",
      method: "post",
      dataType: "json",
      data: {"v": v},
      url: "<?php echo url('/changecheck1');?>",
      success: function(data){
        console.log(data);
        var name = data.master;

        var condition_info = "<select id=\"teacher\" class=\"dept_select\" name=\"teacher\" style=\"width:200px\"><option value=\"\">选择讲师</option>";
        for(var i = 0; i < name.length; i++){
          condition_info +="<option value=\""+name[i]+"\">"+name[i]+"</option>";
          }
          condition_info +="</select>";
        $('#teacher1').html(condition_info);
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
          <select  id="projectname" name="projectname" class="dept_select" style="width:200px;" onchange="changecheck(this.options[this.options.selectedIndex].value)">
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
          <select name="school" style="width:200px;" id="school" class="dept_select" > 
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
        <td width="842" >
          <span id ="courcename1">
            <select name="courcename" style="width:200px;" id="courcename" class="dept_select"> 
              <?echo '<option value="">选择课程名称</option>';
                foreach ($coursename as $k => $v) {
                if (strlen($courcename) && $courcename == $v) {
                  $sel = 'selected';
                } else {
                  $sel = '';
                }
                echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
              }?>
            </select>
          </span>
          <a href="<?=url('videomaking/create',array('return'=> 'courseware'))?>"><font color=red>添加课程</font></a>
        </td>
      </tr>
      <tr height="30">
        <td >视频标题：</td>
        <td ><input name="title" type="text"  id="title" value="" size="30" /></td>
      </tr>
      <tr height="30">
        <td >讲师：</td>
        <td>
          <span id ="teacher1">
            <select  id="teacher" name="teacher" class="dept_select" style="width:200px;">
              <?php
                echo '<option value="">选择讲师</option>';
                foreach ($list2 as $k => $v) {?>
                  <option value="<?php echo $v;?>" ><?php echo $v;?></option>
              <?}?>
            </select>
          </span>
           <a href="<?=url('teacher/create',array('return'=> 'courseware'))?>"><font color=red>添加讲师</font></a>
        </td>
      </tr>
      <tr height="30">
        <td >时长：</td>
        <td >
          <input name="hour" type="text"  id="hour" value="" size="10" />时
          <input name="minu" type="text"  id="minu" value="" size="10" />分
          <input name="second" type="text"  id="second" value="" size="10" />秒
        </td>
      </tr>
      <tr height="30">
        <td >制作人员：</td>
        <td >
          <select  id="makingname" name="makingname" class="dept_select" style="width:200px;">
          <?php
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
      <tr height="30">
        <td >开始日期：</td>
        <td ><input name="date" type="text"  id="date" value="<?php echo date('Y-m-d');?>" size="30" /></td>
      </tr>
      <tr height="30">
        <td >结束日期：</td>
        <td ><input name="enddate" type="text"  id="enddate" value="<?php echo date('Y-m-d');?>" size="30" /></td>
      </tr>    
      <tr height="30">
        <td >核对图片：</td>
        <td ><img src="<?=$_BASE_DIR?>index_style/images/+.gif" style="cursor:hand;" onClick="javascirpt:insertTabRow('tp_table','tp[]');" title="添加一个图片"> <img src="<?=$_BASE_DIR?>index_style/images/-.gif" style="cursor:hand;" onClick="deleteTabRow('tp_table');" title="删除一个图片"> &nbsp;如需增加<font color="#ff000">图片</font>按"+", 删除按"-"
          <table  id="tp_table" width="100%"  border="0">
          </table></td>
      </tr>
      <tr height="30">
        <td >附件：</td>
        <td ><img src="<?=$_BASE_DIR?>index_style/images/+.gif" style="cursor:hand;" onClick="javascirpt:insertTabRow1('fj_table','fj[]');" title="添加一个附件"> <img src="<?=$_BASE_DIR?>index_style/images/-.gif" style="cursor:hand;" onClick="deleteTabRow('fj_table');" title="删除一个附件"> &nbsp;如需增加<font color="#ff000">附件</font>按"+", 删除按"-"
          <table  id="fj_table" width="100%"  border="0">
          </table></td>
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
      <tr height="30">
        <td >状态：</td>
        <td >
            <select  id="state" name="state" class="dept_select" style="width:200px;">
            <?php
            foreach($schedule as $k => $v){
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
          <div class="btn4 mr20" onclick="javascript:location='<?php echo url('courseware')?>';">返回</div></td>
      </tr>
    </table>
</form>       
</div>      

            </div>
        </div>
    </div>
</div>
<script language="javascript">
    Calendar.setup({inputField : "date",ifFormat : "%Y-%m-%d",showsTime: true});
    Calendar.setup({inputField : "enddate",ifFormat : "%Y-%m-%d",showsTime: true});
  CKEDITOR.replace( 'content', { skin: "office2003", width:670, height:250,filebrowserBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html', filebrowserImageBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Images', filebrowserFlashBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Flash', filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', filebrowserImageUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images', filebrowserFlashUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash' });
</script>

<?php $this->_endblock(); ?>
