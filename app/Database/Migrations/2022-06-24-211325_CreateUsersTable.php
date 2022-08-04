<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username'          => ['type' => 'varchar', 'constraint' => 255],
            'password'          => ['type' => 'varchar', 'constraint' => 255],
            'email'             => ['type' => 'varchar', 'constraint' => 255],
            'status'            => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'            => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'last_active'       => ['type' => 'datetime', 'null' => true],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users', true);
    }
    
    public function down()
    {
        $this->forge->dropTable('users');
    }
}
