<aside class="page-sidebar col-sm-12 col-md-3 col-lg-2">
  <?php $items = $this->getCompetitionNavibar($this->competition); ?>
  <section class="widget hidden-xs">
    <?php $this->widget('zii.widgets.CMenu', array(
      'htmlOptions'=>array(
        'class'=>'nav',
      ),
      'encodeLabel'=>false,
      'items'=>$items,
    )); ?>
  </section><!--//widget-->
  <?php $this->widget('zii.widgets.CMenu', array(
    'htmlOptions'=>array(
      'class'=>'nav nav-tabs visible-xs',
    ),
    'encodeLabel'=>false,
    'items'=>$items,
  )); ?>
</aside>
