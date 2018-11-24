<?php $config = Config::getConfig('contact'); ?>
<?php $this->setPageTitle(['Contact']); ?>
<?php $this->setTitle('Contact'); ?>
<?php $this->setMetaInfo($config); ?>
<?php $this->breadcrumbs = array(
  'Contact'
); ?>
<?php $this->renderPartial('aboutSide', $_data_); ?>
<div class="content-wrapper col-md-10 col-sm-9">
  <?php echo $config ? $config->getAttributeValue('content') : ''; ?>
</div>
