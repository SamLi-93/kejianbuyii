<? $this->_extends("_layouts/main_layout"); ?>
<? $this->_block("contents"); ?>
<script type="text/javascript">
	function project(id){
	    if(confirm("是否上传")){
	        $.ajax({
	            type: "post",
	            method: "post",
	            dataType: "json",
	            data: {"id": id},
	            url: "<?php echo url('/project');?>",
	            success: function(){
	                
	            }
	        });
	    }
	    window.location.href=window.location.href;
	}
	function videoshoot(id){
	    if(confirm("是否上传")){
	        $.ajax({
	            type: "post",
	            method: "post",
	            dataType: "json",
	            data: {"id": id},
	            url: "<?php echo url('/videoshoot');?>",
	            success: function(){
	                
	            }
	        });
	    }
	    window.location.href=window.location.href;
	}
	function videomaking(id){
	    if(confirm("是否上传")){
	        $.ajax({
	            type: "post",
	            method: "post",
	            dataType: "json",
	            data: {"id": id},
	            url: "<?php echo url('/videomaking');?>",
	            success: function(){
	                
	            }
	        });
	    }
	    window.location.href=window.location.href;
	}
	function courseware(id){
	    if(confirm("是否上传")){
	        $.ajax({
	            type: "post",
	            method: "post",
	            dataType: "json",
	            data: {"id": id},
	            url: "<?php echo url('/courseware');?>",
	            success: function(){
	                
	            }
	        });
	    }
	    window.location.href=window.location.href;
	}
	function teacher(id){
	    if(confirm("是否上传")){
	        $.ajax({
	            type: "post",
	            method: "post",
	            dataType: "json",
	            data: {"id": id},
	            url: "<?php echo url('/teacher');?>",
	            success: function(){
	                
	            }
	        });
	    }
	    window.location.href=window.location.href;
	}
</script>
<div class="row-fluid sortable" style="width:95%">		
    <div class="box span12">
        <div class="box-content">
            <div class="btn4 mr20" onclick="project()">上传项目</div>
            <div class="btn4 mr20" onclick="videoshoot()">上传视频拍摄</div>
            <div class="btn4 mr20" onclick="videomaking()">上传课程</div>
            <div class="btn4 mr20" onclick="courseware()">上传课件</div>
            <div class="btn4 mr20" onclick="teacher()">上传讲师</div>
        </div>
    </div>
</div>
<? $this->_endblock(); ?>
