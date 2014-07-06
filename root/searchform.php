<?php $sq = get_search_query() ? get_search_query() : 'Поиск'; ?>
<form method="get" class="search" id="searchform" action="<?php bloginfo('url'); ?>" >
	<fieldset>
		<input type="text" name="s" value="<?php echo $sq; ?>" class="text" />
        <input type="submit" value="Искать"/>
	</fieldset>
</form>