<? $this->_extends("_layouts/main_layout"); ?>
<? $this->_block("contents"); ?>

<script type="text/javascript">
function changecheck2(v){
  $.ajax({
      type: "post",
      method: "post",
      dataType: "json",
      data: {"v": v},
      url: "<?php echo url('/changecheck');?>",
      success: function(data){
        console.log(data);
        var educational = data.educational;

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
                                        <select name="projectname" style="width:150px;" id="projectname" class="dept_select" onchange="changecheck2(this.options[this.options.selectedIndex].value)"> 
                                            <?
                                            echo '<option value="">选择项目</option>';
                                            foreach ($item as $k => $v) {
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
                                            foreach ($education as $k => $v) {
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
                        <th style="width:15%">项目名称</th>
                        <th style="width:15%">学校</th>
                        <th style="width:10%">拍摄时长</th>
                        <th style="width:15%">制作时长</th>
                        <th style="width:15%">日期</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //print_r($list);
                    foreach ($list3 as $i => $row) {?>
                        <tr>
                            <td><?php echo $i + $start + 1 ?></td>
                            <td><?php echo $row['projectname']; ?></td>
                            <td><?php echo $row['school']; ?></td>
                            <td><?php echo $row['capture_time']; ?></td>  
                            <td><?php echo  $row['totalday1']; ?></td>                         
                            <td><?php echo date('Y-m-d',$row['time']); ?></td>                                                         
                        </tr> 

                 <? } ?>
                        
                    </tbody>
                </table>
                <div style=" float:right">
                    <span>拍摄总时间：<?php echo $capture_time;?></span>&nbsp;&nbsp;&nbsp;    
                    <span>制作总时间：<?php echo $totalday;?></span>
                </div>
            <br/>
    <? $this->_control("pagination", "", array('pagination' => $pager)); ?>
                
        </div>
    </div>
<? $this->_endblock(); ?>
