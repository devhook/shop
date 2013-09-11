<div class="list-group">
<? foreach ($categories[0] as $id => $cat): ?>
	<a class="list-group-item" href="<?=$cat->link() ?>"><?=$cat->title ?></a>
<? endforeach ?>
</div>