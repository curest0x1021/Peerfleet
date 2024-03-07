<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGeneralFilesTable extends Migration
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
            "file_name"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "file_id"=>[
                'type'=>"TEXT",
                'null'=>true,
            ],
            "service_type"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                "constraint"=>200
            ],
            "description"=>[
                'type'=>"MEDIUMTEXT",
                'null'=>true,
            ],
            "file_size"=>[
                'type'=>"DOUBLE",
                'null'=>true,
            ],
            "created_at"=>[
                'type'=>"DATETIME",
                'null'=>true,
            ],
            "client_id"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "user_id"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "uploaded_by"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "folder_id"=>[
                'type'=>"INT",
                'null'=>true,
            ],
            "context"=>[
                'type'=>"VARCHAR",
                'null'=>true,
                "constraint"=>200
            ],
            "context_id"=>[
                'type'=>"INT",
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
        $this->forge->createTable('general_files');
    }

    public function down()
    {
        //
        $this->forge->drop('general_files');
    }
}
