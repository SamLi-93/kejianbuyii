<? $this->_extends("_layouts/main_layout"); ?>
<? $this->_block("contents"); ?>
<script type="text/javascript">
<!--
    function check(orgid,name,uploadname) {
        if(orgid == 2 || name == uploadname){
            return confirm('确定删除吗？');
        }
        alert("只有管理员或本人可以删除！");
        return false; 
    }
    function check1(orgid,name,uploadname) {
        if(orgid != 2 && name != uploadname){
            alert("只有管理员或本人可以修改！");
            return false; 
        }  
    }
//-->
$(function(){
    $('.dept_select').chosen();
});
</script>
<div class="row-fluid sortable" style="width:95%">		
    <div class="box span12">
        <div class="box-content">
            <div class="row-fluid">
                <form class="fsimple" id="form_news_search" name="form_news_search" action="<?=url('teacher/index')?>" method="get" enctype="application/x-www-form-urlencoded" qform_group_id="" >	
                    <div class="span10" style="margin-bottom:7px;margin-left:40px;">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <select name="teacher" style="width:150px;" id="teacher" class="dept_select"> 
                                <?
                                echo '<option value="">选择讲师</option>';
                                foreach ($master as $k => $v) {
                                    if (strlen($teacher) && $teacher == $v) {
                                        $sel = 'selected';
                                        } else {
                                        $sel = '';
                                        }
                                    echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                        }?>
                            </select>
                        
                            <select name="school" style="width:150px;" id="school" class="dept_select"> 
                                <?
                                echo '<option value="">选择院校</option>';
                                foreach ($education as $k => $v) {
                                    if (strlen($school) && $school == $v) {
                                        $sel = 'selected';
                                        } else {
                                        $sel = '';
                                        }
                                    echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                        }?>
                            </select>

                                <div>
                                    <div class="btn2 ml20" onclick="$('.fsimple').submit();"><span class="shadow white">查询</span></div>
                                    <div class="btn2 ml20" onclick="window.location.href='<?php echo url('');?>';"><span class="shadow white">重置</span></div>
        
                                    <?php if (hp('project.2')) { ?>
                                        <div  class="btn2 ml20" onclick="window.location.href = '<?php echo url('teacher/create'); ?>';" />添加</div>
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
                        <th style="width:15%">院校</th>
                        <th style="width:10%">讲师姓名</th>
                        <th style="width:7%">性别</th>
                        <th style="width:15%">联系电话</th>
                        <th style="width:15%">QQ或邮箱</th>
                        <th style="width:15%">备注</th>
                        <?php if (hp('project.3') || hp('project.4')) { ?>
                            <th style="width:20%">操作</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($list as $i => $row) {
                        ?>
                        <tr>
                            <td><?php echo $i + $start + 1 ?></td>
                            <td><?php echo $row['college']; ?></td>
                            <td><?php echo $row['teacher']; ?></td>
                            <td><?php
                                if ($row['sex'] == 0) {
                                    echo '<font>男</font>';
                                } else {
                                    echo '女';
                                }
                                ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['qq']; ?></td>
                            <td><?php echo $row['remarks']; ?></td>
                            <?php if (hp('project.3') || hp('project.4')) { ?>
                            <td>
                                <?php if (hp('project.3')) { ?>
                                    <a class="edit" style="color:#e7613d;" href="<?= url('teacher/edit', array('id' => $row['id'])) ?>" onclick="return check1(<?php echo $row['orgid'];?>,'<?php echo $user['name'];?>','<?php echo $row['uploadname']; ?>')" title="修改"><i class="icon-edit icon-white"></i>修改</a>&nbsp;
                                <?php } ?>
                                <?php if (hp('project.4')) { ?>
                                        <a class="delete" style="color:#e7613d;" href="<?= url('teacher/delete', array('id' => $row['id'])) ?>" onclick="return check(<?php echo $row['orgid'];?>,'<?php echo $user['name'];?>','<?php echo $row['uploadname'];?>')" title="删除"><i class="icon-trash icon-white"></i>删除</a>
                                <?php } ?>
                            </td>
                            <?php } ?>
                        </tr> 
            <? } ?>
                    </tbody>
                </table>

            <br/>
    <? $this->_control("pagination", "", array('pagination' => $pager)); ?>

        </div>
    </div>
<? $this->_endblock(); ?>
