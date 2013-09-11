<h1>Моя корзина</h1>


<table class="table">
	<? foreach ($products as $row): ?>
	<tr>
		<td><?=$row->thumb ? $row->thumb->mini() : '' ?></td>
		<td><?=$row->link($row->title) ?></td>
		<td><?=price($row->price) ?></td>
		<td>
			<div class="btn-group">
				<a href="<?=URL::to('cart/update/' . $row->id, $row->qty-1) ?>" class="btn btn-default btn-sm">-</a>
				<span class="btn btn-default btn-sm active"><?=$row->qty ?></span>
				<a href="<?=URL::to('cart/update/' . $row->id, $row->qty+1) ?>" class="btn btn-default btn-sm">+</a>
			</div>
		</td>
		<td><?=price($row->totalPrice) ?></td>
	</tr>
	<? endforeach ?>
	<tr>
		<td colspan="4" class="text-right">
		<td>
			<strong>Итого <?=price(Cart::total()) ?></strong>
		</td>
	</tr>
</table>

<hr>
<a href="<?=URL::to('cart/checkout') ?>" class="btn btn-primary pull-right">Оформление заказа</a>