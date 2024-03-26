<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportDocumentTable extends Migration
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
            "project_id"=>[
                'type'=>"INT",
                'null'=>true,
                "constraint"=>5
            ],
            "title"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "description"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "content"=>[
                'type'=>"LONGTEXT",
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
        $this->forge->createTable('report_documents');
    }

    public function down()
    {
        //
        $this->forge->drop('report_documents');
    }
}
