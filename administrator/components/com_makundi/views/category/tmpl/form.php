<? defined('KOOWA') or die; ?>

<?= @helper('behavior.mootools'); ?>

<?= @helper('behavior.keepalive'); ?>
<?= @helper('behavior.validator'); ?>

<!--
<script src="media://lib_koowa/js/koowa.js" />
-->

<form action="" method="post" class="-koowa-form" data-toolbar=".toolbar-list">
    <div class="row-fluid">
        <div class="span8">
            <fieldset class="form-horizontal">
                <legend><?= @text('Details'); ?></legend>
                <div class="control-group">
                    <label class="control-label" for="name"><?= @text('Title'); ?></label>
                    <div class="controls">
                        <input class="required" type="text" name="title" size="32" maxlength="255" value="<?= $category->title; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="name"><?= @text('Slug'); ?></label>
                    <div class="controls">
                        <input type="text" name="slug" size="32" maxlength="255" value="<?= $category->slug; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="name"><?= @text('Parent Category'); ?></label>
                    <div class="controls">
                        <?= @helper('listbox.categories', array(
                            'deselect' => true,
                            'check_access' => true,
                            'name' => 'parent_id',
                            'attribs' => array('id' => 'parent_id'),
                            'selected' => $parent ? $parent->id : null,
                            'ignore' => $category->id ? array_merge($category->getDescendants()->getColumn('id'), array($category->id)) : array()
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?= @text('Order by'); ?>:</label>
                    <div class="controls">
                        <div class="input-append">
                            <?= @helper('select.order', array('name' => 'order_by', 'selected' => $category->order_by)); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?= @text('Direction'); ?>:</label>
                    <div class="controls">
                        <div class="input-append">
                            <?= @helper('select.direction', array('name' => 'direction', 'selected' => $category->direction)); ?>
                        </div>
                    </div>
                </div>
				<div class="control-group">
					<label class="control-label"><?= @text('FIELDSET'); ?></label>
					<?= @template('com://admin/cck.view.connection.listbox'); ?>
				</div>
			</fieldset>

			<fieldset>
				<legend><?= @text('FIELDS'); ?></legend>
				<div id="fieldset"></div>
			</fieldset>
        </div>
		<div class="span4">
			<fieldset>
				<legend><?= @text('DETAILS'); ?></legend>
				<div class="control-group">
					<label class="control-label"><?= @text('PUBLISH'); ?></label>
					<div class="controls">
						<?= @helper('select.booleanlist', array('name' => 'enabled', 'selected' => $category->enabled)); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?= @text('TRANSLATED'); ?></label>
					<div class="controls">
						<?= @helper('select.booleanlist', array('name' => 'translated', 'selected' => $category->translated)); ?>
					</div>
				</div>
			</fieldset>
		</div>
    </div>
</form>