<? $this->_extends("_layouts/main_layout"); ?>
<? $this->_block("contents"); ?>
<script type="text/javascript">
<!--
    function check(orgid,name,power,uploadname) {
        if(orgid == 2 || name == uploadname|| power == uploadname){
            return confirm('确定删除吗？');
        }
        alert("只有管理员或本人可以删除！");
        return false; 
    }
    function check1(orgid,name,power,uploadname) {
        if(orgid != 2 && name != uploadname&& power != uploadname){
            alert("只有管理员或本人可以修改！");
            return false; 
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
<div class="row-fluid sortable" style="width:95%">		
    <div class="box span12">
        <div class="box-content">
            <div class="row-fluid">
                <form class="fsimple" id="form_news_search" name="form_news_search" action="" method="get" enctype="application/x-www-form-urlencoded" qform_group_id="" >	
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
                                    <td id="school1">
                                        <select name="school" style="width:150px;" id="school" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择学校</option>';
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
                                        <select name="makingname" style="width:150px;" id="makingname" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择上传人</option>';
                                            foreach ($list1 as $k => $v) {
                                                if (strlen($makingname) && $makingname == $v) {
                                                    $sel = 'selected';
                                                    } else {
                                                    $sel = '';
                                                    }
                                                echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                                    }?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="free" style="width:130px;" id="free" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择费用结算</option>';
                                            foreach ($Isfree as $k => $v) {
                                                if (strlen($free) && $free == $k) {
                                                    $sel = 'selected';
                                                    } else {
                                                    $sel = '';
                                                    }
                                                echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
                                                    }?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="schedule" style="width:130px;" id="schedule" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择进度</option>';
                                            foreach ($Isschedule as $k => $v) {
                                                if (strlen($schedule) && $schedule == $k) {
                                                    $sel = 'selected';
                                                    } else {
                                                    $sel = '';
                                                    }
                                                echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
                                                    }?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="subtitle" style="width:130px;" id="subtitle" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择字幕</option>';
                                            foreach ($Issubtitle as $k => $v) {
                                                if (strlen($subtitle) && $subtitle == $k) {
                                                    $sel = 'selected';
                                                    } else {
                                                    $sel = '';
                                                    }
                                                echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
                                                    }?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div>
                                <div class="btn2 ml20" onclick="$('.fsimple').submit();"><span class="shadow white">查询</span></div>
                                <div class="btn2 ml20" onclick="window.location.href='<?php echo url('');?>';"><span class="shadow white">重置</span></div>
    
                                <?php if (hp('project.2')) { ?>
                                    <div  class="btn2 ml20" onclick="window.location.href = '<?php echo url('videomaking/create'); ?>';" />添加</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>		
            </div>

                <table class="list_table" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th style="width:5%">序号</th>
                        <th style="width:8%">项目名称</th>
                        <th style="width:8%">学校</th>
                        <th style="width:9%">课程名称</th>
                        <th style="width:7%">总时长</th>
                        <th style="width:4%">字幕</th>
                        <th style="width:5%">课时数</th>
                        <th style="width:5%">进度</th>
                        <th style="width:6%">费用结算</th>
                        <th style="width:23%">上传路径(制作路径)</th>
                        <th style="width:5%">上传人</th>
                        <?php if (hp('project.3') || hp('project.4')) { ?>
                            <th style="width:12%">操作</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ( ! empty($list)) {
                        foreach ($list as $i => $row) {?>
                        <tr>
                            <td><?php echo $i + $start + 1 ?></td>
                            <td><?php echo $row['projectname']; ?></td>
                            <td><?php echo $row['school']; ?></td>
                            <td><a href="<?=url('courseware',array('courcename'=>$row['courcename']))?>"><?php echo stripslashes(str_replace($courcename, '<font color=red>' . $courcename . '</font>', $row['courcename'])); ?></a></td>
                            
                            <td><?php echo $row['totalday1']; ?></td>
                            <td><?php
                                if ($row['subtitle'] == 1) {
                                    echo '<font>有</font>';
                                } else {
                                    echo '无';
                                }
                                ?></td>
                            <td><?php echo $row['class_hour']; ?></td>
                            <td><?php
                                if ($row['schedule'] == 1) {
                                    echo '<font>修改中</font>';
                                } 
                                elseif ($row['schedule'] == 2) {
                                    echo '<font>已完成</font>';
                                }
                                else {
                                    echo '制作中';
                                }?></td>
                            <td><?php
                                if ($row['free'] == 1) {
                                    echo '<font>是</font>';
                                } else {
                                    echo '否';
                                }
                                ?></td>
                            <td style="text-align: left;">
                               <?php echo stripslashes($row['making_path']); ?> 
                            </td>
                            <td><?php echo $row['makingname']; ?></td>
                                <?php if (hp('project.3') || hp('project.4')) { ?>
                                <td>
                                    <?php if (hp('project.3')) { ?>
                                        <a class="edit" style="color:#e7613d;" href="<?= url('videomaking/edit', array('id' => $row['id'])) ?>" onclick="return check1(<?php echo $row['orgid'];?>,'<?php echo $user['name'];?>','<?php echo $user['power'];?>','<?php echo $row['makingname']; ?>')" title="修改"><i class="icon-edit icon-white"></i>修改</a>&nbsp;
                                    <?php } ?>
                                    <?php if (hp('project.4')) { ?>
                                        <a class="delete" style="color:#e7613d;" href="<?= url('videomaking/delete', array('id' => $row['id'])) ?>" onclick="return check(<?php echo $row['orgid'];?>,'<?php echo $user['name'];?>','<?php echo $user['power'];?>','<?php echo $row['makingname']; ?>')" title="删除"><i class="icon-trash icon-white"></i>删除</a>
                                    <?php } ?>
                                    <?php if (hp('project.3')) { ?>
                                    <a class="add" style="color:#e7613d;" href="<?= url('courseware/create', array('id' => $row['id'])) ?>" title="添加课件"><i class="icon-edit icon-white"></i>添加课件</a>&nbsp;
                                <?php } ?>
                                </td>
                                <?php } ?>
                        </tr>
                        <? } ?>
                    <?}?>
                    </tbody>
                    
                </table>
                <div style=" float:right">
                    <span>总时长：<?php  echo $alltime; ?></span>&nbsp;&nbsp;&nbsp;
                    <span>课时数：<?php echo $allclass; ?></span>
                </div>
            <br/>
    <? $this->_control("pagination", "", array('pagination' => $pager)); ?>

        </div>
    </div>
<? $this->_endblock(); ?>
