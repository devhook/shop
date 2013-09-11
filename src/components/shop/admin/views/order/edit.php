<? Page::title('Магазин: Заказ №' . $order->id) ?>

<div class="page-header row">

	<div class="col-md-5">
		<h2 style="margin: 0;">
			Заказ <span class="text-muted">№</span><?=$order->id ?>
			<i style="color:<?=$order->orderStatus->color ?>" class="icon-<?=$order->orderStatus->icon ?> icon-large"></i>
			<small><?=$order->orderStatus->title ?></small>
		</h2>
	</div>


	<div class="col-md-2 text-center">
		<div class="btn-group">
			<a href="<?=URL::previous() ?>" class="btn btn-default disabled"><i class="icon-long-arrow-left icon-large"></i></a>
			<a href="<?=Admin::url('shop/orders') ?>" class="btn btn-default"><i class="icon-list icon-large"></i></a>
			<a href="<?=URL::previous() ?>" class="btn btn-default"><i class="icon-long-arrow-right icon-large"></i></a>
		</div>
	</div>


	<div class="col-md-5 text-right">
		<button class="btn btn-default"><i class="icon-print"></i></button>

		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				Сохранить как <span class="caret"></span>
			</button>
			<ul class="dropdown-menu text-left" role="menu">
				<? $statusList = $order::statusList() ?>
				<? foreach ($statusList as $status): ?>
					<li class="<?=$status->id == $order->status ? 'active' : '' ?>"><a href="#"><i style="color:<?=$status->color ?>" class="icon-<?=$status->icon ?>"></i> <?=$status->title ?></a></li>
				<? endforeach ?>
			</ul>
		</div>
		<div class="btn-group">
			<button class="btn btn-primary">Сохранить</button>
			<button class="btn btn-info">и закрыть</button>
		</div>
	</div>

</div><!--.page-header-->

