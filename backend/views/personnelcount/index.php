<? $this->_extends("_layouts/main_layout"); ?>
<? $this->_block("contents"); ?>
<script type="text/javascript">

$(function(){
    $('.dept_select').chosen();
});
</script>

<div class="row-fluid sortable" style="width:95%">		
    <div class="box span12">
        <div class="box-content">
            <div class="row-fluid">
                <form class="fsimple" id="form_news_search" name="form_news_search" action="<?=url('personnelcount/index')?>" method="get" enctype="application/x-www-form-urlencoded" qform_group_id="" >	
                    <div class="span10" style="margin-bottom:7px;margin-left:40px;">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <table>
                                <tr>
                                <select name="name" style="width:150px;" id="name" class="dept_select"> 
                                <?
                                echo '<option value="">选择人员</option>';
                                foreach ($list1 as $k => $v) {
                                    if (strlen($name) && $name == $v) {
                                        $sel = 'selected';
                                        } else {
                                        $sel = '';
                                        }
                                    echo '<option value="' . $v . '" ' . $sel . '>' . $v . '</option>';
                                        }?>
                                </select>
                                选择月份：
                                <input name="age" type="text" aria-controls="DataTables_Table_0" id="age" value="<?php echo $age; ?>" placeholder="输入年份"/>
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
                                </tr>

                            </table>
                                <div>
                                    <div class="btn2 ml20" onclick="$('.fsimple').submit();"><span class="shadow white">查询</span></div>
                                    <div class="btn2 ml20" onclick="window.location.href='<?php echo url('');?>';"><span class="shadow white">重置</span></div>
                                </div>
                        </div>
                    </div>
                </form>		
            </div>

                <table class="list_table" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th style="width:5%">序号</th>
                        <th style="width:15%">姓名</th>
                        <th style="width:10%">拍摄总时长</th>
                        <th style="width:10%">制作总时长</th>
                        <th style="width:10%">制作个数</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //print_r($list);
                    foreach ($data as $i => $row) {?>
                        <tr>
                            <td><?php echo $i + $start + 1 ?></td>
                            <td><?php echo  $row['name']; ?></td>
                            <td><a href="<?=url('videoshoot',array('recordname'=>$row['name']))?>"><?php echo round($row['capture_time'],1); ?></a>
                            </td> 
                            <td><a href="<?=url('courseware',array('makingname'=>$row['name']))?>"><?php echo $row['totalday1']; ?></a>
                            </td>
                            <td><a href="<?=url('courseware',array('makingname'=>$row['name']))?>"><?php echo $row['number']; ?></a>
                            </td>                                                                                
                        </tr> 

                 <? } ?>
                    </tbody>
                </table>

            <br/>
  <? $this->_control("pagination", "", array('pagination' => $pager)); ?>
                
        </div>
    </div>
<? $this->_endblock(); ?>
