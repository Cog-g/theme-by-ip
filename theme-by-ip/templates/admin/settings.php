<div class="wrap">
    <?php
    if( isset( $_POST['cg_list_IP_to_serve'] ) ) {

        $cg_list_IP_to_serve = explode( "\n", stripslashes( $_POST['cg_list_IP_to_serve'] ) );
        sort($cg_list_IP_to_serve);
        $_POST['cg_list_IP_to_serve'] = implode("\n", $cg_list_IP_to_serve);

        update_option( 'cg_list_IP_to_serve',   $_POST['cg_list_IP_to_serve'] );
        update_option( 'cg_theme_to_serve',     $_POST['cg_theme_to_serve'] );
    }
    ?>

    <div id="cg_settings">
        <form id='cg_settings_settingform' method="post" action="">
            <div stlye="float:left;">
                <h3>IPs list</h3>
                <p>Only one IP by line, thanks!</p>
                <textarea name="cg_list_IP_to_serve" id="cg_list_IP_to_serve" cols="20" rows="5" style="width: 30%; padding: 1em; line-height: 2;"><?php echo ( stripslashes( get_option('cg_list_IP_to_serve') ) ); ?></textarea>
                <small style="display:block;">(your current IP is: <?php echo( $_SERVER["REMOTE_ADDR"] ); ?>)</small>
            </div>
            
            <div>
                <h3>Theme to serve</h3>
                <small style="display:block;">if blank, the current theme will be serve to <b>everyone</b></small>
                <input type="text" name="cg_theme_to_serve"  value="<?php echo ( get_option('cg_theme_to_serve') ); ?>">
            </div>
            
            <br/><br/>
            <p class="submit">
                <input type="submit" name="cg_submit" class="button-primary" value="<?php echo 'Save'; ?>" />
            </p>

            <h3>Todo:</h3>
            <ul>
                <li>Allow more theme depending on more IPs.</li>
            </ul>
        </form>
    </div>
</div>