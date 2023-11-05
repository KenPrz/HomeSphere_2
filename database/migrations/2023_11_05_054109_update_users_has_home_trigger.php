<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class UpdateUsersHasHomeTrigger extends Migration
{
    public function up()
    {
        // Create the trigger
        DB::unprepared('
            CREATE TRIGGER update_users_has_home
            AFTER DELETE ON home_members
            FOR EACH ROW
            BEGIN
                UPDATE users
                SET has_home = 0
                WHERE id = OLD.member_id;
            END
        ');
    }

    public function down()
    {
        // Drop the trigger if necessary
        DB::unprepared('DROP TRIGGER IF EXISTS update_users_has_home');
    }
}

