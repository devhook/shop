<?=Form::open() ?>

<div class="panel">
	<div class="panel-heading">
		<h3 class="panel-title">Личные данные</h3>
	</div>
	<div class="panel-body row">

		<div class="col-lg-6">
			<?=$userForm->row('name') ?>
			<?=$userForm->row('phone') ?>
			<?=$userForm->row('email') ?>
		</div>
		<div class="col-lg-6">
			<?=$loginForm->row('email') ?>
			<?=$loginForm->row('password') ?>
		</div>

	</div>
</div>

<button class="btn btn-primary">OK</button>

<?=Form::close() ?>