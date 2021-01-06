<?php $this->beginContent('//layouts/simple'); ?>
<div class="wrapper">
  <header class="header">
    <div class="header-main container">
      <h1 class="logo col-md-4 col-sm-4">
          <a href="<?php echo $this->createUrl('/site/index'); ?>"><img id="logo" src="/f/images/logo<?php if (Yii::app()->language == 'en') echo '-en'; ?>.png" alt="Logo"></a>
      </h1><!--//logo-->
      <div class="info col-md-8 col-sm-8 hidden-xs">
        <ul class="menu-top navbar-right">
        <?php foreach (Config::getConfig('toplinks.*') as $key=>$link): ?>
          <li>
            <?php echo CHtml::link($link->getAttributeValue('content'), $link->getAttributeValue('title'), ['target'=>'_blank']); ?>
          </li>
        <?php endforeach; ?>
        </ul>
        <br />
        <div class="contact pull-right">
          <?php if (Yii::app()->user->isGuest): ?>
          <p class="phone"><?php echo CHtml::link(Html::fontAwesome('sign-in') . Yii::t('common', 'Login'), array('/site/login')); ?></p>
          <p class="email"><?php echo CHtml::link(Html::fontAwesome('user') . Yii::t('common', 'Register'), array('/site/register')); ?></p>
          <?php else: ?>
          <p class="phone"><?php echo CHtml::link(Html::fontAwesome('user') . $this->user->getAttributeValue('name', true), array('/user/profile')); ?></p>
          <p class="email"><?php echo CHtml::link(Html::fontAwesome('sign-out') . Yii::t('common', 'Logout'), array('/site/logout')); ?></p>
          <?php endif; ?>
        </div>
      </div><!--//info-->
    </div><!--//header-main-->
  </header><!--//header-->
  <?php $this->widget('Navibar'); ?>

  <div class="content container">
    <div class="page-wrapper">
      <?php if ($this->title != ''): ?>
      <header class="page-heading clearfix">
        <h1 class="heading-title pull-left"><?php echo $this->title; ?></h1>
        <?php $this->widget('Breadcrumbs'); ?>
      </header>
      <?php endif; ?>
      <div class="page-content">
        <div class="row page-row">
          <?php
            $flashes = Yii::app()->user->flashes;
            if (!empty($flashes)):
          ?>
          <div class="col-lg-12">
          <?php foreach ($flashes as $type=>$value): ?>
          <div class="alert alert-<?php echo $type; ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $value; ?>
          </div>
          <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <?php echo $content; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<footer class="footer">
  <div class="bottom-bar">
    <div class="container">
      <div class="row">
        <small class="copyright col-md-6 col-sm-12 col-xs-12">Copyright © <?php echo date('Y'); ?> 北京金色王国文化传播有限公司 <a href="https://beian.miit.gov.cn/">京ICP备18011908号-1</a></small>
        <ul class="social pull-right col-md-6 col-sm-12 col-xs-12">
          <li class="row-end"><?php echo CHtml::link(Html::fontAwesome('rss'), array('/feed/index')); ?></li>
        </ul>
      </div><!--//row-->
    </div><!--//container-->
  </div><!--//bottom-bar-->
</footer><!--//footer-->
<?php $this->endContent(); ?>
