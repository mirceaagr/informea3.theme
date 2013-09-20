<?php
global $treaty, $organization;

$display = get_request_variable('display');
$articles = InforMEA::get_treaty_articles($treaty->id);
$paragraphs = InforMEA::get_treaty_paragraphs($treaty->id);

if(!$display) {
    get_header();
    get_template_part('pages/treaty-header-tpl');
}
?>
<div class="row">
    <div class="span3">
        <ul class="nav nav-list hidden-phone">
            <?php foreach($articles as $row): ?>
            <li><a href="#article-<?php echo $row->id; ?>"><?php i3_print_article_title($row); ?></a></li>
            <?php endforeach; ?>
        </ul>
        <select class="visible-phone input-block-level">
            <option>Jump to Article</option>
            <?php foreach($articles as $row): ?>
            <option value="#article-<?php echo $row->id; ?>"><?php i3_print_article_title($row); ?></option>
            <?php endforeach; ?>
        </select>
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
                ?>
                            <div class="paragraph" style="position: relative;">
                                <p id="paragraph-<?php echo $p->id; ?>">
                                    <?php echo $p->content; ?>
                                </p>
                                <div class="paragraph-tags hide" style="position: absolute; bottom: -15px; background-color: white;">
                                    <a href="#">Biological diversity</a>, <a href="#">Biological diversity</a> , <a href="#">Biological diversity</a> , <a href="#">Biological diversity</a>
                                </div>
                            </div>
                <?php
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
