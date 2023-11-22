<?php

function get_sales_total_meta($db, $dbprefix, $id, $main_table, $items_table) {

    //$main_table like as invoices table
    //$items_table like as invoice_items_table
    $taxes_table = $dbprefix.'taxes';

    $invoice_sql = "SELECT $main_table.id, $main_table.discount_amount, $main_table.discount_amount_type, $main_table.discount_type,
                tax_table.percentage AS tax_percentage, tax_table2.percentage AS tax_percentage2, tax_table3.percentage AS tax_percentage3,
                tax_table.title AS tax_name, tax_table2.title AS tax_name2, tax_table3.title AS tax_name3,
                taxable_item.total_taxable, non_taxable_item.total_non_taxable
                FROM $main_table
                LEFT JOIN (SELECT $taxes_table.id, $taxes_table.percentage, $taxes_table.title FROM $taxes_table) AS tax_table ON tax_table.id = $main_table.tax_id
                LEFT JOIN (SELECT $taxes_table.id, $taxes_table.percentage, $taxes_table.title FROM $taxes_table) AS tax_table2 ON tax_table2.id = $main_table.tax_id2
                LEFT JOIN (SELECT $taxes_table.id, $taxes_table.percentage, $taxes_table.title FROM $taxes_table) AS tax_table3 ON tax_table3.id = $main_table.tax_id3
                LEFT JOIN (SELECT SUM($items_table.total) AS total_taxable, $items_table.invoice_id FROM $items_table WHERE $items_table.deleted=0 AND $items_table.taxable = 1 GROUP BY $items_table.invoice_id) AS taxable_item ON taxable_item.invoice_id = $main_table.id
                LEFT JOIN (SELECT SUM($items_table.total) AS total_non_taxable, $items_table.invoice_id  FROM $items_table WHERE $items_table.deleted=0 AND $items_table.taxable = 0 GROUP BY $items_table.invoice_id) AS non_taxable_item ON non_taxable_item.invoice_id = $main_table.id
                WHERE $main_table.deleted=0 AND $main_table.id = $id";

    $invoice_info = $db->query($invoice_sql)->getRow();

    if (!$invoice_info->id) {
        return null;
    }

    $total_taxable = $invoice_info->total_taxable ? $invoice_info->total_taxable : 0;
    $total_non_taxable = $invoice_info->total_non_taxable ? $invoice_info->total_non_taxable : 0;
    $sub_total = $total_taxable + $total_non_taxable;
    $discount_total = 0;
    $invoice_total = 0;

    if ($invoice_info->discount_amount_type == "percentage") {

        $non_taxable_discount_value = $total_non_taxable * ($invoice_info->discount_amount / 100);

        if ($invoice_info->discount_type == "before_tax") {
            $taxable_discount_value = $total_taxable * ($invoice_info->discount_amount / 100);
            $total_taxable = $total_taxable - $taxable_discount_value; //apply discount before tax
        }

        $tax1 = $total_taxable * ($invoice_info->tax_percentage / 100);
        $tax2 = $total_taxable * ($invoice_info->tax_percentage2 / 100);
        $tax3 = $total_taxable * ($invoice_info->tax_percentage3 / 100);
        $total_taxable = $total_taxable + $tax1 + $tax2 - $tax3;

        $invoice_total = $total_taxable + $total_non_taxable - $non_taxable_discount_value; //deduct only non-taxable discount since the taxable discount already deducted 

        if ($invoice_info->discount_type == "after_tax") {
            $taxable_discount_value = $total_taxable * ($invoice_info->discount_amount / 100);
            $invoice_total = $total_taxable + $total_non_taxable - $taxable_discount_value - $non_taxable_discount_value;
        }

        $discount_total = $taxable_discount_value + $non_taxable_discount_value;
    } else {
        //discount_amount_type is fixed_amount

        $discount_total = $invoice_info->discount_amount; //fixed amount 
        //fixed amount discount. fixed amount can't be applied before tax when there are both taxable and non-taxable items.
        //calculate all togather 

        if ($invoice_info->discount_type == "before_tax" && $total_taxable > 0) {
            $total_taxable = $total_taxable - $discount_total;
        } else if ($invoice_info->discount_type == "before_tax" && $total_taxable == 0) {
            $total_non_taxable = $total_non_taxable - $discount_total;
        }


        $tax1 = $total_taxable * ($invoice_info->tax_percentage / 100);
        $tax2 = $total_taxable * ($invoice_info->tax_percentage2 / 100);
        $tax3 = $total_taxable * ($invoice_info->tax_percentage3 / 100);
        $invoice_total = $total_taxable + $total_non_taxable + $tax1 + $tax2 - $tax3; //discount before tax

        if ($invoice_info->discount_type == "after_tax") {
            $invoice_total = $total_taxable + $total_non_taxable + $tax1 + $tax2 - $tax3 - $discount_total;
        }
    }

    $info = new \stdClass();
    $info->invoice_total = number_format($invoice_total, 2, ".", "") * 1;
    $info->invoice_subtotal = number_format($sub_total, 2, ".", "") * 1;
    $info->discount_total = number_format($discount_total, 2, ".", "") * 1;

    $info->tax_percentage = $invoice_info->tax_percentage;
    $info->tax_percentage2 = $invoice_info->tax_percentage2;
    $info->tax_percentage3 = $invoice_info->tax_percentage3;
    $info->tax_name = $invoice_info->tax_name;
    $info->tax_name2 = $invoice_info->tax_name2;
    $info->tax_name3 = $invoice_info->tax_name3;

    $info->tax = number_format($tax1, 2, ".", "") * 1;
    $info->tax2 = number_format($tax2, 2, ".", "") * 1;
    $info->tax3 = number_format($tax3, 2, ".", "") * 1;

    $info->discount_type = $invoice_info->discount_type;
    return $info;
}




