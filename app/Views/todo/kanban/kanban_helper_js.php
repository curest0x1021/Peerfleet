<script type="text/javascript">
    $(document).ready(function () {
        $("#todo-inline-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                $("#todo-title").val("");
                appAlert.success(result.message, {duration: 5000});
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        });

        var scrollLeft = 0;
        $("#kanban-filters").appFilters({
            source: '<?php echo_uri("todo/kanban_data") ?>',
            targetSelector: '#load-kanban',
            reloadSelector: '#reload-kanban-button',
            search: {name: "search"},
            beforeRelaodCallback: function () {
                scrollLeft = $("#kanban-wrapper").scrollLeft();
            },
            afterRelaodCallback: function () {
                setTimeout(function () {
                    $("#kanban-wrapper").animate({scrollLeft: scrollLeft}, 'slow');
                }, 500);
            }
        })
    });
</script>