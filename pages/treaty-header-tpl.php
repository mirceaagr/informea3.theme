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
            <?php if(!empty($treaty->url_treaty_text)): ?>
            <a href="<?php echo $treaty->url_treaty_text; ?>" target="_blank"><i class="icon-external-link"></i> Read on convention website</a>
            <?php endif; ?>
            <?php if(!empty($treaty->url)): ?>
            <a href="<?php echo $treaty->url; ?>" target="_blank"><i class="icon-external-link"></i> Visit convention website</a>
            <?php endif; ?>
        <?php else: ?>
        <div class="btn-group">
            <button class="btn btn-primary" data-remote="<?php i3_treaty_url($treaty, '/text?display=modal') ;?>" data-target="#treaty-text-modal" data-toggle="modal"><i class="icon-file-text"></i> Treaty Text</button>
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <?php if(!empty($treaty->url_treaty_text)): ?>
                <li><a href="<?php echo $treaty->url_treaty_text; ?>" target="_blank"><i class="icon-external-link"></i> Read on convention website</a></li>
                <?php endif; ?>
                <?php if(!empty($treaty->url)): ?>
                <li><a href="<?php echo $treaty->url; ?>" target="_blank"><i class="icon-external-link"></i> Visit convention website</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>