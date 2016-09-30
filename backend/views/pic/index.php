<body>
    <div class="sims_sbumit">
      <?foreach ($list as $key => $value) {?>
        <img src="<? echo $_BASE_DIR.$value['path']?>">
      <?}?>
    </div>
</body>