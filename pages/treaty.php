<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201309171041
 */

global $treaty;

/** Add the scrollspy classes to the body tag */
function informea_treaties_body_attributes($c) {
    $c[] = '" data-spy="scroll" data-target=".scrollspy';
    return $c;
}
add_filter('body_class','informea_treaties_body_attributes');

$treaties = InforMEA::get_treaties_enabled('a.short_title');
$organization = InforMEA::get_organization($treaty->id_organization);
$parties = InforMEA::get_treaty_member_parties($treaty);
$parties_c = count($parties);
$cop_meetings = InforMEA::get_treaty_cop_meetings($treaty->id);
$cop_meetings_c = count($cop_meetings);
$decisions = InforMEA::get_treaty_decisions($treaty->id);
$decisions_c = count($decisions);
$cop = null;

wp_enqueue_script('informea-treaties');
get_header();

?>
<!-- TREATY HEADER -->
    <div class="treaty-header">
        <div class="treaty-name">
            <a class="logo logo-left" href="<?php echo $treaty->url; ?>" title="Visit Treaty Website">
                <img src="<?php echo $treaty->logo_medium; ?>" alt="Treaty logo">
            </a>
            <h1><?php echo $treaty->short_title; ?></h1>
        </div>
        <div class="treaty-info">
            <div class="ti-1">
            <?php i3_treaty_print_topics($treaty); ?>
            <?php if(!empty($organization->depository)) : ?>
                <br />
                <strong>Depository</strong>&ensp;<?php echo $organization->depository; ?>
            <?php endif; ?>
            </div>
            <div class="ti-2">
                <strong>Coverage</strong>&ensp;<?php i3_treaty_print_region($treaty); ?><br/>
                 <?php i3_treaty_print_year($treaty); ?>
            </div>
        </div>
        <div class="treaty-actions">
            <div class="btn-group">
                <button class="btn btn-primary">Read Treaty Text</button>
                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right">
                    <li><a href="#">Read Treaty Text from Source</a></li>
                    <li><a href="#">Go to Treaty Website</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- NAVIGATION BOX -->
        <div class="span3 hidden-phone scrollspy affix-menu affix-top" data-offset="155">
            <div class="well">
                <h4>Contents</h4>
                <ul class="nav nav-list">
                    <li class="active"><a href="#summary">Summary</a></li>
                    <?php if($decisions_c): ?>
                    <li><a href="#decisions">Decisions<span class="qty"><?php echo $decisions_c; ?></span></a></li>
                    <?php endif; ?>
                    <li><a href="#nfp">Focal Points<span class="qty">12</span></a></li>
                    <?php if($parties_c): ?>
                    <li><a href="#member_parties">Member parties<span class="qty"><?php echo $parties_c; ?></span></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- TAG CLOUD -->
            <div class="tag-cloud well">
                <h4>Most Frequent Terms</h4>
                <ol>
                    <li><a class="tag10" href="#">Tag 10</a></li>
                    <li><a class="tag9" href="#">Tag 9</a></li>
                    <li><a class="tag8" href="#">Tag 8</a></li>
                    <li><a class="tag7" href="#">Tag 7</a></li>
                    <li><a class="tag6" href="#">Tag 6</a></li>
                    <li><a class="tag5" href="#">Tag 5</a></li>
                    <li><a class="tag4" href="#">Tag 4</a></li>
                    <li><a class="tag3" href="#">Tag 3</a></li>
                    <li><a class="tag2" href="#">Tag 2</a></li>
                    <li><a class="tag1" href="#">Tag 1</a></li>
                </ol>
            </div>
            <!-- SELECT TREATY -->
            <div class="box">
                <select id="select_treaty" onchange="window.location = jQuery(this).val()"
                        class="input-block-level informea-tooltip"
                        data-placement="right" data-toggle="tooltip"
                        title="View another treaty">
                    <option>View another treaty</option>
                <?php
                    foreach($treaties as $row):
                        $active = $row->id == $treaty->id ? ' selected="selected"' : '';
                ?>
                    <option value="<?php i3_treaty_url($row); ?>"<?php echo $active; ?>><?php echo $row->short_title; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- #content -->
        <div class="span9 pull-right" id="content">
            <!-- SUMMARY -->
            <div class="section" id="summary">
                <h2 id="summary">Summary</h2>
                <p><?php echo $treaty->abstract; ?></p>
            </div>

            <!-- SUMMARY -->
            <?php if($decisions_c && $cop_meetings_c): ?>
            <div class="section" id="decisions">
                <h2 id="decisions">Decisions</h2>
                <ul class="meeting-list">
                    <?php foreach($cop_meetings as $row): ?>
                    <li>
                        <a data-toggle="collapse" data-target="#collapse-meeting"><?php echo $row->title; ?></a>
                        <div id="collapse-meeting">
                            <p class="info">Date, Location&ensp;-&ensp;Number of Decisions</p>
                            <ul class="decision-list">
                            <?php foreach($decisions as $row): ?>
                            <li class="clearfix">
                                <div class="decision-number">
                                    <span class="visible-phone">No.</span>
                                    <strong><?php echo $row->number; ?></strong>
                                </div>
                                <div class="decision-type">
                                    <span class="visible-phone">Type</span>
                                    <strong><?php echo ucfirst($row->type); ?></strong>
                                    <span class="status <?php echo strtolower($row->status); ?>"><?php echo strtoupper($row->status); ?></span>
                                </div>
                                <div class="decision-title">
                                    <a href="#"><?php echo $row->short_title; ?></a>
                                </div>
                            </li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- FOCAL POINTS -->
            <div class="section" id="focal-points">
                <h2 id="nfp">Focal Points</h2>
                <div class="row">
                    <div class="span2">
                        <div class="well select clearfix">
                            <a class="visible-desktop" href="" title="Go to Country Profile page">
                                <img src="http://placehold.it/60x60" alt="Country Flag">
                            </a>
                            <select class="input-block-level">
                                <option>Country</option>
                            </select>
                            <p>x Focal Points</p>
                            <button class="btn btn-link">Show all</button>
                        </div>
                    </div>
                    <ul class="focal-point-list span7">
                        <li class="focal-point">
                            <h3>Person Name</h3>
                            <p>Occupation</p>
                            <dl class="dl-horizontal">
                                <dt>Department</dt><dd>Department Name</dd>
                                <dt>Institution</dt><dd>Institution Name</dd>
                                <dt>Address</dt><dd>Institution Address</dd>
                            </dl>
                            <div class="focal-point-actions">
                                <a class="btn btn-link" href="">Email</a>&ensp;|&ensp;<a class="btn btn-link disabled" href="#">vCard</a>
                            </div>
                        </li>
                        <li class="focal-point">
                            <h3>Person Name</h3>
                            <p>Occupation</p>
                            <dl class="dl-horizontal">
                                <dt>Department</dt><dd>Department Name</dd>
                                <dt>Institution</dt><dd>Institution Name</dd>
                                <dt>Address</dt><dd>Institution Address</dd>
                            </dl>
                            <div class="focal-point-actions">
                                <a class="btn btn-link" href="">Email</a>&ensp;|&ensp;<a class="btn btn-link disabled" href="#">vCard</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- MEMBERS -->
            <?php if($parties_c): ?>
            <div class="section" id="members">
                <h2 id="member_parties">Member parties</h2>
                <ul class="nav nav-tabs" id="members-tabs">
                    <li class="active"><a href="#members-list" data-toggle="tab">List</a></li>
                    <li><a href="#members-map" data-toggle="tab">Map</a></li>
                </ul>
                <div class="tab-content">
                    <!-- MEMBERS-LIST -->
                    <div class="tab-pane active" id="members-list">
                        <table class="table table-striped">
                            <caption>Current membership status</caption>
                            <thead>
                                <tr>
                                    <th class="span5">Country</th>
                                    <th>Status</th>
                                    <th>Entry into force</th>
                                    <th>Signed</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($parties as $party): ?>
                                <tr>
                                    <td><?php echo $party->country; ?></td>
                                    <td><?php echo $party->status; ?></td>
                                    <td><?php echo i3_format_mysql_date($party->entryIntoForce, 'Y'); ?></td>
                                    <td><?php echo i3_format_mysql_date($party->signed, 'Y'); ?></td>
                                    <th><?php echo $party->notes ?></th>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- MEMBERS-MAP -->
                    <div class="tab-pane" id="members-map">
                        ...
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div><!-- /#content -->
    </div>
<?php
get_footer();
