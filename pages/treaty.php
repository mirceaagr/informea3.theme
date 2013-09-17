<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201309171041
 */

global $treaty;
$organization = InforMEA::get_organization($treaty->id_organization);
var_dump($treaty);
var_dump($organization);
?>
<!-- TREATY HEADER -->
    <div class="treaty-header row">
        <div class="span1">
            <a href="<?php echo $treaty->url; ?>" title="Visit Treaty Website">
                <img src="<?php echo $treaty->logo_medium; ?>" alt="Treaty logo">
            </a>
        </div>
        <div class="span11">
            <h1><?php echo $treaty->short_title; ?></h1>
            <div class="row">
                <div class="treaty-info1 span5">
                <?php i3_treaty_print_topics($treaty); ?>
                <?php if(!empty($organization->depository)) : ?>
                    <br />
                    <span class="marker">Depository</span> <?php echo $organization->depository; ?>
                <?php endif; ?>
                </div>
                <div class="treaty-info2 span3">
                    <span class="marker">Coverage</span> <?php i3_treaty_print_region($treaty); ?><br/>
                    <?php i3_treaty_print_year($treaty); ?>
                </div>
                <div class="treaty-actions span3">
                    <div class="btn-group pull-right">
                        <button class="btn btn-primary">Read Treaty Text</button>
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Read Treaty Text from Source</a></li>
                            <li><a href="#">Go to Treaty Website</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>