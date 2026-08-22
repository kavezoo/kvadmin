<?php
	$this->Paginator->setTemplates([
		'sort' => '<a href="{{url}}">{{text}}</a>',
		'sortAsc' => '<a class="asc" href="{{url}}">{{text}} <span class="sort-arrows">' . $this->Icon->filled('triangle') . '</span></a>',
		'sortDesc' => '<a class="desc" href="{{url}}">{{text}} <span class="sort-arrows">' . $this->Icon->filled('triangle-inverted') . '</span></a>',
	]);
?>