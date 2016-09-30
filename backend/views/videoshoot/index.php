<? $this->_extends("_layouts/main_layout"); ?>
<? $this->_block("contents"); ?>
<script type="text/javascript">
<!--
    function check(orgid,name,power,uploadname,status) {
        
        if (status == "修改中"||status == "一级驳回") {
            if (orgid == 2 ||name == uploadname||power == uploadname) {

                return confirm('确定删除吗？');
            }
            else{
                alert("只有管理员或本人可以删除！");
                return false; 
            }
        }
        if (status == "一级审核中") {
            if (orgid == 2 || orgid == 1) {
                return confirm('确定删除吗？');
            }
            else{
                alert("该记录一级审核中，不允许删除");
                return false; 
            }
        }
        if (status == "一级通过") {
            if (orgid == 2 || orgid == 1) {
                return confirm('确定删除吗？');
            }
            else{
                alert("该记录一级通过，不允许删除");
                return false; 
            }
        }
        if (status == "二级审核中") {
            if (orgid == 2) {
                return confirm('确定删除吗？');
            }
            else{
                alert("该记录二级审核中，不允许删除");
                return false; 
            }
        }
        if (status == "二级通过") {
            alert("该记录二级审核通过，不允许删除");
            return false;
        }
    }
    function check1(orgid,name,power,uploadname,status) {
        if (status == "修改中"||status == "二级通过"||status == "一级驳回"||status == "二级驳回") {
            
            if(orgid != 2 && name != uploadname&& power != uploadname){
                alert("只有管理员或本人可以修改！");
                return false; 
            } 
        }
        if (status == "一级通过") {
            if(orgid != 2 && name != uploadname&& power != uploadname){
                alert("只有管理员或本人可以修改！");
                return false; 
            } 
        }
        if (status == "一级审核中") {
            if (orgid != 1 && orgid != 2) {
                alert("该记录一级审核中，不允许修改");
                return false; 
            }
        }
        if (status == "二级审核中") {
            if (orgid != 2) {
                alert("该记录二级审核中，不允许修改");
                return false; 
            }
        }
    }
//-->
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
</script>
<script type="text/javascript">
        $(function() {
        $('#form_news_search').submit(function() {
            if ($.trim($('#age').val()) == '' && $.trim($('#month').val()) != '') {
                alert('请输入年份！');
                $('#projectname').focus();
                return false;
            }
        });
    });
