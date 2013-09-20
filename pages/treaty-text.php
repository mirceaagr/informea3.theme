<?php
global $treaty, $organization;

$display = get_request_variable('display');
$articles = InforMEA::get_treaty_articles($treaty->id);
$paragraphs = InforMEA::get_treaty_paragraphs($treaty->id);

if(!$display) {
    get_header();
}
?>
<div class="row">
    <div class="span3">
        Treaty Text
    </div>
    <div class="span9">
        <button class="btn btn-inline"><i class="icon-print"></i> Print</button>
        <button class="btn btn-inline"><i class="icon-url"></i> Cite/Link</button>
    </div>
</div>

<div class="row">
    <div class="span3">
        <ul class="nav nav-list">
            <?php foreach($articles as $row): ?>
            <li><a href="#article-<?php echo $row->id; ?>"><?php i3_print_article_title($row); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="span9">
        <div class="treaty-text">
            <?php foreach($articles as $row): ?>
                <h1 id="article-<?php echo $row->id; ?>"><?php i3_print_article_title($row); ?></h1>
                <?php
                    if(!array_key_exists($row->id, $paragraphs)) {
                       if(!empty($row->content)) {
                           echo '<p>';
                           echo $row->content;
                           echo '</p>';
                       }
                    } else {
                        $ap = $paragraphs[$row->id];
                        foreach($ap as $p) {
                            echo sprintf('<p id="paragraph-%s" class="treaty-indent-%s">', $p->id, $p->indent);
                            echo $p->content;
                            echo '</p>';
                        }
                    }
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php
if(!$display) {
    get_footer();
}
