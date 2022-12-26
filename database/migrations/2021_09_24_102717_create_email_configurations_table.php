<?php

use App\EmailConfiguration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_configurations', function (Blueprint $table) {
            $table->id();
            $table->enum("mail_mailer", ['smtp', 'sendmail', 'mailgun'])->default('sendmail');
            $table->string("mail_host")->nullable();
            $table->string("mail_port")->nullable();
            $table->string("mail_username")->nullable();
            $table->string("mail_password")->nullable();
            $table->string("mail_encryption")->default('tls');
            $table->string("mail_from_name")->nullable();
            $table->string("mail_from_address")->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign("created_by")->references("id")->on("admins");
            $table->foreign("updated_by")->references("id")->on("admins");
        });
        
        $this->insertData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_configurations');
    }

    /**
     * Insert Data
     */
    protected function insertData(){
        EmailConfiguration::insert([
            "mail_mailer"       => "smtp",
            "mail_host"         => "smtp.gmail.com",
            "mail_port"         => 587,
            "mail_username"     => "support@regulatedadvice.co.uk",
            "mail_password"     => "siraaomlvmlhwgfd",
            "mail_from_address" => "support@regulatedadvice.co.uk",
        ]);
    }
}
