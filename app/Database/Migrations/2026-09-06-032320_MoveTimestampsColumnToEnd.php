<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MoveTimestampColumnsToEnd extends Migration
{
    protected $table = 'schedule_master'; // <-- replace with your actual table name

    public function up()
    {
        $this->db->query("
            ALTER TABLE `{$this->table}`
            MODIFY COLUMN `created_at` DATETIME NULL AFTER `max_last_catch_up_months`
        ");

        $this->db->query("
            ALTER TABLE `{$this->table}`
            MODIFY COLUMN `updated_at` DATETIME NULL AFTER `created_at`
        ");
    }

    public function down()
    {
        $this->db->query("
            ALTER TABLE `{$this->table}`
            MODIFY COLUMN `created_at` DATETIME NULL AFTER `id`
        ");

        $this->db->query("
            ALTER TABLE `{$this->table}`
            MODIFY COLUMN `updated_at` DATETIME NULL AFTER `created_at`
        ");
    }
}