<?=Widget::breadcrumbs($breadcrumbs) ?>

<div class="page-header">
	<h1><?=$category->title ?></h1>
</div>

<? if ($subcategories->count()): ?>
	<div class="well well-sm">
	<? foreach ($subcategories as $row): ?>
		<a class='btn btn-default btn-xs' href="<?=$row->link() ?>"><?=$row->title ?></a>
	<? endforeach ?>
	</div>
<? endif ?>

<?=$category->description ?>

<div class="clearfix" style="margin-bottom:20px">
	<div class="pull-right">
		<div class="btn-group">
			<span class="btn btn-default disabled">Сортировка:</span>
			<a href="#" class="btn btn-default">Цена</a>
			<a href="#" class="btn btn-default active">Название</a>
			<a href="#" class="btn btn-default">Рейтинг</a>
		</div>

		<div class="btn-group">
			<span class="btn btn-default disabled">Выводить по:</span>
			<a href="#" class="btn btn-default active">12</a>
			<a href="#" class="btn btn-default">20</a>
			<a href="#" class="btn btn-default">40</a>
			<a href="#" class="btn btn-default">60</a>
		</div>
	</div>
</div>

<div class="row">
<? foreach ($products as $row): ?>
	<div class="col-lg-3">
		<div class="thumbnail" style='height:300px; margin-bottom:20px;'>
			<? if ($row->thumb): ?>
				<a href="<?=$row->link() ?>"><img style='margin:0 auto; display:block' src="<?=$row->thumb->small ?>" alt=""></a>
			<? endif ?>
			<div class="caption">
				<a style="height:2.7em; display:block; overflow:hidden" href="<?=$row->link() ?>"><?=$row->title ?></a>
				<hr>
				<p>
					<a href="<?=$row->link() ?>" class="btn btn-default btn-xs"><?=price($row->price) ?></a>
					<a href="<?=$row->cartLink ?>" class="btn btn-success btn-xs pull-right">В корзину</a>
				</p>
			</div>
		</div>
	</div>
<? endforeach ?>
</div>

<?=$products->links(); ?>

<hr>
<?=$category->description2 ?>