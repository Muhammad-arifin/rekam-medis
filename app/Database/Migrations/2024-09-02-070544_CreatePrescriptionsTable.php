<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrescriptionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prescription' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_berobat' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_obat' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addKey('id_prescription', true);
        $this->forge->addForeignKey('id_obat', 'obats', 'id_obat', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_berobat', 'kunjungan', 'id_berobat', 'CASCADE', 'CASCADE');
        $this->forge->createTable('prescriptions');
    }

    public function down()
    {
        $this->forge->dropTable('prescriptions');
    }
}
