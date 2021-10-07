<?php
/**
 * Template for displaying search forms
 *
 */
?>
<form action="/" method="get">
<div class="input-group md-form form-sm form-2 pl-0">
      <input class="form-control my-0 py-1 red-border" type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
      	<button type="submit" class="btn btn-default submit-searching">
		<i class="fa fa-search" aria-hidden="true"></i>
		</button>
      </div>
    </div>
</form>
