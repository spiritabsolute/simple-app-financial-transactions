<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var \App\Entity\User $user
 * @var int $balance
 */

$this->extend("layout/columns");
?>

<?php $this->beginBlock("title"); ?>
Financial transactions - withdraw
<?php $this->endBlock(); ?>

<?php $this->beginBlock("navbar"); ?>
<a href="<?=$this->generatePath("home")?>">Home</a>
<a class="active" href="<?=$this->generatePath("cabinet")?>">Cabinet</a>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("main"); ?>
<div class="content">
	<div class="title">
		<h3>Withdraw funds</h3>
	</div>
	<div class="inner-content">
		<p>Your current balance: <?=$this->encode($balance);?></p>
		<form method="post" action="<?=$this->generatePath("withdraw")?>">
			<p>
				How much do you want to withdraw:
				<input type="text" name="withdraw_sum">
				<input type="hidden" name="payment_method" value="card">
			</p>
		</form>
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