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
