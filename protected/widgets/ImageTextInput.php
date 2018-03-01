<?php

class ImageTextInput extends Widget {
	public static $id = 0;

	public $model;
	public $name;
	private $_id;

	public function run() {
		$model = $this->model;
		$name = $this->name;
		$this->_id = self::$id++;
		$inputId = 'image-input-' . $this->_id;
		$previewId = 'image-preview-' . $this->_id;
		$uploadId = 'image-upload-' . $this->_id;
		echo Html::hiddenField(CHtml::resolveName($model, $name), CHtml::resolveValue($model, $name), array(
			'class'=>'image-text-input',
			'id'=>$inputId,
			'readonly'=>true,
		));
		echo CHtml::tag('div', [
			'class'=>'image-preview',
			'id'=>$previewId,
			'data-id'=>$this->_id,
		], implode('', [
			CHtml::label('请选择图片', $uploadId),
			CHtml::fileField('dummy' . $this->_id, '', [
				'id'=>$uploadId,
			]),
		]));
		$clientScript = Yii::app()->clientScript;
		$clientScript->registerPackage('upload-preview');
		$clientScript->registerScript('image-text-input',
<<<EOT
$('.image-preview').each(function() {
  var that = $(this)
  var id = that.data('id');
  $.uploadPreview({
    input_field: that.find('input'),
    preview_box: that,
    label_field: that.find('label'),
    label_default: '请选择图片',
    label_selected: '请选择图片',
    no_label: false,
    success_callback: function() {
      var formData = new FormData();
      var file = this.input_field[0].files[0]
      formData.append('imgFile', file, file.name);
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: '/board/upload/image',
          success: function (data) {
              var url = data.url;
              $('#image-input-' + id).val(url)
          },
          error: function (error) {
              alert(error)
          },
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          timeout: 60000
      });
    }
  });
})
EOT
);
	}
}
