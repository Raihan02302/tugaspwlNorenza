<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Createusersphp extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id',
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'unique' => true,
                ],
                'password' => [
                    'type' =>  'VARCHAR',
                    'constraint' => '100',
                ],
                'fullname' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],
                'like' => [
                    'type' => 'BOOLEAN',
                    'null' => true,
                ],

            ]
        );
        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);
    }


    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
