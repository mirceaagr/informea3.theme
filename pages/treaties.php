<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201309041444
 */
wp_enqueue_script('treaties');

$treaties = i3_treaties_listing();
$count = i3_treaties_count();
$count_total = i3_treaties_count();
$topics = i3_treaties_primary_topics();
$regions = i3_treaty_regions_in_use();
?>

<h1><?php the_title(); ?></h1>

<!-- <div id="treaties-filters" class="clearfix">
	<div class="treaty-title">
		Showing <?php echo $count; ?> out of <?php echo $count_total; ?> treaties
	</div>
	<div class="treaty-topic">
		<span class="info">All Topics</span>
		<div class="dropdown inline filter">
			<button class="btn dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu pull-right" role="menu">
				<?php foreach($topics as $row): ?>
				<li><a tabindex="-1" href="#<?php echo $row; ?>"><?php echo $row; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="treaty-coverage">
		<span class="info">Coverage</span>
		<div class="dropdown inline filter">
			<button class="btn dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu pull-right" role="menu">
				<?php foreach($regions as $row): ?>
				<li><a tabindex="-1" href="#<?php echo $row->name; ?>"><?php echo $row->name; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="treaty-year">
		<span>Year</span>
	</div>
</div> --><!-- #treaties-filters -->

<!-- <ul id="treaties-list" class="unstyled">
	<?php foreach($treaties as $row): ?>
	<li>
		<a href="<?php echo i3_treaty_url($row); ?>">
			<div class="treaty-title">
				<img class="thumbnail" src="<?php echo $row->logo_medium; ?>" alt="<?php echo $row->short_title; ?> logo">
				<h2><?php echo $row->short_title; ?></h2>
			</div>
			<div class="treaty-topic">
				<?php i3_treaty_format_topic($row); ?>&nbsp;
			</div>
			<div class="treaty-coverage"><?php i3_treaty_format_region($row); ?></div>
			<div class="treaty-year"><?php echo $row->year; ?></div>
		</a>
	</li>
	<?php endforeach; ?>
</ul> --><!-- #treaties-list -->

<table class="treaties-table">
	<thead>
		<tr>
			<th>Showing <?php echo $count; ?> out of <?php echo $count_total; ?> treaties</th>
			<th>
				<span class="info">All Topics</span>
				<div class="dropdown inline filter">
					<button class="btn dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<?php foreach($topics as $row): ?>
						<li><a tabindex="-1" href="#<?php echo $row; ?>"><?php echo $row; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>