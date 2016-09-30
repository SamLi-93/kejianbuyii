<? $this->_extends("_layouts/main_layout"); ?>
<? $this->_block("contents"); ?>
<script type="text/javascript">
<!--
    function check(orgid,name,power,uploadname,status) {
        if (status == "未审核"||status == "一级驳回") {
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
        if (status == "未审核"||status == "一级通过"||status == "二级通过"||status == "一级驳回"||status == "二级驳回") {
            
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
    function sub(id){
        alert(id);
        if(confirm("是否确认二级审核通过")){
            $.ajax({
              type: "post",
              method: "post",
              dataType: "json",
              data: {"id": id},
              url: "<?php echo url('/sumbit');?>",
              success: function(){

                }
            });
        }
    }
//-->
$(
    function(){
        $('.dept_select').chosen();
    }

);
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
        var title1 = data.title1;

        var condition_info = "<select id=\"courcename\" class=\"dept_select\" name=\"courcename\" style=\"width:150px\"><option value=\"\">选择课程名称</option>";
        for(var i = 0; i < name.length; i++){
          condition_info +="<option value=\""+name[i]+"\">"+name[i]+"</option>";
          }
          condition_info +="</select>";
        $('#courcename1').html(condition_info);
        $('.dept_select').chosen();

        var condition_info1 = "<select id=\"title\" class=\"dept_select\" name=\"title\" style=\"width:150px\"><option value=\"\">选择视频标题</option>";
        for(var i = 0; i < title1.length; i++){
          condition_info1 +="<option value=\""+title1[i]+"\">"+title1[i]+"</option>";
          }
          condition_info1 +="</select>";
        $('#title1').html(condition_info1);
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
<div class="row-fluid sortable" style="width:95%">		
    <div class="box span12">
        <div class="box-content">
            <div class="row-fluid">
                <form class="fsimple" id="form_news_search" name="form_news_search" action="<?=url('courseware/index')?>" method="get" enctype="application/x-www-form-urlencoded" qform_group_id="" >	
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
                                    <td id="title1">
                                        <select name="title" style="width:150px;" id="title" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择视频标题</option>';
                                            foreach ($heading as $k => $v) {
                                                if (strlen($title) && $title == $v) {
                                                    $sel = 'selected';
                                                    } else {
                                                    $sel = '';
                                                    }
                                                echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                                    }?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="teacher" style="width:150px;" id="teacher" class="dept_select"> 
                                            <?
                                            echo '<option value="">选择讲师</option>';
                                            foreach ($list3 as $k => $v) {
                                                if (strlen($teacher) && $teacher == $v) {
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
                                    <div  class="btn2 ml20" onclick="window.location.href = '<?php echo url('courseware/create'); ?>';" />添加</div>
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
                        <th style="width:10%">项目名称</th>
                        <th style="width:12%">学校</th>
                        <th style="width:10%">课程名称</th>
                        <th style="width:7%">视频标题</th>
                        <th style="width:4%">讲师</th>
                        <th style="width:6%">时长</th>
                        <th style="width:5%">制作人</th>
                        <th style="width:4%">状态</th>
                        <th style="width:7%">开始日期</th>
                        <th style="width:7%">结束日期</th>
                        <th style="width:6%">制作天数</th>
                        <th style="width:5%">审核</th>
                        <?php if (hp('project.3') || hp('project.4')) { ?>
                            <th style="width:7%">操作</th>
                        <?php } ?>
                        <th style="width:8%">审核</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($list as $i => $row) {?>
                        <tr>
                            <td><?php echo $i + $start + 1 ?></td>
                            <td><?php echo $row['projectname']; ?></td>
                            <td><?php echo $row['school']; ?></td>
                            <td><?php echo $row['coursename']; ?></td>                            
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['teacher']; ?></td>
                            <td><?php echo $row['time1']; ?></td>
                            <td><?php echo $row['makingname']; ?></td>
                            <td><?php
                                if ($row['state'] == 0) {
                                    echo '<font>制作中</font>';
                                } elseif ($row['state'] == 1) {
                                    echo '<font>修改中</font>';
                                } else{
                                    echo '<font>已完成</font>';
                                }
                                ?></td>
                            <td><?php echo date('Y-m-d',$row['date']); ?></td>
                            <td><?php echo date('Y-m-d',$row['enddate']); ?></td>
                            <td><?php echo $row['totalday']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                                <?php if (hp('project.3') || hp('project.4')) { ?>
                                <td>
                                    <?php if (hp('project.3')) { ?>
                                        <a class="edit" style="color:#e7613d;" href="<?= url('courseware/edit', array('id' => $row['id'])) ?>" onclick="return check1(<?php echo $row['orgid'];?>,'<?php echo $user['name'];?>','<?php echo $user['power'];?>','<?php echo $row['uploadname']; ?>','<?php echo $row['status']; ?>')" title="修改"><i class="icon-edit icon-white"></i>修改</a>&nbsp;
                                    <?php } ?>
                                    <?php if (hp('project.4')) { ?>
                                        <a class="delete" style="color:#e7613d;" href="<?= url('courseware/delete', array('id' => $row['id'])) ?>" onclick="return check(<?php echo $row['orgid'];?>,'<?php echo $user['name'];?>','<?php echo $user['power'];?>','<?php echo $row['uploadname'];?>','<?php echo $row['status']; ?>')" title="删除"><i class="icon-trash icon-white"></i>删除</a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                                <?php if (hp('project.3') || hp('project.4')) { ?>
                                <td>
                                    <?php if (hp('project.3')) { ?>
                                        <div class="btn4 mr20" onclick="sub(<? echo $row['id'];?>)" style="<?if($row['status']!="二级审核中"){ echo "display:none;";}?>">审核</div>&nbsp;
                                        <a style="color:#e7613d;" href="<?= url('pic/index', array('id' => $row['id'])) ?>"  target="blank">图片</a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                        </tr> 
                    <? } ?>
                    </tbody>
                </table>

            <br/>
    <? $this->_control("pagination", "", array('pagination' => $pager,'url_args'=>array('makingname'=>$index_type,'courcename'=>$index_type1))); ?>

        </div>
    </div>
    
<? $this->_endblock(); ?>
