<body>
    <div class="sims_sbumit">
      <?foreach ($model as $key => $value) {?>
          <? var_dump($value['path']); ?>
        <img src="<?= '../../' .$value['path']?>">
      <?}?>
    </div>
</body>