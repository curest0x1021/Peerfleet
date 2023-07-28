<div id="page-content" class="page-wrapper clearfix todo-page">

    <?php echo form_open(get_uri("todo/save"), array("id" => "todo-inline-form", "class" => "", "role" => "form")); ?>
    <div class="todo-input-box">

        <div class="input-group">
            <?php
            echo form_input(array(
                "id" => "todo-title",
                "name" => "title",
                "value" => "",
                "class" => "form-control",
                "placeholder" => app_lang('add_a_todo'),
                "autocomplete" => "off",
                "autofocus" => true
            ));
            ?>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
            </span>
        </div>

    </div>
    <?php echo form_close(); ?>


    <div class="card">
        <ul class="nav nav-tabs bg-white title" role="tablist">
            <li class="title-tab"><h4 class="pl15 pt10 pr15"><?php echo app_lang('todo') . " (" . app_lang('private') . ")"; ?></h4></li>
            <?php echo view("todo/tabs", array("active_tab" => "todo_kanban")); ?>

            <div class="tab-title clearfix no-border">
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri("labels/modal_form"), "<i data-feather='tag' class='icon-16'></i> " . app_lang('manage_labels'), array("class" => "btn btn-default", "title" => app_lang('manage_labels'), "data-post-type" => "to_do")); ?>
                    <?php echo modal_anchor(get_uri("todo/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
                </div>
            </div>
        </ul>
        <div class="bg-white kanban-filters-container">
            <div class="row">
                <div class="col-md-1 col-xs-2">
                    <button class="btn btn-default" id="reload-kanban-button"><i data-feather="refresh-cw" class="icon-16"></i></button>
                </div>
                <div id="kanban-filters" class="col-md-11 col-xs-10"></div>
            </div>
        </div>

        <div id="load-kanban"></div>
    </div>
</div>

<?php echo view("todo/kanban/kanban_helper_js"); ?>

<script type="text/javascript">
    $(document).ready(function () {
        window.scrollToKanbanContent = true;
    });
</script>