<dl>
  <dt><?php echo Yii::t('Competition', 'Location'); ?></dt>
  <dd>
    <?php $this->renderPartial('locations', $_data_); ?>
  </dd>
  <dt><?php echo Yii::t('Competition', 'Travel Info'); ?></dt>
  <dd><?php echo $competition->getAttributeValue('travel'); ?></dd>
</dl>
