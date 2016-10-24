<body>
    <div class="sims_sbumit">
      <?foreach ($model as $key => $value) {?>
<!--          --><?// var_dump($value['path']); ?>
          <div class="pic-div" style="padding-bottom: 80px;float: left; margin-right: 40px;">
              <div class="pic_name" style="text-align: center">
                  <span> <?= ($value['path']); ?> </span>
              </div>
              <img src="<?= '../../' .$value['path']?>">
          </div>

      <?}?>
    </div>
</body>