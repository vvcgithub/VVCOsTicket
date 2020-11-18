<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>
<div id="landing_page">
<?php
if ($cfg && $cfg->isKnowledgebaseEnabled()) { ?>
<div class="search-form">
    <form method="get" action="kb/faq.php">
    <input type="hidden" name="a" value="search"/>
    <input type="text" name="q" class="search" placeholder="<?php echo __('Search our knowledge base'); ?>"/>
    <button type="submit" class="green button"><?php echo __('Search'); ?></button>
    </form>
<?php } ?>
<div class="thread-body">
<?php
    if($cfg && ($page = $cfg->getLandingPage()))
        echo $page->getBodyWithImages();
    else
        echo  '<h1>'.__('Welcome to the Support Center').'</h1>';
    ?>
    </div>
</div>

<br/>
<br/>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                  <?php echo __('Open a New Ticket'); ?>
                </h3>
            </div>
            <div class="panel-body">
                <p>
                    <?php echo __('Please provide as much detail as possible so we can best assist you.'); ?>
                    <p>
                        <p style="text-align:center;">
                            <a href="
                                <?php echo ROOT_PATH; ?>open.php" class="btn btn-success btn-lg" title="
                                <?php echo __('Open a New Ticket'); ?>.">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                <?php echo __('Open a New Ticket'); ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo __('Check Ticket Status'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <?php echo __('We provide archives and history of all your current and past support requests complete with responses.'); ?>
                        </p>
                        <p style="text-align:center;">
                            <a href="
                                <?php if(is_object($thisclient)) { echo ROOT_PATH . 'tickets.php';} else { echo ROOT_PATH . 'view.php'; } ?>" class="btn btn-info btn-lg" title="
                                <?php echo __('Check Ticket Status'); ?>.">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                <?php echo __('Check Ticket Status'); ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

<div class="clear"></div>

<div>
<?php
if($cfg && $cfg->isKnowledgebaseEnabled()){
    //FIXME: provide ability to feature or select random FAQs ??
?>
<br/><br/>
<?php
$cats = Category::getFeatured();
if ($cats->all()) { ?>
<h1><?php echo __('Featured Knowledge Base Articles'); ?></h1>
<?php
}

    foreach ($cats as $C) { ?>
    <div class="featured-category front-page">
        <i class="icon-folder-open icon-2x"></i>
        <div class="category-name">
            <?php echo $C->getName(); ?>
        </div>
<?php foreach ($C->getTopArticles() as $F) { ?>
        <div class="article-headline">
            <div class="article-title"><a href="<?php echo ROOT_PATH;
                ?>kb/faq.php?id=<?php echo $F->getId(); ?>"><?php
                echo $F->getQuestion(); ?></a></div>
            <div class="article-teaser"><?php echo $F->getTeaser(); ?></div>
        </div>
<?php } ?>
    </div>
<?php
    }
}
?>
</div>
</div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
