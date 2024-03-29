<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTicketActionsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            "ticket_id"=>[
                'type'=>"INT",
                'null'=>true,
                "constraint"=>5
            ],
            "corrective_action"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                "constraint"=>500
            ],
            "task_title"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                "constraint"=>500
            ],
            "task_description"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "task_assigned_to"=>[
                'type'=>"INT",
                'null'=>true,
                'constraint'=>5
            ],
            "task_collaborators"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>500
            ],
            "task_status_id"=>[
                'type'=>"INT",
                'null'=>true,
                'constraint'=>5
            ],
            "task_priority_id"=>[
                'type'=>"INT",
                'null'=>true,
                'constraint'=>5
            ],
            "task_labels_id"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>500
            ],
            "task_start_date"=>[
                'type'=>"DATE",
                'null'=>true,
            ],
            "task_deadline"=>[
                'type'=>"DATE",
                'null'=>true,
            ],
            "requisition_title"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>500
            ],
            "requisition_number"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>500
            ],
            "requisition_remarks"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "schedule_port"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>500
            ],
            "schedule_eta"=>[
                'type'=>"DATE",
                'null'=>true,
            ],
            "schedule_etd"=>[
                'type'=>"DATE",
                'null'=>true,
            ],
            "schedule_agent"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                'constraint'=>500
            ],
            "schedule_remarks"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "deleted"=>[
                'type'=>"TINYINT",
                'null'=>true,
                "default"=>0
            ],
            
            // Add other fields here...
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ticket_actions');
    }

    public function down()
    {
        //
        $this->forge->drop('ticket_actions');
    }
}
