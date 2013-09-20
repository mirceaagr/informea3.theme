<?php
global $treaty, $organization;

$articles = InforMEA::get_treaty_articles($treaty->id);
$paragraphs = InforMEA::get_treaty_paragraphs($treaty->id);
?>
<div class="row">
    <div class="span3">
        <div class="toolbar">
            <strong>Table of Contents</strong>
        </div>
        <ul class="nav nav-list">
            <?php foreach($articles as $row): ?>
            <li><a href="#article-<?php echo $row->id; ?>"><?php i3_print_article_title($row); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="treaty-text-container span9">
        <div class="toolbar">
            <strong>Treaty Text</strong>
            <div class="pull-right">
                <a href="#"><i class="icon-print"></i> Print</a> <a href="#"><i class="icon-url"></i> Cite/Link</a>
            </div>
        </div>
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