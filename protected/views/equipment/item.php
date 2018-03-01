<div class="col-md-3 col-sm-4">
  <div class="square-content equipment-thumb">
    <div class="square-inner">
      <?php echo CHtml::image($equipment->cover, $equipment->getAttributeValue('title')); ?>
    </div>
  </div>
</div>
<div class="content-wrapper col-md-9 col-sm-8">
  <h4>
    <?php echo $equipment->getAttributeValue('title'); ?>
  </h4>
  <hr>
  <div class="equipment-detail">
    <?php echo $equipment->getAttributeValue('content'); ?>
  </div>
</div>
