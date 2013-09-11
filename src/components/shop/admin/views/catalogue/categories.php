<? if (count($data)): ?>

	<table class="table table-striped">
	<thead>
		<tr>
			<th width="1"></th>
			<th width="1">ID</th>
			<th>Категория</th>
			<th width="1"></th>
			<th width="1"></th>
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
				<? if (isset($childrens[$row->id])): ?>
					<a href="<?=Admin::url('shop/catalogue/categories', $row->id) ?>"><i class="icon-folder-close"></i> <?=$row->title ?></a>

					<span class="label label-default"><?=$childrens[$row->id] ?></span>
				<? else: ?>
					<i class="icon-folder-close"></i> <?=$row->title ?>
				<? endif ?>
			</td>
			<td nowrap="nowrap">
				<i class="icon-align-left" style="color:#<?=$row->description ? '333' : 'DDD' ?>"></i>
				<i class="icon-align-left" style="color:#<?=$row->description2 ? '333' : 'DDD' ?>"></i>
				<i class="icon-camera" style="color:#<?=$row->image ? '333' : 'DDD' ?>"></i>
			</td>
			<td nowrap="nowrap">
				<div class="btn-group">
					<a href="" class="btn btn-xs btn-info"><i class="icon-dropbox icon-large"></i> Товары</a>
					<a href="" class="btn btn-xs btn-info disabled"><?=$row->total_allowed ?></a>
					<a href="" class="btn btn-xs btn-info disabled"><?=$row->total ?></a>
				</div>
			</td>
			<td nowrap="nowrap">
				<?=AdminUI::actions($row->rowActions()) ?>
			</td>
		</tr>
	<? endforeach ?>
	</tbody>
	</table>

<? else: ?>

	<div class="alert alert-info text-center"><i class="icon-gears icon-3x"></i><br>Нет записей</div>

<? endif ?>