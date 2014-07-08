<? defined('KOOWA') or die; ?>

<?= @helper('behavior.mootools'); ?>

<!--
<script src="media://lib_koowa/js/koowa.js" />
-->

<form action="<?= @route() ?>" method="get" class="-koowa-grid" data-toolbar=".toolbar-list">
	<div class="btn-toolbar" id="filter-bar">
		<div class="filter-search btn-group pull-left">
			<input type="text" value="<?= $state->search; ?>" placeholder="Search" id="filter_search" name="search">
		</div>
		<div class="btn-group pull-left hidden-phone">
			<button title="" class="btn hasTooltip" type="submit" data-original-title="Search"><i class="icon-search"></i></button>
			<button onclick="document.id('filter_search').value='';this.form.submit();" title="" class="btn hasTooltip" type="button" data-original-title="Clear"><i class="icon-remove"></i></button>
		</div>
	</div>
	<table class="table table-striped">
		<thead>
		<tr>
			<th style="text-align: center;" width="1">
				<?= @helper('grid.checkall')?>
			</th>
			<th>
				<?= @helper('grid.sort', array('column' => 'title', 'title' => 'Title', 'direction' => 'asc')) ?>
			</th>
			<th>
				<?= @helper('grid.sort', array('column' => 'enabled', 'title' => @text('PUBLISHED'))); ?>
			</th>
            <th>
                <?= @helper('grid.sort', array('column' => 'Featured', 'title' => @text('FEATURED'))); ?>
            </th>
			<? if($categories->isTranslatable()) : ?>
				<th>
					<?= @text('TRANSLATIONS') ?>
				</th>
			<? endif; ?>
			<th>
				<?= @text('Owner'); ?>
			</th>
			<th>
				<?= @helper('grid.sort', array('column' => 'created_on', 'title' => @text('DATE'))); ?>
			</th>
			<th>
				<?= @helper('grid.sort', array('column' => 'custom', 'title' => 'Ordering', 'direction' => 'asc')) ?>
			</th>
			<th>
				<?= @helper('grid.sort', array('column' => 'id', 'title' => @text('ID'))); ?>
			</th>
		</tr>
		</thead>
		<tbody>
		<? foreach($categories as $category) : ?>
			<tr>
				<td style="text-align: center;">
					<?= @helper('grid.checkbox', array('row'=> $category)); ?>
				</td>
				<td>
                    <span style="padding-left: <?= ($category->level) * 15 ?>px" class="editlinktip hasTip"
						  title="<?= @text('Edit')?> <?= @escape($category->title); ?>">
                        <a href="<?= @route('view=category&id='.$category->id)?>">
							<?= @escape($category->title) ?>
						</a>
                    </span>
				</td>
				<td>
					<?= @helper('grid.enable', array('row' => $category)); ?>
				</td>
                <td>
                    <?= @helper('grid.enable', array('row' => $category, 'field' => 'featured')); ?>
                </td>
				<? if($category->isTranslatable()) : ?>
					<td>
						<?= @helper('com://admin/translations.template.helper.language.translations', array(
							'row' => $category->id,
							'table' => $category->getTable()->getName()
						)); ?>
					</td>
				<? endif; ?>
				<td>
					<?= $category->created_by_name; ?>
				</td>
				<td>
					<?= @helper('date.humanize', array('date' => $category->created_on)) ?>
				</td>
				<td>
					<?= @helper('grid.order', array('row' => $category, 'total' => $total)) ?>
				</td>
				<td>
					<?= $category->id; ?>
				</td>
			</tr>
		<? endforeach ?>
		<? if(!count($categories)) : ?>
			<tr>
				<td colspan="20" style="text-align: center;">
					<?= @text('NO_ITEMS') ?>
				</td>
			</tr>
		<? endif ?>
		</tbody>

		<? if (count($categories)): ?>
			<tfoot>
			<tr>
				<td colspan="20">
					<?= @helper('paginator.pagination', array('total' => $total)) ?>
				</td>
			</tr>
			</tfoot>
		<? endif; ?>
	</table>
</form>