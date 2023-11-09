<?php
$task_id = "";

foreach ($comments as $comment) {

    $type = "project";
    $type_id = $comment->project_id;
    $pin_status = "";
    $unpin_status = "";
    if ($comment->file_id) {
        $type = "file";
        $type_id = $comment->file_id;
    } else if ($comment->task_id) {
        $type = "task";
        $type_id = $comment->task_id;
        $task_id = $comment->task_id;
    } else if ($comment->customer_feedback_id) {
        $type = "customer_feedback";
        $type_id = $comment->customer_feedback_id;
    }

    ?>
    <div id="comment-<?php echo $comment->id; ?>" class="comment-highlight-section" >
        <div id="prject-comment-container-<?php echo $type . "-" . $comment->id; ?>"  class="comment-container text-break b-b <?php echo "comment-" . $type; ?>">
            <div class="d-flex">
                <div class="flex-shrink-0 comment-avatar">
                    <span class="avatar <?php echo ($type === "project") ? " avatar-sm" : " avatar-xs"; ?> ">
                        <img src="<?php echo get_avatar($comment->created_by_avatar); ?>" alt="..." />
                    </span>
                </div>
                <div class="w-100 ps-2">
                    <div class="mb5">
                        <span class="dark strong"><?php echo $comment->created_by_user; ?></span>
                        <small><span class="text-off"><?php echo format_to_relative_time($comment->created_at); ?></span></small>

                    </div>
                    <p><?php echo convert_mentions(convert_comment_link(process_images_from_content($comment->description))); ?></p>

                    <div class="comment-image-box clearfix">

                        <?php
                        $files = unserialize($comment->files);
                        $total_files = count($files);
                        echo view("includes/timeline_preview", array("files" => $files));
                        ?>

                        <div class="mb15 clearfix">

                            <?php
                            $reply_caption = "";
                            if ($comment->total_replies == 1) {
                                $reply_caption = app_lang("reply");
                            } else if (($comment->total_replies > 1)) {
                                $reply_caption = app_lang("replies");
                            }

                            if ($reply_caption) {
                                echo "<i data-feather='message-circle' class='icon-16'></i> " . app_lang("view") . " " . $comment->total_replies . " " . $reply_caption;
                            }

                            ?>
                        </div>
                    </div>
                    <div id="reply-list-<?php echo $comment->id; ?>"></div>
                    <div id="reply-form-container-<?php echo $comment->id; ?>"></div>

                </div>
            </div>
        </div>
    </div>
<?php } ?>



<script>
    $(document).ready(function () {

    });

</script>