function update_invoice_total_meta($db, $dbprefix, $invoice_id) {
            
    $invoices_table = $dbprefix . 'invoices';
    $invoice_items_table = $dbprefix . 'invoice_items';
    $info = get_sales_total_meta($db, $dbprefix, $invoice_id, $invoices_table, $invoice_items_table);
    
    $data = array(
        "invoice_total" => $info->invoice_total,
        "invoice_subtotal" => $info->invoice_subtotal,
        "discount_total" => $info->discount_total,
        "tax" => $info->tax,
        "tax2" => $info->tax2,
        "tax3" => $info->tax3
    );

    $where = array("id" => $invoice_id);
        
    $db->table($invoices_table)->update($data, $where);
    
}



try {
    $db = db_connect('default');
    $dbprefix = $db->getPrefix();

    if (!$dbprefix) {
        $dbprefix = "";
    }

    $upgrade_sql = "upgrade-3.5.sql";
    $sql = file_get_contents($upgrade_sql);

    if ($dbprefix) {
        $sql = str_replace('CREATE TABLE IF NOT EXISTS `', 'CREATE TABLE IF NOT EXISTS `' . $dbprefix, $sql);
        $sql = str_replace('INSERT INTO `', 'INSERT INTO `' . $dbprefix, $sql);
        $sql = str_replace('ALTER TABLE `', 'ALTER TABLE `' . $dbprefix, $sql);
        $sql = str_replace('DELETE FROM `', 'DELETE FROM `' . $dbprefix, $sql);
        $sql = str_replace('UPDATE `', 'UPDATE `' . $dbprefix, $sql);
        $sql = str_replace('DROP TABLE `', 'DROP TABLE `' . $dbprefix, $sql);
    }

    foreach (explode(";#", $sql) as $query) {
        $query = trim($query);
        if ($query) {
            try {
                $db->query($query);
            } catch (\Exception $ex) {
                log_message("error", $ex->getTraceAsString());
            }
        }
    }

    unlink($upgrade_sql);
    $tasks_table = $dbprefix . "tasks";
    $now = new DateTime();
    $today = $now->format("Y-m-d");
    $db->query("UPDATE $tasks_table SET next_recurring_date='$today' WHERE next_recurring_date<='$today'");

    //update inovice values.
    $invoices_table = $dbprefix . 'invoices';
    $invoice_sql = "SELECT id from $invoices_table WHERE deleted=0";
    $invoices = $db->query($invoice_sql)->getResult();

    
    foreach ($invoices as $invoice) {
        update_invoice_total_meta($db, $dbprefix, $invoice->id);
    }

    $delete_files = array(
        "app/Views/projects/tasks/get_related_data_of_project_script.php",
        "app/Views/projects/tasks/import_tasks_modal_form.php",
        "app/Views/projects/tasks/modal_form.php",
        "app/Views/projects/tasks/my_task_status_widget.php",
        "app/Views/projects/tasks/my_tasks.php",
        "app/Views/projects/tasks/my_tasks_list_widget.php",
        "app/Views/projects/tasks/notification_multiple_tasks_table.php",
        "app/Views/projects/tasks/open_tasks_widget.php",
        "app/Views/projects/tasks/quick_filters_dropdown.php",
        "app/Views/projects/tasks/quick_filters_helper_js.php",
        "app/Views/projects/tasks/recently_meaning_modal_form.php",
        "app/Views/projects/tasks/sub_tasks_helper_js.php",
        "app/Views/projects/tasks/tabs.php",
        "app/Views/projects/tasks/task_timer.php",
        "app/Views/projects/tasks/task_timesheet.php",
        "app/Views/projects/tasks/task_view_data.php",
        "app/Views/projects/tasks/tasks_overview_widget.php",
        "app/Views/projects/tasks/update_task_info_script.php",
        "app/Views/projects/tasks/update_task_read_comments_status_script.php",
        "app/Views/projects/tasks/update_task_script.php",
        "app/Views/projects/tasks/view.php",
        "app/Views/projects/tasks/batch_update/batch_update_script.php",
        "app/Views/projects/tasks/batch_update/modal_form.php",
        "app/Views/projects/tasks/kanban/all_tasks.php",
        "app/Views/projects/tasks/kanban/all_tasks_kanban_helper_js.php",
        "app/Views/projects/tasks/kanban/all_tasks_kanban_widget.php",
        "app/Views/projects/tasks/kanban/kanban_column_items.php",
        "app/Views/projects/tasks/kanban/kanban_view.php"
    );

    foreach ($delete_files as $file) {
        unlink($file);
    }



    //remove old tasks files. 
} catch (\Exception $exc) {
    log_message("error", $exc->getTraceAsString());
    echo $exc->getTraceAsString();
}
