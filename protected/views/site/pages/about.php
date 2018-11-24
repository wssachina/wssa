<?php $config = Config::getConfig('about'); ?>
<?php $this->setPageTitle(array('About')); ?>
<?php $this->setTitle('About'); ?>
<?php $this->setMetaInfo($config); ?>
<?php $this->breadcrumbs = array(
    'About'
); ?>
<?php $this->renderPartial('aboutSide', $_data_); ?>
<div class="content-wrapper col-md-10 col-sm-9">
  <?php echo $config ? $config->getAttributeValue('content') : ''; ?>
</div>
