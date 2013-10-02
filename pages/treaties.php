<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201309041444
 */

$treaties = InforMEA::get_treaties_enabled();
$count = InforMEA::get_treaties_enabled_count();
$count_total = InforMEA::get_treaties_enabled_count();
$topics = InforMEA::get_treaties_enabled_primary_topics();
$regions = InforMEA::get_treaties_enabled_regions_in_use();

wp_enqueue_script('informea-treaties');

get_header();
?>
<h1><?php the_title(); ?></h1>
<table id="treaties-table" class="table">
    <thead>
    <tr>
        <th colspan="2">Showing <?php echo $count; ?> out of <?php echo $count_total; ?> treaties</th>
        <th class="hidden-phone">
            <div class="dropdown-container">
                <div class="dropdown">
                    <span class="dropdown-value placeholder">All Topics</span>
                    <button class="btn btn-select" data-toggle="dropdown">
                        <i class="icon-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <?php foreach ($topics as $row): ?>
                            <li><a tabindex="-1" href="#<?php echo $row; ?>"><?php echo $row; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </th>
        <th class="hidden-phone">
            <div class="dropdown-container">
                <div class="dropdown">
                    <span class="dropdown-value placeholder">Coverage</span>
                    <button class="btn btn-select" data-toggle="dropdown">
                        <i class="icon-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <?php foreach ($regions as $row): ?>
                            <li><a tabindex="-1" href="#<?php echo $row->name; ?>"><?php echo $row->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </th>
        <th class="hidden-phone">
            <span>Year</span>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($treaties as $row): ?>
        <tr onclick="window.location='<?php i3_treaty_url($row); ?>'">
            <td><img src="<?php echo $row->logo_medium; ?>" alt="<?php echo $row->short_title; ?> logo"></td>
            <td class="treaty-title">
                <h2>
                    <a href="<?php i3_treaty_url($row); ?>"><?php echo $row->short_title; ?></a>
                </h2>
            </td>
            <td class="hidden-phone"><?php i3_treaty_print_topic($row); ?>&nbsp;</td>
            <td class="hidden-phone"><?php i3_treaty_print_region($row); ?></td>
            <td class="hidden-phone"><?php echo $row->year; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
get_footer();