</script>
</script>
<div class="row-fluid sortable" style="width:95%">		
    <div class="box span12">
        <div class="box-content">
            <div class="row-fluid">
                <form class="fsimple" id="form_news_search" name="form_news_search" action="<?=url('videoshoot/index')?>" method="get" enctype="application/x-www-form-urlencoded" qform_group_id="" >	
                    <div class="span10" style="margin-bottom:7px;margin-left:40px;">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <table>
                                <tr>
                                    <td>
                                        <select name="projectname" style="width:150px;" id="projectname" class="dept_select" onchange="changecheck(this.options[this.options.selectedIndex].value)"> 
                                            <?
                                            echo '<option value="">选择项目</option>';
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
                                    <td id="courcename1">
                                        <select name="courcename" style="width:150px;" id="courcename" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择课程名称</option>';
                                            foreach ($coursename as $k => $v) {
                                                if (strlen($courcename) && $courcename == $v) {
                                                    $sel = 'selected';
                                                    } else {
                                                    $sel = '';
                                                    }
                                                echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                                    }?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="recordname" style="width:150px;" id="recordname" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择录制人员</option>';
                                            foreach ($list1 as $k => $v) {
                                                if (strlen($recordname) && $recordname == $v) {
                                                    $sel = 'selected';
                                                    } else {
                                                    $sel = '';
                                                    }
                                                echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                                    }?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="uploadname" style="width:150px;" id="uploadname" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择上传人</option>';
                                            foreach ($list1 as $k => $v) {
                                                if (strlen($uploadname) && $uploadname == $v) {
                                                    $sel = 'selected';
                                                    } else {
                                                    $sel = '';
                                                    }
                                                echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                                    }?>
                                        </select>
                                    </td>
                                    <td>选择月份：</td>
                                    <td>
                                        <input name="age" type="text" aria-controls="DataTables_Table_0" id="age" value="<?php echo $age; ?>" placeholder="输入年份"/>
                                    </td>
                                    <td>
                                        <select name="month" style="width:150px;" id="month" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择月份</option>';
                                            foreach ($Ismonth as $k => $v) {
                                                if (strlen($month) && $month == $k) {
                                                    $sel = 'selected';
                                                    } else {
                                                    $sel = '';
                                                    }
                                            echo '<option value="' . $k . '" ' . $sel . '>' . $v .'月份' . '</option>';
                                            }?>
                                        </select> 
                                    </td>
                                </tr>
                            </table>         
                            <div>
                                <div class="btn2 ml20" onclick="$('.fsimple').submit();"><span class="shadow white">查询</span></div>
                                <div class="btn2 ml20" onclick="window.location.href='<?php echo url('');?>';"><span class="shadow white">重置</span></div>
    
                                <?php if (hp('project.2')) { ?>
                                    <div  class="btn2 ml20" onclick="window.location.href = '<?php echo url('videoshoot/create'); ?>';" />添加</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>		
            </div>

                <table class="list_table" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th style="width:3%">序号</th>
                        <th style="width:8%">项目名称</th>
                        <th style="width:8%">学校</th>
                        <th style="width:8%">课程名称</th>
                        <th style="width:6%">录制人员</th>
                        <th style="width:5%">主讲人</th>
                        <th style="width:13%">拍摄时间</th>
                        <th style="width:6%">拍摄时长（小时）</th>
                        <th style="width:3%">机位</th>
                        <th style="width:5%">上传人</th>
                        <th style="width:20%">上传路径(原始路径)</th>
                        <th style="width:5%">状态</th>
                        <?php if (hp('project.3') || hp('project.4')) { ?>
                            <th style="width:7%">操作</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($list as $i => $row) {?>  
                        <tr>
                            <td><?php echo $i + $start + 1 ?></td>
                            <td><?php echo $row['projectname']; ?></td>
                            <td><?php echo $row['school']; ?></td>
                            <td><?php echo $row['courcename']; ?></td>                            
                            <td><?php echo $row['recordname']; ?></td>
                            <td><?php echo $row['teacher']; ?></td>
                            <td>
                            <?php
                            //$arrtime = explode(';', $row['time']);
                            //var_dump($row['time']);
                            foreach ($row['time'] as $key => $value) {?>
                                <?php echo $value; ?><br>
                            <?}?>
                            </td>
                            <td><?php echo round($row['capture_time'],2); ?></td>
                            <td><?php echo $row['seat']; ?></td>
                            <td><?php echo $row['uploadname']; ?></td>
                            <td style="text-align: left;"><?php echo stripslashes($row['original_path']); ?> 
                            </td>
                            <td><?php echo $row['status']; ?></td>
                                <?php if (hp('project.3') || hp('project.4')) { ?>
                                <td>
                                    <?php if (hp('project.3')) { ?>
                                        <a class="edit" style="color:#e7613d;" href="<?= url('videoshoot/edit', array('id' => $row['id'])) ?>" onclick="return check1(<?php echo $row['orgid'];?>,'<?php echo $user['name'];?>','<?php echo $user['power'];?>','<?php echo $row['uploadname']; ?>','<?php echo $row['status']; ?>')" title="修改"><i class="icon-edit icon-white"></i>修改</a>&nbsp;
                                    <?php } ?>
                                    <?php if (hp('project.4')) { ?>
                                        <a class="delete" style="color:#e7613d;" href="<?= url('videoshoot/delete', array('id' => $row['id'])) ?>" onclick="return check(<?php echo $row['orgid'];?>,'<?php echo $user['name'];?>','<?php echo $user['power'];?>','<?php echo $row['uploadname'];?>','<?php echo $row['status']; ?>')" title="删除"><i class="icon-trash icon-white"></i>删除</a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                        </tr> 
                    <? } ?>
                    </tbody>
                </table>

            <br/>
    <? $this->_control("pagination", "", array('pagination' => $pager,'url_args'=>array('recordname'=>$index_type2,'courcename'=>$index_type1))); ?>

        </div>
    </div>
    
<? $this->_endblock(); ?>
