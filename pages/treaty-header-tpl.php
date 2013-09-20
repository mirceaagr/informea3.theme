<?php global $treaty, $organization, $treaty_header_mode; ?>
<div class="treaty-header">
    <div class="treaty-name">
        <a class="logo logo-left" href="<?php echo $treaty->url; ?>" title="Visit Treaty Website">
            <img src="<?php echo $treaty->logo_medium; ?>" alt="Treaty logo">
        </a>
        <h1><?php echo $treaty->short_title; ?></h1>
    </div>
    <div class="treaty-info 
    <?php if ($treaty_header_mode == 'modal') { echo 'hidden-phone'; } ?>">
        <div class="ti-1">
            <?php i3_treaty_print_topics($treaty); ?>
            <?php if(!empty($organization->depository)) : ?>
                <br />
                <strong>Depository:</strong>&ensp;<?php echo $organization->depository; ?>
            <?php endif; ?>
        </div>
        <div class="ti-2">
            <strong>Coverage:</strong>&ensp;<?php i3_treaty_print_region($treaty); ?><br/>
            <?php i3_treaty_print_year($treaty); ?>
        </div>
    </div>
    <div class="treaty-actions">
        <?php if ($treaty_header_mode == 'modal'): ?>
            <a href="#">Read Treaty Text from Source</a><br>
            <a href="#">Go to Treaty Website</a>
        <?php else: ?>
        <div class="btn-group">
            <button class="btn btn-primary" data-remote="<?php i3_treaty_url($treaty, '/text?display=modal') ;?>" data-target="#treaty-text-modal" data-toggle="modal">Read Treaty Text</button>
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="#">Read Treaty Text from Source</a></li>
                <li><a href="#">Go to Treaty Website</a></li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
