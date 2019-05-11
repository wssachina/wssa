<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
          <div class="portlet-title">
              <h4>注册码列表</h4>
          </div>
          <div class="clearfix"></div>
      </div>
      <div class="panel-collapse collapse in">
        <div class="portlet-body">
          <?php echo CHtml::link(Html::fontAwesome('plus') . '新增', array('/board/user/addCode'), array('class'=>'btn btn-square btn-large btn-green')); ?>
          <?php echo CHtml::link(Html::fontAwesome('download') . '导出', array('/board/user/exportCode'), array('class'=>'btn btn-square btn-large btn-purple')); ?>
          <?php $this->widget('GridView', array(
            'dataProvider'=>$model->search(),
            'template'=>'{pager}{items}{pager}',
            'filter'=>$model,
            'columns'=>array(
              array(
                'header'=>'操作',
                'headerHtmlOptions'=>array(
                  'class'=>'header-operation-3',
                ),
                'type'=>'raw',
                'value'=>'$data->operationButton',
              ),
              array(
                'headerHtmlOptions'=>array(
                  'class'=>'header-id',
                ),
                'name'=>'id',
                // 'filter'=>false,
              ),
              'code',
              array(
                'filter'=>InvitationCode::getTypes(),
                'name'=>'type',
                'type'=>'raw',
                'value'=>'$data->getTypeText()',
              ),
              array(
                'name'=>'status',
                'filter'=>InvitationCode::getAllStatus(),
                'type'=>'raw',
                'value'=>'$data->getStatusText()',
              ),
              array(
                'header'=>'生成日期',
                'name'=>'create_time',
                'filter'=>false,
                'type'=>'raw',
                'value'=>'date("Y-m-d H:i:s", $data->create_time)',
              ),
            ),
          )); ?>
        </div>
      </div>
    </div>
  </div>
</div>
