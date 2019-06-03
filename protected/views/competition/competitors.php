<?php $columns = $competition->getEventsColumns(); ?>
<?php $this->widget('RepeatHeaderGridView', array(
  'dataProvider'=>$model->search($columns),
  // 'filter'=>false,
  // 'enableSorting'=>false,
  'front'=>true,
  'footerOnTop'=>true,
  'columns'=>$columns,
)); ?>
