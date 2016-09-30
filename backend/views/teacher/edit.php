<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('contents'); ?>
<link type="text/css" href="<?=$_BASE_DIR?>js/calendar/skins/default/theme.css" rel="stylesheet"/>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/calendar.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?=$_BASE_DIR?>js/calendar/lang/calendar-zh-utf8.js"></script>
<script type="text/javascript" src="<?= $_BASE_DIR ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(function() {
    $('#form_news').submit(function(){
        if($.trim($('#teacher').val()) == ''){
          alert('请输入讲师姓名！');
          $('#teacher').focus();
          return false; 
        }
        if($.trim($('#phone').val()) == ''){
          alert('请输入联系电话！');
          $('#phone').focus();
          return false; 
        }
        var numValue = document.getElementById("phone").value;
        numValue = numValue.replace(/\s/g, "");
        var regBox = {
            regEmail : /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/,//邮箱
            regMobile : /^0?1[3|4|5|8][0-9]\d{8}$/,//手机
            regTel : /^0[\d]{2,3}-[\d]{7,8}$/
        }
     
        var mflag = regBox.regMobile.test(numValue);
        var tflag = regBox.regTel.test(numValue);
        if (!(mflag||tflag)) {
            alert("请输入正确的联系电话！");
            $('#phone').focus();
            return false;
        }
        if($.trim($('#qq').val()) == "无"){
          if(confirm('未输入QQ或邮箱，您确定要提交吗？')){
            return true;  
          }else{
            return false;
          }
        }
    }); 
    $('.dept_select').chosen();
});
function format_phone(){
    $phone = document.getElementById("phone");
    $phone.value = $phone.value.replace(/^(\d{3})(\d{4})(\d{4})$/, '$1 $2 $3')
    // alert($phone);
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
                                <td width="146" >讲师姓名：</td>
                                <td width="842" ><input name="teacher" type="text"  id="teacher" value="<?php echo stripslashes($myData['teacher']); ?>" size="50" /></td>
                            </tr>
                            <tr height="30">
                                <td width="146" >性别：</td>
                                <td width="842" >
                                    <select  id="sex" name="sex" class="dept_select" style="width:200px;">
                                    <?php
                                        foreach($sex as $k => $v){
                                            if ($myData['sex'] == $k) {
                                                $sel = 'selected';
                                            } else {
                                                $sel = '';
                                            }
                                        echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
                                    }?>
                                    </select>
                                </td>
                            </tr>
                            <tr height="30">
                                <td >院校：</td>
                                <td >
                                    <select  id="school" name="school" class="dept_select" style="width:200px;">
                                    <?php
                                        foreach($education as $k => $v){
                                            if ($myData['college'] == $v) {
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
                                <td >电话：</td>
                                <td ><input name="phone" type="text"  id="phone" value="<?php echo stripslashes($myData['phone']); ?>" size="50"  onkeydown="format_phone()" onblur="format_phone()"/></td>
                            </tr>
                            
                            <tr height="30">
                                <td >qq或邮箱:</td>
                                <td ><input name="qq" type="text"  id="qq" value="<?php echo stripslashes($myData['qq']); ?>" size="50" /></td>
                            </tr>
                            <tr height="30">
                                <td >备注：</td>
                                <td ><textarea name="content" id="content" cols="45" rows="5" height="300" value="<?php echo stripslashes($myData['remarks']); ?>"></textarea></td>
                            </tr>
                            <tr height="80">
                              <td ></td>
                                <td>
                                  <div class="btn4 mr20" onclick="javascript:$('.fsimple').submit();">保存</div>
                                  <div class="btn4 mr20" onclick="javascript:location='<?php echo url('teacher')?>';">返回</div></td>
                              </tr>
                        </table>
                    <input type="hidden" name="id" value="<?php echo $myData['id']; ?>" />
                </form>
                </div>
            </div></div>
<script language="javascript">
  CKEDITOR.replace( 'content', { skin: "office2003", width:670, height:250,filebrowserBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html', filebrowserImageBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Images', filebrowserFlashBrowseUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/ckfinder.html?Type=Flash', filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', filebrowserImageUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images', filebrowserFlashUploadUrl : '<?=$_BASE_DIR?>ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash' });
</script>
<?php $this->_endblock(); ?>
