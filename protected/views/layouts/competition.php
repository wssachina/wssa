<?php $this->beginContent('//layouts/main'); ?>
  <?php $this->renderPartial('sidebar', $_data_); ?>
  <div class="col-sm-12 col-md-9 col-lg-10 competition-<?php echo strtolower($this->competition->type); ?>">
    <?php echo $content; ?>
  </div>
<?php $this->endContent(); ?>