<div class="row">

	<div class="col-md-7">
		<div class="panel panel-info">
			<div class="panel-heading">
				Товары
				<button class="btn btn-xs btn-default pull-right"><i class="icon-pencil"></i> Изменить</button>
			</div>
			<table class="table table-striped">
				<col width="1">
				<col>
				<col width="1">
				<col width="1">
				<col width="1">
				<tbody>
				<? $others = array() ?>
				<? foreach ($order->orderProducts as $row): ?>
					<? if ( ! $row->product): ?>
						<? $others[] = $row ?>
					<? else: ?>
					<tr>
						<td><img src="<?=$row->product['thumb'] ? $row->product->thumb->mini : '' ?>" style="max-height:30px; margin:-5px 0" alt=""></td>
						<td>
							<?=$row->title ?>
							<? /*=$row->product ? link_to($row->product->link(), $row->title) : $row->title */ ?>
						</td>
						<td nowrap="nowrap"><?=price($row->price) ?></td>
						<td nowrap="nowrap"><?=$row->count ?> шт.</td>
						<td>
							<a href="" class="btn btn-xs btn-danger"><i class="icon-remove"></i></a>
						</td>
					</tr>
					<? endif ?>
				<? endforeach ?>
				<? foreach ($others as $row): ?>
					<tr>
						<td></td>
						<td><?=$row->title ?></td>
						<td nowrap="nowrap"><?=$row->price ? price($row->price) : '' ?></td>
						<td></td>
						<td></td>
						<!-- <td><a href="" class="btn btn-xs btn-default"><i class="icon-remove text-danger"></i></a></td> -->
					</tr>
				<? endforeach ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="10" class="text-right">
							<h4>Всего: <span class="label label-info"><?=price($order->total) ?></span></h4>
						</td>
					</tr>
				</tfoot>
			</table>
		</div><!--.panel -->

	</div>


	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				Детали заказа
				<button class="btn btn-xs btn-default pull-right"><i class="icon-pencil"></i> Изменить</button>
			</div>
			<table class="table table-condensed">
				<col width="25%">
				<col>
				<? if ($order->user): ?>
				<tr class="warning">
					<td colspan="2">
						<div class="btn-group">
							<a class="btn btn-sm btn-default" href="#"><i class="icon-user"></i> <?=$order->user->name ?> <?=$order->user->last_name ?></a>
							<a class="btn btn-sm btn-default" href="#" title="<?=$order->user->email ?>" data-toggle="tooltip"><i class="icon-envelope"></i></a>
						</div>
						<a class="btn btn-sm btn-default pull-right" href="#" title="Выполнено / Всего" data-toggle="tooltip">
							Заказов:
							<span class="badge">
								<?=Order::where('user_id', $order->user->id)->where('status',3)->count() ?>/<?=Order::where('user_id', $order->user->id)->count() ?>
							</span>
						</a>
					</td>
				</tr>
			<? endif ?>
				<tr>
					<td class="text-muted text-right">Имя:</td>
					<td><?=$order->firstname ?> <?=$order->lastname ?></td>
				</tr>
				<? $fields = array('email', 'phone') ?>
				<? foreach ($fields as $key): ?>
					<? if (!$order->$key) continue ?>
					<tr>
						<td class="text-muted text-right"><?=$form->fieldLabel($key) ?>:</td>
						<td><?=$order->$key ?></td>
					</tr>
				<? endforeach ?>

				<? if ($adress = $order->adress): ?>
					<!-- <tr><td class="text-center" style="background:#DDD; padding:0 5px; color:#777;" colspan="2"><small>Адрес доставки</small></td></tr> -->

					<? $fields = array('country', 'region', 'city', 'metro') ?>
					<? foreach ($fields as $key): ?>
						<? if (!$order->$key) continue ?>
						<tr>
							<td class="text-muted text-right"><?=$form->fieldLabel($key) ?>:</td>
							<td><?=$order->$key ?></td>
						</tr>
					<? endforeach ?>
					<tr>
						<td class="text-muted text-right">Адрес:</td>
						<td><?=$adress ?></td>
					</tr>
				<? endif ?>

				<? if ($order->comments): ?>
					<tr>
						<td class="text-muted text-right">Комментарий:</td>
						<td>
							<?=nl2br($order->comments) ?>
						</td>
					</tr>
				<? endif ?>
			</table>
		</div>

		<div class="panel panel-<?=$order->note ? 'warning' : 'default' ?>">
			<div class="panel-heading clearfix">
				<button class="btn btn-xs btn-default pull-right"><i class="icon-pencil"></i> Изменить</button>
				<? if ($order->note): ?>
					<?=$order->note ?>
				<? else: ?>
					<em class="text-muted">Примечание менеджера</em>
				<? endif ?>
			</div>
		</div>

		<div class="panel panel-default" id="orderTags">
			<div class="panel-heading">Метки
				<span class="label label-danger pull-right" style="display: none;" id="orderTagsProgress">Сохранение...</span>
			</div>
			<div class="panel-body" style="padding:0 10px">


			<? $ids = $order->orderTags->lists('id') ?>
			<? foreach ($orderTagsAll as $tag): ?>
				<? $checked = in_array($tag->getKey(), $ids) ? 'checked="checked"' : '' ?>
				<label class="checkbox">
					<input type="checkbox" name="orderTags[]" value="<?=$tag->getKey() ?>" <?=$checked ?>>
					<?=$tag->label ?>
				</label>
			<? endforeach ?>
			</div>
		</div>

	</div>
</div>


<script>
var ajax_action = '<?=$ajaxAction ?>';

$('#orderTags input').change(function(){
	$('#orderTagsProgress').fadeIn(100);
	$.getJSON(ajax_action + 'tag/' + this.value + '/' + (this.checked ? '1' : '0'), function(data){
		$('#orderTagsProgress').fadeOut(700);
	});
});
</script>