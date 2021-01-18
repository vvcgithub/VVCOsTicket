<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['luser']?:$_GET['e']);
$passwd=Format::input($_POST['lpasswd']?:$_GET['t']);

$content = Page::lookupByType('banner-client');

if ($content) {
    list($title, $body) = $ost->replaceTemplateVariables(
        array($content->getLocalName(), $content->getLocalBody()));
} else {
    $title = __('Sign In');
    $body = __('To better serve you, we encourage our clients to register for an account and verify the email address we have on record.');
}

?>
<div class="container-fluid">
    <form action="login.php" method="post">
        <?php csrf_token(); ?>
        <div class="col-md-6">
            <div class="row">
                <div class="page-title-open">
                    <h1><?php echo Format::display($title); ?></h1>
                    <h4><?php echo Format::display($body); ?></h4>
                </div>
            </div>
            <div class="card-body">
                <strong><?php echo Format::htmlchars($errors['login']); ?></strong>
                <div class="form-group">
                    <input id="username" class="form-control" placeholder="<?php echo __('Email or Username'); ?>" type="text" name="luser" size="30" value="<?php echo $email; ?>" class="nowarn">
                </div>
                <div class="form-group">
                    <input id="passwd" class="form-control" placeholder="<?php echo __('Password'); ?>" type="password" name="lpasswd" size="30" value="<?php echo $passwd; ?>" class="nowarn"></td>
                </div>

                <div class="row">
                    <div class="col-md-2">    
                        <input class="btn btn-primary" type="submit" value="<?php echo __('Sign In'); ?>">
                    </div>  
                    <div class="col-md-8">    
                        <div style="display:table-cell;padding: 10px;vertical-align:top;">
                        <?php
                        $ext_bks = array();
                        foreach (UserAuthenticationBackend::allRegistered() as $bk)
                            if ($bk instanceof ExternalAuthentication)
                                $ext_bks[] = $bk;

                        if (count($ext_bks)) {
                            foreach ($ext_bks as $bk) { ?>
                        <div class="external-auth"><?php $bk->renderExternalLink(); ?></div><?php
                            }
                        }
                        if ($cfg && $cfg->isClientRegistrationEnabled()) {
                            if (count($ext_bks)) echo '<hr style="width:70%"/>'; ?>
                            <div style="margin-bottom: 10px">
                            <?php echo __('Not yet registered? Click here to'); ?> <a href="account.php?do=create"><?php echo __('Create an account.'); ?></a>
                            </div>
                        <?php } ?>
                
                        <div>   
                        <!-- <b><?php echo __("I'm an agent"); ?></b> —
                        <a href="<?php echo ROOT_PATH; ?>scp/"><?php echo __('sign in here'); ?></a> -->
                        </div>

                        <?php
                        // if ($cfg->getClientRegistrationMode() != 'disabled'
                        //     || !$cfg->isClientLoginRequired()) {
                        //     echo sprintf(__('If this is your first time contacting us or you\'ve lost the ticket number, please %s open a new ticket %s'),
                        //         '<a href="open.php">', '</a>');
                        // } ?>        
                    </div>
               </div>  
            </div>
            
            <?php if ($suggest_pwreset) { ?>
                <a style="padding-left:15px;padding-top:10px;display:inline-block;" href="pwreset.php"><?php echo __('Forgot My Password'); ?></a>
            <?php } ?>
            </div>
                
        </form>
</div>
</div>



