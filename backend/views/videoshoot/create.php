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
function insertTabRow2(witchID,file_name,time,half){
  var list = time.split(',');
  var list1 = half.split(',');
  var rowNum,insertText,timestr,halfstr;
  var date = new Date();
  rowNum = $('#'+witchID+' tr').size();
  for (var i = 0; i < list.length; i++) {
    timestr += "<option value="+list[i]+" >"+list[i]+"</option>";
  };
  for (var j = 0; j < list1.length; j++) {
    halfstr += "<option value="+list1[j]+" >"+list1[j]+"</option>";
  }; 
  insertText = "<tr><td ><input name='release_date[]' type='text'  id='release_date"+rowNum+"' value='"+date.toLocaleString()+"' size='30' />";
  insertText += "<select  name='time[]' class='dept_select' style='width:70px;'>"+timestr+"</select>点";
  insertText += "<select  name='half[]' class='dept_select' style='width:70px;'>"+halfstr+"</select>到";
  insertText += "<select  name='time1[]' class='dept_select' style='width:70px;'>"+timestr+"</select>点";    
  insertText += "<select  name='half1[]' class='dept_select' style='width:70px;'>"+halfstr+"</select></td></tr>";    
  
  // console.log(insertText);
  //   alert(insertText);
    $('#'+witchID).append(insertText);
  $('.dept_select').chosen();
  Calendar.setup({inputField : "release_date"+rowNum,ifFormat : "%Y-%m-%d",showsTime: true});
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
    if($.trim($('#teacher').val()) == ''){
      alert('请输入主讲人！');
      $('#teacher').focus();
      return false; 
    }
    if($.trim($('#name').val()) == ''&&$.trim($('#name1').val()) == ''&&$.trim($('#name2').val()) == ''&&$.trim($('#name3').val()) == ''){
      alert('请输入录制人员！');
      $('#name').focus();
      return false; 
    }

    if($.trim($('#seat').val()) == ''){
      alert('请输入机位！');
      $('#seat').focus();
      return false; 
    }
    var numValue=document.getElementById("seat").value;  
    if(isNaN(numValue)){  
      alert("请输入正确的机位");  
      $('#seat').focus();
      return false;  
    } 

    $btime = parseInt($('#time').val()) * 60 + parseInt($('#half').val()); 
    $ftime =  parseInt($('#time1').val()) * 60 + parseInt($('#half1').val()); 
    if($btime - $ftime >= 0){
      alert('结束时间不得等于或早于开始时间');
      $('#half').focus();
      return false; 
    }
    if(confirm('您确定要提交吗？')){
      return true;  
    }else{
      return false;
    }

  }); 
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

        var condition_info = "<select id=\"courcename\" class=\"dept_select\" name=\"courcename\" style=\"width:150px\"><option value=\"\">选择课程名称</option>";
        for(var i = 0; i < name.length; i++){
          condition_info +="<option value=\""+name[i]+"\">"+name[i]+"</option>";
          }
          condition_info +="</select>";
        $('#courcename1').html(condition_info);

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
        <td width="842" >
          <span id ="courcename1">
            <select name="courcename" style="width:150px;" id="courcename" class="dept_select"> 
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
          
          <a href="<?=url('videomaking/create',array('return'=> 'videoshoot'))?>"><font color=red>添加课程</font></a>
        </td>

      </tr>
      <tr height="30">
        <td >主讲人：</td>
        <td >
          <select  id="teacher" name="teacher" class="dept_select" style="width:150px;">
          <?php
            echo '<option value="">选择主讲人名字</option>';
            foreach ($list2 as $k => $v) {?>
              <option value="<?php echo $v;?>" ><?php echo $v;?></option>
          <?}?>
          </select>
          <a href="<?=url('teacher/create',array('return'=> 'videoshoot'))?>"><font color=red>添加主讲人</font></a>
        </td>
      </tr>
      <tr height="30">
        <td >录制人员：</td>
        <td >
          <select  id="name" name="name" class="dept_select" style="width:150px;">
          <?php
            echo '<option value="">选择人员名字</option>';
            foreach ($list1 as $k => $v) {?>
              <option value="<?php echo $v;?>" ><?php echo $v;?></option>
          <?}?>
           </select>
           <select  id="name1" name="name1" class="dept_select" style="width:150px;">
          <?php
            echo '<option value="">选择人员名字</option>';
            foreach ($list1 as $k => $v) {?>
              <option value="<?php echo $v;?>" ><?php echo $v;?></option>
          <?}?>
           </select>
           <select  id="name2" name="name2" class="dept_select" style="width:150px;">
          <?php
            echo '<option value="">选择人员名字</option>';
            foreach ($list1 as $k => $v) {?>
              <option value="<?php echo $v;?>" ><?php echo $v;?></option>
          <?}?>
           </select>
           <select  id="name3" name="name3" class="dept_select" style="width:150px;">
          <?php
            echo '<option value="">选择人员名字</option>';
            foreach ($list1 as $k => $v) {?>
              <option value="<?php echo $v;?>" ><?php echo $v;?></option>
          <?}?>
           </select>
        </td>
      </tr>
      
      <tr height="30">
        <td >拍摄日期：</td>
        <td ><img src="<?=$_BASE_DIR?>index_style/images/+.gif" style="cursor:hand;" onClick="javascirpt:insertTabRow2('sj_table','sj[]','<?echo $Istime?>','<?echo $Ishalf?>');" title="添加一条记录"> <img src="<?=$_BASE_DIR?>index_style/images/-.gif" style="cursor:hand;" onClick="deleteTabRow('sj_table');" title="删除一条记录"> &nbsp;如需增加<font color="#ff000">记录</font>按"+", 删除按"-"
          <table  id="sj_table" width="100%"  border="0">
          </table></td> 
      </tr>
      <tr height="30">
        <td >机位个数：</td>
        <td ><input name="seat" type="text"  id="seat" value="" size="10" /></td>
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
      <tr height="80">
      <td ></td>
        <td>
          <div class="btn4 mr20" onclick="javascript:$('.fsimple').submit();">保存</div>
          <div class="btn4 mr20" onclick="javascript:location='<?php echo url('videoshoot')?>';">返回</div></td>
      </tr>
    </table>
</form>       
</div>      

            </div>
        </div>
    </div>
</div>
<script language="javascript">
    
  CKEDITOR.replace( 'content', { skin: "office2003", width:670, height:250,filebrowserBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html', filebrowserImageBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Images', filebrowserFlashBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Flash', filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', filebrowserImageUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images', filebrowserFlashUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash' });
</script>

<?php $this->_endblock(); ?>
