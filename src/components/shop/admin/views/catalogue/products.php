<? if (count($data)): ?>

	<table class="table table-striped">
	<thead>
		<tr>
			<th width="1"></th>
			<th width="1">ID</th>
			<th width="52">Фото</th>
			<th>Название</th>
			<th width="1">Артикул</th>
			<th width="1"></th>
			<th width="1">На&nbsp;складе</th>
			<th width="1">Цена</th>
			<th width="1"></th>
		</tr>
	</thead>
	<tbody>
	<? foreach ($data as $row): ?>
		<tr>
			<td>
				<a href="<?=Admin::url($row->enabledAction()) ?>" class="btn btn-xs btn-<?=$row->enabled ? 'success' : 'danger'?>"><i class="icon-off"></i></a>
			</td>

			<td class="text-muted"><?=$row->id ?></td>

			<td>
				<a href=""><?=$row->image(null, array('style'=>'height:30px; margin:-6px -6px -6px 0; display:block')) ?></a>
			</td>

			<td>
				<?=$row->title ?>
			</td>

			<td nowrap='nowrap'>
				<small><?=$row->sku ?></small>
			</td>

			<td nowrap="nowrap">
				<i class="icon-align-left" style="color:#<?=$row->short_description ? '333' : 'DDD' ?>"></i>
				<i class="icon-align-left" style="color:#<?=$row->description ? '333' : 'DDD' ?>"></i>
				<i class="icon-camera" style="color:#<?=$row->image ? '333' : 'DDD' ?>"></i>
			</td>

			<td class="text-right">
				<span class="label label-<?=$row->in_stock ? 'info' : 'warning' ?>"><?=$row->in_stock ?></span>
			</td>

			<td class="text-right">
				<span class="label label-<?=$row->price ? 'default' : 'warning' ?>"><?=price($row->price) ?></span>
			</td>

			<td nowrap="nowrap">
				<?=AdminUI::actions(array_except($row->rowActions(), 'remove')) ?>
			</td>
		</tr>
	<? endforeach ?>
	</tbody>
	</table>

	<?=$data->links() ?>
<? else: ?>

	<div class="alert alert-info text-center"><i class="icon-gears icon-3x"></i><br>Нет записей</div>

<? endif ?>