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

<table id="treaties-table" class="table">
    <thead>
    <tr>
        <th colspan="2">Showing <?php echo $count; ?> out of <?php echo $count_total; ?> treaties</th>
        <th class="hidden-phone">
            <span class="placeholder">All Topics</span>

            <div class="dropdown inline filter">
                <button class="btn dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <?php foreach ($topics as $row): ?>
                        <li><a tabindex="-1" href="#<?php echo $row; ?>"><?php echo $row; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </th>
        <th class="hidden-phone">
            <span class="placeholder">Coverage</span>

            <div class="dropdown inline filter">
                <button class="btn dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <?php foreach ($regions as $row): ?>
                        <li><a tabindex="-1" href="#<?php echo $row->name; ?>"><?php echo $row->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </th>
        <th class="hidden-phone">
            <span>Year</span>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($treaties as $row): ?>
        <tr>
            <td><img src="<?php echo $row->logo_medium; ?>" alt="<?php echo $row->short_title; ?> logo"></td>
            <td class="treaty-title"><h2><?php echo $row->short_title; ?></h2></td>
            <td class="hidden-phone"><?php i3_treaty_format_topic($row); ?>&nbsp;</td>
            <td class="hidden-phone"><?php i3_treaty_format_region($row); ?></td>
            <td class="hidden-phone"><?php echo $row->year; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>