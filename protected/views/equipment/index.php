<aside class="page-sidebar col-md-2 col-sm-3 affix-top">
  <section class="widget">
    <?php $this->widget('zii.widgets.CMenu', array(
      'htmlOptions'=>array(
        'class'=>'nav',
      ),
      'items'=>$categories,
    )); ?>
  </section><!--//widget-->
</aside>
<div class="content-wrapper col-md-10 col-sm-9">
  <div class="row">
    <?php foreach ($model->search()->getData() as $equipment): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 equipment-list-item">
      <a href="<?php echo CHtml::normalizeUrl(['/equipment/item', 'id'=>$equipment->id]); ?>">
        <div class="square-content equipment-thumb">
          <div class="square-inner">
            <?php echo CHtml::image($equipment->cover, $equipment->getAttributeValue('title')); ?>
          </div>
        </div>
        <h4><?php echo $equipment->getAttributeValue('title'); ?></h4>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
</div>
