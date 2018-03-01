<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
          <div class="portlet-title">
              <h4>器材列表</h4>
          </div>
          <div class="clearfix"></div>
      </div>
      <div class="panel-collapse collapse in">
        <div class="portlet-body">
          <?php $this->widget('GridView', array(
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'columns'=>array(
              array(
                'header'=>'操作',
                'type'=>'raw',
                'value'=>'$data->operationButton',
              ),
              'id',
              'title_zh',
              'sequence',
              array(
                'name'=>'cover',
                'type'=>'raw',
                'value'=>'CHtml::image($data->cover, "", ["style"=>"width:200px"])',
              ),
              array(
                'name'=>'status',
                'type'=>'raw',
                'value'=>'$data->getStatusText()',
                'filter'=>Equipment::getAllStatus(),
              ),
            ),
          )); ?>
        </div>
      </div>
    </div>
  </div>
</div>
