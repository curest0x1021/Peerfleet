<div class="box-title"><span ><?php echo app_lang("files"); ?></span></div>
            <div class="d-flex justify-content-end"  >
                <div >
                    <a href="<?php echo get_uri('/tasks/download_task_files/'.$task_id);?>" id="btn-download-all" class="btn btn-sm" ><i color="gray" data-feather="download" class="icon-16" ></i></a>
                    <a id="btn-grid-group" class="btn btn-sm" ><i color="gray" data-feather="grid" class="icon-16" ></i></a>
                    <a id="btn-list-group" class="btn btn-sm" ><i color="gray" data-feather="list" class="icon-16" ></i></a>
                    <a id="btn-add-file" class="btn btn-sm" ><i color="gray" data-feather="plus-circle" class="icon-16" ></i></a>
                </div>
            </div>
            <?php 
            // echo view("projects/comments/comment_list"); 
            ?>
            <input type="file" hidden id="new-comment-file-selector" accept="images/*" />
            <div class="row item-group" style="width:98%;min-width:98%;max-width:98%;" >
                <?php 
                // app_hooks()->do_action('app_hook_task_view_right_panel_extension');
                $all_files=array();
                foreach($comments as $oneComment){
                    $files = unserialize($oneComment->files);
                    $all_files=array_merge($all_files,$files);
                    $total_files = count($files);
                    $timeline_file_path = isset($file_path) ? $file_path : get_setting("timeline_file_path");
                    foreach($files as $oneFile){
                        // echo $oneFile['file_name'];
                        $url = get_source_url_of_file($oneFile, $timeline_file_path);
                        $thumbnail = get_source_url_of_file($oneFile, $timeline_file_path, "thumbnail");
                        $actual_file_name = remove_file_prefix($oneFile['file_name']);

                        $lll=is_viewable_image_file($oneFile['file_name'])?$url:get_source_url_of_file(array("file_name" => "store-item-no-image.png"), get_setting("system_file_path"));
                        echo 
                        '<div class="group-item col-md-2" >
                            <img class="item-image" src="'.$url.'" />
                            <p class="item-title" >'.$actual_file_name.'</p>
                            <a target="_blank" href="'.get_uri("tasks/download_one_file/".$oneFile['file_name']).'"  class="btn-download-item btn btn-sm" ><i data-feather="download-cloud" class="icon-16" ></i></a>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>