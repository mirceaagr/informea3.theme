<?php global $treaty, $organization, $treaty_header_mode; ?>
<div class="treaty-header clearfix">
    <div class="logo-left well">
        <a class="logo" href="<?php echo $treaty->url; ?>" title="Visit Treaty Website">
            <img src="<?php echo $treaty->logo_medium; ?>" alt="Treaty logo">
        </a>
    </div>

    <h1><?php echo $treaty->short_title; ?></h1>
    <div class="treaty-body clearfix">
        <div class="pull-left">
            <?php i3_treaty_print_topics($treaty); ?>
            <?php if(!empty($organization->depository)) : ?>
                <br />
                <strong>Depository:</strong>&ensp;<?php echo $organization->depository; ?>
            <?php endif; ?>
        </div>
        <div class="pull-left">
            <strong>Coverage:</strong>&ensp;<?php i3_treaty_print_region($treaty); ?><br/>
            <strong>Entry into force:</strong>&ensp;<?php i3_treaty_print_year($treaty); ?>
        </div>
    </div>

    <div class="treaty-actions">
        <?php if ($treaty_header_mode == 'modal'): ?>
            <a href="#"><i class="icon-external-link"></i> Read from Source</a>
            <a href="#"><i class="icon-external-link"></i> Go to Treaty Website</a>
        <?php else: ?>
        <div class="btn-group">
            <button class="btn btn-primary" data-remote="<?php i3_treaty_url($treaty, '/text?display=modal') ;?>" data-target="#treaty-text-modal" data-toggle="modal"><i class="icon-file-text"></i> Treaty Text</button>
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="#"><i class="icon-external-link"></i> Read from Source</a></li>
                <li><a href="#"><i class="icon-external-link"></i> Go to Treaty Website</a></li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>