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
function insertTabRow1(witchID,file_name){
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
    function deleteEnc() {
        return confirm('确定删除附件吗？');
    }
    function check(n) {
        var status1=document.getElementById("status1");
        if(n==1){
            status1.value=parseInt(status1.value)+1;
        }
    }
    function check1(n) {
        var status1=document.getElementById("status1");
        if(n==1){
            status1.value=parseInt(status1.value)+2;
        }
    }
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
                                <td width="842" id="projectname1">
                                <select  id="projectname" name="projectname" class="dept_select" style="width:200px;" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?> onchange="changecheck(this.options[this.options.selectedIndex].value)">
                                 <?php 
                                 foreach($project as $k => $v){ 
                                    if ($myData[0]['projectname'] == $v) {
                                                $sel = 'selected';
                                            } else {
                                                $sel = '';
                                            }
                                            echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                 }?>
                                </select></td>
                            </tr>
                            <tr height="30">
                                <td width="146" >学校：</td>
                                <td width="842" id ="school1">
                                    <select  id="school" name="school" class="dept_select" style="width:200px;" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?> onchange="changecheck1(this.options[this.options.selectedIndex].value)">
                                        <?php 
                                            foreach($education as $k => $v){ 
                                            if ($myData[0]['school'] == $v) {
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
                                <td width="842" id ="courcename1">
                                    <select  id="courcename" name="courcename" class="dept_select" style="width:200px;" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?>>
                                        <?php 
                                            foreach($coursename as $k => $v){ 
                                            if ($myData[0]['coursename'] == $v) {
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
                                <td >视频标题：</td>
                                <td ><input name="title" type="text"  id="title" value="<?php echo stripslashes($myData[0]['title']); ?>" size="50" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?>/></td>
                            </tr>
                            <tr height="30">
                                <td >讲师：</td>
                                <td id="teacher1">
                                <select  id="teacher" name="teacher" class="dept_select" style="width:200px;" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?>>
                                 <?php 
                                 foreach($list2 as $k => $v){ 
                                    if ($myData[0]['teacher'] == $v) {
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
                                <td >时长：</td>
                                <td >
                                    <input name="hour" type="text"  id="hour" value="<?php echo stripslashes($myData[0]['hour']); ?>" size="10" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?>/>时
                                    <input name="minu" type="text"  id="minu" value="<?php echo stripslashes($myData[0]['minu']); ?>" size="10" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?>/>分
                                    <input name="second" type="text"  id="second" value="<?php echo stripslashes($myData[0]['second']); ?>" size="10" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?>/>秒
                                </td>
                                
                            </tr>
                            <tr height="30">  
                                <td width="146" >制作人员：</td>
                                <td width="842" >
                                <select  id="makingname" name="makingname" class="dept_select" style="width:200px;" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?>>
                                 <?php 
                                 foreach($list1 as $k => $v){ 
                                    if ($myData[0]['makingname'] == $v) {
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
                                <td >开始时间:</td>
                                <td ><input name="date" type="text"  id="date" value="<?php echo date('Y-m-d',$myData[0]['date']);?>" size="30" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?>/></td>
                            </tr>
                            <tr height="30">
                                <td >结束时间:</td>
                                <td ><input name="enddate" type="text"  id="enddate" value="<?php echo date('Y-m-d',$myData[0]['enddate']);?>" size="30" <?if($myData[0]['status'] == "二级通过" && $orgid == 1||$myData[0]['status'] == "一级通过" && $orgid == 1){ echo "disabled=disabled";}?>/></td>
                            </tr>
                            <tr height="30">
                                <td >图片：</td>
                                <td >
                                    <table width="300" border="0">
                                       <?php
                                        foreach ($picData as $k => $v) {
                                            if (is_file($rootdir . $v['path'])) {
                                                echo '<tr><td><a href="' . $_BASE_DIR . str_replace('\\', '/', $v['path']) . '" target="_blank">' . $v['name'] . '</a></td><td><a href="' . url('courseware/edit', array('id' => $myData[0]['id'], 'en_id' => $v['id'], 'actionValue' => 'deletePic','check' => $v['check'],'status' => $myData[0]['status'])) . '" onclick="return deletePic()" style="color:blue;" title="删除">[删除]</a></td></tr>';
                                            }
                                        }?>
                                    </table>
                                    <img src="<?= $_BASE_DIR ?>index_style/images/+.gif" style="cursor:hand;<?if($myData[0]['status']=="一级审核中"||$myData[0]['status']=="二级审核中"||$myData[0]['status']=="二级通过"){ echo "display:none";}?>" onClick="javascirpt:insertTabRow('tp_table', 'tp[]');" title="添加一个图片"> 
                                    <img src="<?= $_BASE_DIR ?>index_style/images/-.gif" style="cursor:hand;<?if($myData[0]['status']=="一级审核中"||$myData[0]['status']=="二级审核中"||$myData[0]['status']=="二级通过"){ echo "display:none";}?>" onClick="deleteTabRow('tp_table');" title="删除一个附件"> &nbsp;如需增加<font color="#ff000">图片</font>按"+", 删除按"-"
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
                                                echo '<tr><td><a href="' . $_BASE_DIR . str_replace('\\', '/', $v['path']) . '" target="_blank">' . $v['name'] . '</a></td><td><a href="' . url('courseware/edit', array('id' => $myData[0]['id'], 'en_id' => $v['id'], 'actionValue' => 'deleteEnc','check' => $v['check'],'status' => $myData[0]['status'])) . '" onclick="return deleteEnc()" style="color:blue;" title="删除">[删除]</a></td></tr>';
                                            }
                                        }?>
                                    </table>
                                    <img src="<?= $_BASE_DIR ?>index_style/images/+.gif" style="cursor:hand;<?if($myData[0]['status']=="一级审核中"||$myData[0]['status']=="二级审核中"||$myData[0]['status']=="二级通过"){ echo "display:none";}?>" onClick="javascirpt:insertTabRow1('fj_table', 'fj[]');" title="添加一个附件"> 
                                    <img src="<?= $_BASE_DIR ?>index_style/images/-.gif" style="cursor:hand;<?if($myData[0]['status']=="一级审核中"||$myData[0]['status']=="二级审核中"||$myData[0]['status']=="二级通过"){ echo "display:none";}?>" onClick="deleteTabRow('fj_table');" title="删除一个附件"> &nbsp;如需增加<font color="#ff000">附件</font>按"+", 删除按"-"
                                    <table  id="fj_table" width="100%"  border="0">
                                    </table>
                                </td>
                            </tr>
                            <tr height="10">
                                <td >上传人：</td>
                                <td >
                                <select  id="uploadname" name="uploadname" class="dept_select" style="width:200px;" <?if($myData[0]['status']!="一级驳回"&&$myData[0]['status'] != "未审核"){ echo "disabled=disabled";}?>>
                                 <?php
                                 foreach($list1 as $k => $v){
                                    if ($myData[0]['uploadname'] == $v) {
                                                $sel = 'selected';
                                            } else {
                                                $sel = '';
                                            }
                                            echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                 }?>
                             </select>
                             </td> 
                            </tr>
                            <tr height="10">
                                <td >状态：</td>
                                <td >
                                <select  id="state" name="state" class="dept_select" style="width:200px;" <?if($myData[0]['status'] != "未审核"){ echo "disabled=disabled";}?>>
                                 <?php
                                 foreach($schedule as $k => $v){
                                    if ($myData[0]['state'] == $k) {
                                                $sel = 'selected';
                                            } else {
                                                $sel = '';
                                            }
                                            echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
                                 }?>
                             </select>
                             </td> 
                            </tr>
                            <tr height="10">
                                <td >审核状态：</td>
                                <td ><?echo $myData[0]['status']?></td> 
                            </tr>
                            <tr height="30" style="<?if(empty($myData[0]['auditor1'])){ echo "display:none";}?>">
                                <td >一级审核人：</td>
                                <td ><?echo $myData[0]['auditor1']?>
                                </td>
                            </tr>
                            <tr height="30" style="<?if(empty($myData[0]['auditor2'])){ echo "display:none";}?>">
                                <td >二级审核人：</td>
                                <td ><?echo $myData[0]['auditor2']?>
                                </td>
                            </tr>
                            <tr height="80">
                              <td ></td>
                                <td>
                                    <input type="hidden" name="status1" value="1" id="status1" /> 
                                    <div class="btn4 mr20" onclick="javascript:$('.fsimple').submit();" style="<?if($myData[0]['status']=="一级审核中"&&$myData[0]['orgid']!=2||$myData[0]['status']=="二级审核中"&&$myData[0]['orgid']!=2||$myData[0]['status']=="二级通过"&&$myData[0]['orgid']!=2){ echo "display:none;";}?>">保存</div>
                                    <div class="btn4 mr20" onclick="check(1);javascript:$('.fsimple').submit();" style="<?if($myData[0]['status']=="一级审核中"||$myData[0]['status']=="二级审核中"){ echo "display:;";}else{echo "display:none;";}?>">审核</div>
                                    <div class="btn4 mr20" onclick="check1(1);javascript:$('.fsimple').submit();" style="<?if($myData[0]['status']=="一级审核中"||$myData[0]['status']=="二级审核中"){ echo "display:;";}else{echo "display:none;";}?>">驳回</div>
                                    <div class="btn4 mr20" onclick="javascript:location='<?php echo url('courseware')?>';">返回</div>
                                </td>
                              </tr>
                        </table>
                    <input type="hidden" name="id" value="<?php echo $myData['id']; ?>" />
                </form>
                </div>
            </div></div>
            <script language="javascript">
                Calendar.setup({inputField : "date",ifFormat : "%Y-%m-%d",showsTime: true});
                Calendar.setup({inputField : "enddate",ifFormat : "%Y-%m-%d",showsTime: true});
                CKEDITOR.replace( 'content', { skin: "office2003", width:670, height:250,filebrowserBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html', filebrowserImageBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Images', filebrowserFlashBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Flash', filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', filebrowserImageUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images', filebrowserFlashUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash' });
            </script>
        <?php $this->_endblock(); ?>
