<div class="col-md-12">
  <?php $this->widget('Carousel', [
    'items'=>$sliders,
    'options'=>[],
    'htmlOptions'=>[
      'class'=>'slider-wrapper',
    ],
  ]); ?>
</div>
<?php $this->widget('ListView', array(
  'itemView'=>'news',
  'dataProvider'=>$news->search(),
  'htmlOptions'=>array(
    'class'=>'news-wrapper col-md-12',
  ),
  'front'=>true,
  'template'=>"{items}\n{pager}",
  'emptyText'=>'',
)); ?>
