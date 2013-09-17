<?php
/**
 * Author: Cristian Romanescu <cristi _at_ eaudeweb dot ro>
 * Created: 201309171041
 */

global $treaty;
$organization = InforMEA::get_organization($treaty->id_organization);
$parties = InforMEA::get_treaty_member_parties($treaty);
$parties_c = count($parties);
$cop_meetings = InforMEA::get_treaty_cop_meetings($treaty->id);
$cop_meetings_c = count($cop_meetings);
$decisions_c = InforMEA::get_treaty_decisions_count($treaty->id);
$decisions = array();
$cop = null;
if($decisions_c && $cop_meetings_c) {
    $cop = $cop_meetings[0];
    $decisions = InforMEA::get_meeting_decisions($cop->id);
}
//var_dump($treaty);
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
    <div class="row">
        <!-- NAVIGATION BOX -->
        <div class="span3 scrollspy">
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
                <select class="input-block-level">
                    <option>...</option>
                </select>
            </div>
        </div>

        <!-- #content -->
        <div class="span9" id="content">
            <!-- SUMMARY -->
            <section id="summary">
                <h2 id="summary">Summary</h2>
                <p><?php echo $treaty->abstract; ?></p>
            </section>

            <!-- SUMMARY -->
            <?php if($decisions_c && $cop_meetings_c): ?>
            <section id="decisions">
                <h2 id="decisions">Decisions</h2>
                <ul class="meeting-bar clearfix">
                    <li class="prev">
                        <a class="disabled" href="#">← Earlier Meeting</a>
                    </li>
                    <li class="meeting">
                        <a href="#"><?php echo $cop->abbreviation; ?></a> - Date, Location - 32 Decisions
                        <div class="dropdown filter pull-right">
                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li class="info">Select a COP/MOP meeting</li>
                            <?php foreach($cop_meetings as $row): ?>
                                <li><a tabindex="-1" href="#"><?php echo $row->abbreviation; ?></a></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                    <li class="next">
                        <a href="#">Older Meeting →</a>
                    </li>
                </ul>
                <ul class="decisions-list clear">
                    <?php foreach($decisions as $row): ?>
                    <li>
                        <div class="decision-number pull-left">
                            <span class="aux">No.</span><br>
                            <strong><?php echo $row->number; ?></strong>
                        </div>
                        <div class="decision-info">
                            <span><?php echo ucfirst($row->type); ?></span>
                            <span class="status <?php echo strtolower($row->status); ?>"><?php echo $row->status; ?></span>
                            <!-- Decision status can receive 3 classes: Active, Revised, Retired -->
                            <br>
                            <a href="#"><?php echo $row->short_title; ?></a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <?php endif; ?>

            <!-- FOCAL POINTS -->
            <section id="focal-points">
                <h2 id="nfp">Focal Points</h2>
                <div class="row">
                    <div class="select span2">
                        <div class="box country">
                            <a class="" href="" title="Go to Country Profile page">
                                <img src="http://placehold.it/60x60" alt="Country Flag">
                                <h3>Country name</h3>
                            </a>
                            <p>Number of Focal Points</p>
                        </div>
                        <select class="input-block-level">
                            <option>Select a Country</option>
                        </select>
                    </div>
                    <ul class="unstyled span7">
                        <li class="focal-point">
                            <div class="thumbnail thumb-60">
                                <img src="http://placehold.it/60x60" alt="Profile Picture">
                                <div class="btn-group">
                                    <button class="btn btn-mini">Email</button>
                                    <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">vCard</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="focal-point-info">
                                <h3>Person Name</h3>
                                <p>Occupation</p>
                                <span class="marker">Department</span>Department Name<br>
                                <span class="marker">Institution</span>Institution Name<br>
                                <span class="marker">Address</span>Institution Address
                            </div>
                        </li>
                        <li class="focal-point">
                            <div class="thumbnail thumb-60">
                                <img src="http://placehold.it/60x60" alt="Profile Picture">
                                <div class="btn-group">
                                    <button class="btn btn-mini">Email</button>
                                    <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">vCard</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="focal-point-info">
                                <h3>Person Name</h3>
                                <p>Occupation</p>
                                <span class="marker">Department</span>Department Name<br>
                                <span class="marker">Institution</span>Institution Name<br>
                                <span class="marker">Address</span>Institution Address
                            </div>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- MEMBERS -->
            <?php if($parties_c): ?>
            <section id="members">
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
            </section>
            <?php endif; ?>
        </div><!-- /#content -->
    </div>