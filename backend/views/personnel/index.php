<? $this->_extends("_layouts/main_layout"); ?>
<? $this->_block("contents"); ?>
<script type="text/javascript">
<!--
    function check() {
        return confirm('确定删除吗？');
    }
    $(function(){
    $('.dept_select').chosen();
});
//-->
</script>
<div class="row-fluid sortable" style="width:95%">      
    <div class="box span12">
        <div class="box-content">
            <div class="row-fluid">
                <form class="fsimple" id="form_news_search" name="form_news_search" action="" method="get" enctype="application/x-www-form-urlencoded" qform_group_id="" >  
                    <div class="span10" style="margin-bottom:7px;margin-left:40px;">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <select name="name" style="width:150px;" id="name" class="dept_select"> 
                                <?
                                echo '<option value="">选择人员</option>';
                                foreach ($list1 as $k => $v) {
                                    if (strlen($name) && $name == $k) {
                                        $sel = 'selected';
                                        } else {
                                        $sel = '';
                                        }
                                    echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
                                        }?>
                                </select>
                                <div>
                                    <?php if (hp('project.2')) { ?>
                                        <div class="btn2 ml20" onclick="$('.fsimple').submit();"><span class="shadow white">查询</span></div>
                                        <div class="btn2 ml20" onclick="window.location.href='<?php echo url('');?>';"><span class="shadow white">重置</span></div>
                                        <div class="btn2 ml20" onclick="window.location.href = '<?php echo url('personnel/create'); ?>';" style="<?if ($list[0]['orgid']!=2) {
                                           echo "display:none;";}?>"/>添加</div>
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
                        <th style="width:10%">用户名</th>
                        <th style="width:20%">密码</th>
                        <th style="width:10%">角色</th>
                        <th style="width:10%">权限分配给</th>
                        <th style="width:10%">获取权限</th>
                        <?php if (hp('project.3') || hp('project.4')) { ?>
                            <th style="width:15%">操作</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //print_r($list);
                    foreach ($list as $i => $row) {
                        // var_dump($list);exit;
                        ?>
                        <tr>
                            <td><?php echo $i + $start + 1 ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                            <td><?php
                                if ($row['orgid'] == 0) {
                                    echo '<font>用户</font>';
                                }elseif ($row['orgid'] == 1) {
                                    echo '<font>审核人</font>';
                                } else {
                                    echo '管理员';
                                }
                                ?></td>
                                <td><?php echo $row['orgname']; ?></td>
                                <td><?php echo $row['power']; ?></td>
                                <?php if (hp('project.3') || hp('project.4')) { ?>
                                <td>
                                    <?php if (hp('project.3')) { ?>
                                        <a class="edit" style="color:#e7613d;" href="<?= url('personnel/edit', array('id' => $row['id'])) ?>" title="修改"><i class="icon-edit icon-white"></i>修改</a>&nbsp;
                                <?php } ?>
                                <?php if (hp('project.4')) { ?>
                                        <a class="delete" style="color:#e7613d;<?if ($row['orgid']!=2) {
                                           echo "display:none;";
                                        }?>" href="<?= url('personnel/delete', array('id' => $row['id'])) ?>" onclick="return check() ?>)" title="删除"><i class="icon-trash icon-white"></i>删除</a>
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
