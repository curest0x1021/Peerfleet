<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnInPfGrommets extends Migration
{
    public function up()
    {

        $fields = [
            'files' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('grommets', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('grommets', 'files');
    }
}
