<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var \App\Entity\User $user
 * @var int $balance
 * @var array $errors
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
		<h3>Deposit funds</h3>
	</div>
	<div class="inner-content">
		<p>Your current balance: <?=$this->encode($balance);?></p>
		<form method="post" action="<?=$this->generatePath("deposit")?>">
			<?php if ($errors): ?>
				<p>
					<div class="alert alert-danger" role="alert">
						<?php foreach ($errors as $error): ?>
							<?=$this->encode($error).'<br>';?>
						<?php endforeach; ?>
					</div>
				</p>
			<?php endif; ?>
			<p>
				How much do you want to deposit:
				<input type="text" name="deposit_amount">
			</p>
			<p>
				Select a payment method:
				<select name="payment_method">
					<option value="card">Card</option>
				</select>
			</p>
			<p>
				<input type="submit">
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