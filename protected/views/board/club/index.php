<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
          <div class="portlet-title">
              <h4>俱乐部列表</h4>
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
              [
                'name'=>'province_id',
                'value'=>'$data->province->name_zh',
                'filter'=>false,
              ],
              [
                'name'=>'city_id',
                'value'=>'$data->city->name_zh',
                'filter'=>false,
              ],
              'contact_name',
              'address',
              'phone',
              array(
                'name'=>'status',
                'type'=>'raw',
                'value'=>'$data->getStatusText()',
                'filter'=>Club::getAllStatus(),
              ),
            ),
          )); ?>
        </div>
      </div>
    </div>
  </div>
</div>
