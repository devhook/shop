<? Page::title('Магазин: Заказы') ?>

<? $typeClass = array(
	'' => '',
	'0' => '',
	'1' => 'active', // new
	'2' => 'active', // process
	'3' => '', // complete
	'4' => '', // canceld
) ?>
<table class="table table-hover">

	<thead>
		<tr>
			<th width="1"></th>
			<th width="1">Заказ</th>
			<th width="200">Заказчик</th>
			<th>Примечание</th>
			<th width="1">Время</th>
			<th width="1">Стоимость</th>
			<th width="1"></th>
		</tr>
	</thead>
	<? $group = '' ?>
<? foreach ($data as $row): ?>
	<? $statusColor = $row->orderStatus ? $row->orderStatus->color : '' ?>
	<? $statusIcon  = $row->orderStatus ? $row->orderStatus->icon : '' ?>
	<? $statusLabel = $row->orderStatus ? $row->orderStatus->title : '' ?>
	<? $type = $row->orderStatus ? $row->orderStatus->type : 0 ?>
	<? $date = $row->created_at->format('d M Y') ?>

	<?// Дата ?>
	<? if ($group != $date && $group = $date): ?>
		<thead>
			<tr>
				<td colspan="20" class="text-center" style="padding:40px 0 5px">
					<span class="label label-primary"><?=$row->created_at->format('d M Y') ?></span>
				</td>
			</tr>
		</thead>
	<? endif ?>

	<tr<?=$type==4 ? ' class="text-muted"' : '' ?>>

		<?// Иконка статуса ?>
		<td><i style="color:<?=$statusColor ?>" class="icon-<?=$statusIcon ?> icon-large"></i></td>

		<?// № заказа ?>
		<td nowrap="nowrap">
			<a style="color:<?=$statusColor ?>" href="<?=Admin::url('shop/orders', $row->id) ?>">
				Заказ №<?=$row->id ?>
				<i class="icon-chevron-sign-right"></i>
			</a>
		</td>

		<?// Заказчик ?>
		<td>
			<? if($row->user_id): ?>
				<i class="icon-user"></i> <?=$row->user->name ?> <?=$row->user->last_name ?>
			<? else: ?>
				<?=$row->firstname ?> <?=$row->lastname ?>
			<? endif ?>
		</td>

		<?// примечание ?>
		<td>
			<? if ($row->orderTags): ?>
				<? foreach ($row->orderTags as $tag): ?>
					<?=$tag->label ?>
				<? endforeach ?>
			<? endif ?>
			<?=$row->note ?>
		</td>

		<?// Время ?>
		<td nowrap="nowrap" class="text-muted">
			<?=$row->created_at->format('H:i') ?>
		</td>

		<?// Стоимость ?>
		<td nowrap="nowrap">
			<span class="badge" style="background:#<?=$row->total > 10000 ? 'C30' : '09C' ?>"><?=price($row->total) ?></span>
		</td>

		<?// Действия ?>
		<td nowrap="nowrap">
			<div class="btn-group">
				<button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
					<i style="color:<?=$statusColor ?>" class="icon-<?=$statusIcon ?> icon-large"></i>
					<? //=$statusLabel ?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<? foreach ($statusList as $status): ?>
						<li class="<?=$status->id == $row->status ? 'active' : '' ?>"><a href="#"><i style="color:<?=$status->color ?>" class="icon-<?=$status->icon ?> icon-large"></i> <?=$status->title ?></a></li>
					<? endforeach ?>
				</ul>
			</div>
			<a href="#" class="btn btn-xs btn-default"><i class="icon-print icon-large"></i></a>
		</td>
	</tr>
<? endforeach ?>

</table>

<?=$pagination ?>