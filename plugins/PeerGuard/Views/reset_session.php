<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo view('includes/head'); ?>
    </head>
    <body>
        <?php
        if (get_setting("show_background_image_in_signin_page") === "yes") {
            $background_url = get_file_from_setting("signin_page_background");
            ?>
            <style type="text/css">
                html, body {
                    background-image: url('<?php echo $background_url; ?>');
                    background-size:cover;
                }
            </style>
        <?php } ?>

        <div class="scrollable-page">
            <div class="form-signin">
                <?php echo view('PeerGuard\Views\reset_session_form'); ?>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                initScrollbar('.scrollable-page', {
                    setHeight: $(window).height() - 50
                });
            });
        </script>

        <?php echo view("includes/footer"); ?>
    </body>
</html>