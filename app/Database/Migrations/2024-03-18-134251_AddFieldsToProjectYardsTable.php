<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToProjectYardsTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('project_yards', [
            "deviation_cost"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "loss_of_earnings"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "bunker_cost"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "additional_expenditures"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "total_offhire_period"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "total_repair_period"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "days_in_dry_dock"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "days_at_berth"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "payment_before_departure"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "payment_within_30"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "payment_within_60"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            "payment_within_90"=>[
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            'penalty_per_day' => [
                'type' => 'INT',
                "null"=>true,
                'constraint'=>10
            ],
            'penalty_limit' => [
                'type' => 'INT',
                "null"=>true,
                'constraint'=>3
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('project_yards', 'deviation_cost');
        $this->forge->dropColumn('project_yards', 'loss_of_earnings');
        $this->forge->dropColumn('project_yards', 'bunker_cost');
        $this->forge->dropColumn('project_yards', 'additional_expenditures');
        $this->forge->dropColumn('project_yards', 'total_offhire_period');
        $this->forge->dropColumn('project_yards', 'total_repair_period');
        $this->forge->dropColumn('project_yards', 'days_in_dry_dock');
        $this->forge->dropColumn('project_yards', 'days_at_berth');
        $this->forge->dropColumn('project_yards', 'payment_before_departure');
        $this->forge->dropColumn('project_yards', 'payment_within_30');
        $this->forge->dropColumn('project_yards', 'payment_within_60');
        $this->forge->dropColumn('project_yards', 'payment_within_90');
        $this->forge->dropColumn('project_yards', 'penalty_per_day');
        $this->forge->dropColumn('project_yards', 'penalty_limit');
    }
}
