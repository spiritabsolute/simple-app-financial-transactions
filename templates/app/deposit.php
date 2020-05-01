<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var string $username
 * @var int $balance
 */

$this->extend("layout/columns");
?>

<?php $this->beginBlock("title"); ?>
Financial transactions - deposit
<?php $this->endBlock(); ?>

<?php $this->beginBlock("navbar"); ?>
<a href="<?=$this->generatePath("home")?>">Home</a>
<a class="active" href="<?=$this->generatePath("cabinet")?>">Cabinet</a>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("main"); ?>
<div class="content">
	<div class="title">
		<h3>Account replenishment</h3>
	</div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("sidebar"); ?>
<div class="side">
	<div>
		<ul>
			<li><a href="<?=$this->generatePath("cabinet")?>">Profile</a></li>
			<li><a href="<?=$this->generatePath("deposit")?>">Deposit</a></li>
			<li><a href="<?=$this->generatePath("withdraw")?>">Withdraw</a></li>
		</ul>
	</div>
</div>
<?php $this->endBlock(); ?>